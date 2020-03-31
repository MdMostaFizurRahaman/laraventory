<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Product;
use App\Models\ProductTransfer;
use App\Models\ProductTransferItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductTransferController extends Controller {
    public function __construct() {
        $this->middleware('auth:web');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $subdomain) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-product-transfers'])) {
            $productTransfers = ProductTransfer::orderBy('pt_number', 'asc');

            if ($request->get('pt_number')) {
                $productTransfers->where('pt_number', $request->get('pt_number'));
            }

            if ($request->get('branch_id')) {
                $productTransfers->where('branch_id', $request->get('branch_id'));
            }

            if ($request->get('processing_start_date')) {
                $productTransfers->whereDate('processing_date', '>=', $request->get('processing_start_date'));
            }

            if ($request->get('processing_end_date')) {
                $productTransfers->whereDate('processing_date', '<=', $request->get('processing_end_date'));
            }

            if ($request->get('receive_start_date')) {
                $productTransfers->whereDate('expected_receive_date', '>=', $request->get('receive_start_date'));
            }

            if ($request->get('receive_end_date')) {
                $productTransfers->whereDate('expected_receive_date', '<=', $request->get('receive_end_date'));
            }

            $branches = Branch::pluck('name', 'id')->all();

            $productTransfers = $productTransfers->with('branch')->paginate(50);

            return view('client.pages.product-transfers.index', compact('subdomain', 'productTransfers', 'branches'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($subdomain) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-product-transfers'])) {
            $branches = Branch::pluck('name', 'id')->all();

            return view('client.pages.product-transfers.create', compact('subdomain', 'branches'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($subdomain, Request $request) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-product-transfers'])) {
            $messages = [
                'branch_id.required' => 'The Branch field is required.',
                'processing_date.required' => 'The Processing Date field is required.',
                'expected_receive_date.required' => 'The Expected Receive Date field is required.',
            ];

            $this->validate($request, [
                'branch_id' => 'required',
                'processing_date' => 'required',
                'expected_receive_date' => 'required',

            ], $messages);

            $data = $request->all();
            $data['status'] = 0;
            $productTransfer = ProductTransfer::create($data);
            Session::flash('success', 'The Product Transfer has been created');
            return redirect()->route('product-transfers.index', [$subdomain]);
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductTransfer  $productTransfer
     * @return \Illuminate\Http\Response
     */
    public function show($subdomain, ProductTransfer $productTransfer) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-product-transfers'])) {
            return view('client.pages.product-transfers.show', compact('subdomain', 'productTransfer'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductTransfer  $productTransfer
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain, ProductTransfer $productTransfer) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-product-transfers'])) {
            if (!in_array($productTransfer->status, [0, 1])) {
                Session::flash('warning', 'Something went wrong, Please Check Product Transfer status.');
                return redirect()->route('product-transfers.index', $subdomain);
            }
            $branches = Branch::pluck('name', 'id')->all();
            return view('client.pages.product-transfers.edit', compact('subdomain', 'productTransfer', 'branches'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductTransfer  $productTransfer
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain, Request $request, ProductTransfer $productTransfer) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-product-transfers'])) {
            if (!in_array($productTransfer->status, [0])) {
                Session::flash('warning', 'Something went wrong, Please Check Purchase status.');
                return redirect()->route('product-transfers.index', $subdomain);
            }

            if ($request->action === 'save&startProcess') {
                $productTransfer->update($request->except('action') + ['status' => 1]);
                Session::flash('success', 'The Product Transfer has been updated & process start');
            } else {
                $productTransfer->update($request->except('action'));
                Session::flash('success', 'The Product Transfer has been updated');
            }
            return redirect()->route('product-transfers.index', $subdomain);
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductTransfer  $productTransfer
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, ProductTransfer $productTransfer) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['delete-product-transfers'])) {
            if ($productTransfer->status != 0) {
                Session::flash('warning', 'Something went wrong, Please check product transfer status.');
                return redirect()->route('product-transfers.index', $subdomain);
            }
            $productTransfer->delete();
            return redirect()->route('product-transfers.index', $subdomain)->with('success', 'Product Transfer Data deleted successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }

    //Add Product item
    public function addProductCreate($subdomain, $transferId) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-product-transfers'])) {
            $productTransfer = ProductTransfer::findOrFail($transferId);

            if ($productTransfer->status != 1) {
                Session::flash('warning', 'Something went wrong, Please check product transfer status.');
                return redirect()->route('product-transfers.show', [$subdomain, $transferId]);
            }
            $products = Product::whereNotIn('id', function ($query) use ($transferId) {
                $query->select('product_id')
                    ->from('product_transfer_items')
                    ->where('product_transfer_id', $transferId);
            })->pluck('name', 'id')->all();
            $price = null;
            if (old('product_id')) {
                $price = old('quantity') * old('rate');
            }
            return view('client.pages.product-transfers.addProduct', compact('subdomain', 'productTransfer', 'products', 'price'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    public function addProductStore(Request $request, $subdomain, $transferId) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-product-transfers'])) {
            $productTransfer = ProductTransfer::findOrFail($transferId);
            $product = Product::findOrFail($request->product_id);
            if ($productTransfer->status != 1) {
                Session::flash('warning', 'Something went wrong, Please check product transfer status.');
                return redirect()->route('product-transfers.show', [$subdomain, $transferId]);
            }

            $messages = [
                'product_id.required' => 'The Product field is required.',
                'quantity.required' => 'The Quantity field is required.',
                'rate.required' => 'The Rate field is required.',
                'total.required' => 'The Total field is required.',
            ];

            $this->validate($request, [
                'product_id' => 'required',
                'quantity' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($product) {
                        if ($product) {
                            if ($product->is_numeric == 0 && fmod($value, 1) !== 0.00) {
                                $fail('Input quantity should be integer multiplier.');
                            } elseif ($value > $product->quantity) {
                                $fail('You can input max ' . $product->quantity);
                            }
                        }
                    },
                ],
                'rate' => 'required',
                'total' => 'required',

            ], $messages);
            // dd($request->all());
            DB::beginTransaction();
            try {
                $input = $request->all();
                $input['product_transfer_id'] = $transferId;
                $input['client_id'] = Auth::user()->client_id;
                $input['created_by'] = Auth::user()->id;
                //added to item table
                ProductTransferItem::create($input);
                //remove from item
                $product->decrement('quantity', $request->quantity);

                DB::commit();

                Session::flash('success', 'Product Transfer Item added successfully.');
                return redirect()->back();
            } catch (\Exception $e) {
                DB::rollback();
                // dd($e);
                Session::flash('warning', 'Something went wrong');
                return redirect()->back()->withInput();
            }

        } else {
            return view('error.client-unauthorized');
        }
    }

    // productItemDestroy
    public function productItemDestroy($subdomain, $transferId, $id) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-product-transfers'])) {
            $productTransfer = ProductTransfer::findOrFail($transferId);
            if ($productTransfer->status != 1) {
                Session::flash('warning', 'Something went wrong, Please check product transfer status.');
                return redirect()->route('product-transfers.show', [$subdomain, $transferId]);
            }
            DB::beginTransaction();
            try {
                $productTransferItem = ProductTransferItem::findOrFail($id);
                $product = Product::findOrFail($productTransferItem->product_id);
                //add quantity product
                $product->increment('quantity', $productTransferItem->quantity);
                //remove from item
                $productTransferItem->delete();
                DB::commit();

                Session::flash('success', 'Product Transfer Item deleted successfully.');
                return redirect()->back();
            } catch (\Exception $e) {
                DB::rollback();
                // dd($e);
                Session::flash('warning', 'Something went wrong');
                return redirect()->back();
            }
        } else {
            return view('error.client-unauthorized');
        }
    }

    // processCompleted
    //Add Product item
    public function processCompleted($subdomain, $transferId) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-product-transfers'])) {
            $productTransfer = ProductTransfer::findOrFail($transferId);

            if ($productTransfer->status != 1) {
                Session::flash('warning', 'Something went wrong, Please check product transfer status.');
                return redirect()->route('product-transfers.show', [$subdomain, $transferId]);
            }
            $productTransfer->update([
                'process_completed_date' => Carbon::now()->format('Y-m-d'),
                'status' => 2,
            ]);
            Session::flash('success', 'Product Transfer Process has been completed.');
            return redirect()->route('product-transfers.show', [$subdomain, $transferId]);
        } else {
            return view('error.client-unauthorized');
        }
    }

    //Transfer Reject
    public function transferReject($subdomain, $transferId) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-product-transfers'])) {
            $productTransfer = ProductTransfer::findOrFail($transferId);

            if ($productTransfer->status != 2) {
                Session::flash('warning', 'Something went wrong, Please check product transfer status.');
                return redirect()->route('product-transfers.show', [$subdomain, $transferId]);
            }

            return view('client.pages.product-transfers.transferReject', compact('subdomain', 'productTransfer'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    public function transferRejectStore(Request $request, $subdomain, $transferId) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-product-transfers'])) {
            $productTransfer = ProductTransfer::findOrFail($transferId);

            if ($productTransfer->status != 2) {
                Session::flash('warning', 'Something went wrong, Please check product transfer status.');
                return redirect()->route('product-transfers.show', [$subdomain, $transferId]);
            }

            $messages = [
                'rejection_note.required' => 'The Rejection Note field is required.',
            ];

            $this->validate($request, [
                'rejection_note' => 'required',

            ], $messages);
            // dd($request->all());
            DB::beginTransaction();
            try {
                $input = $request->all();
                $input['rejected_by'] = Auth::user()->id;
                $input['status'] = 7;

                //add to in product inventory
                foreach ($productTransfer->productTransferItems()->get() as $item) {
                    $product = Product::findOrFail($item->product_id);
                    $product->increment('quantity', $item->quantity);
                }

                $productTransfer->update($input);
                DB::commit();

                Session::flash('success', 'Product Transfer Rejected successfully.');
                return redirect()->route('product-transfers.show', [$subdomain, $transferId]);
            } catch (\Exception $e) {
                DB::rollback();
                // dd($e);
                Session::flash('warning', 'Something went wrong');
                return redirect()->back()->withInput();
            }

        } else {
            return view('error.client-unauthorized');
        }
    }

    // Get product price for ajax request
    public function getProductPrice($subdomain) {
        $product = Product::where('id', $_POST['product_id'])->first();
        if (!is_null($product)) {
            return $product->sale_price;
        } else {
            return 0;
        }
    }
}
