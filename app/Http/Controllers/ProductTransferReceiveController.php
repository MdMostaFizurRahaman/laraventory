<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Product;
use App\Models\ProductTransfer;
use App\Models\ProductTransferReceive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductTransferReceiveController extends Controller {
    public function __construct() {
        $this->middleware('auth:web');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $subdomain) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-product-transfer-receives'])) {
            $productTransfers = ProductTransfer::where('status', '>=', 2)->orderBy('pt_number', 'asc')->orderBy('status', 'asc');

            if ($request->get('pt_number')) {
                $productTransfers->where('pt_number', $request->get('pt_number'));
            }

            if ($request->get('branch_id')) {
                $productTransfers->where('branch_id', $request->get('branch_id'));
            }

            if ($request->get('receive_start_date')) {
                $productTransfers->whereDate('expected_receive_date', '>=', $request->get('receive_start_date'));
            }

            if ($request->get('receive_end_date')) {
                $productTransfers->whereDate('expected_receive_date', '<=', $request->get('receive_end_date'));
            }

            if ($request->get('received_start_date')) {
                $productTransfers->whereDate('received_date', '>=', $request->get('received_start_date'));
            }

            if ($request->get('received_end_date')) {
                $productTransfers->whereDate('received_date', '<=', $request->get('received_end_date'));
            }

            $branches = Branch::pluck('name', 'id')->all();

            $productTransfers = $productTransfers->with('branch')->paginate(50);

            return view('client.pages.product-transfer-receives.index', compact('subdomain', 'productTransfers', 'branches'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductTransferReceive  $productTransferReceive
     * @return \Illuminate\Http\Response
     */
    public function show($subdomain, $transferId) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-product-transfer-receives'])) {
            $productTransfer = ProductTransfer::findOrFail($transferId);
            return view('client.pages.product-transfer-receives.show', compact('subdomain', 'productTransfer'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductTransferReceive  $productTransferReceive
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductTransferReceive $productTransferReceive) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductTransferReceive  $productTransferReceive
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductTransferReceive $productTransferReceive) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductTransferReceive  $productTransferReceive
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductTransferReceive $productTransferReceive) {
        //
    }

    //Transfer Reject
    public function receivedReject($subdomain, $transferId) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-product-transfer-receives'])) {
            $productTransfer = ProductTransfer::findOrFail($transferId);

            if ($productTransfer->status != 2) {
                Session::flash('warning', 'Something went wrong, Please check product transfer status.');
                return redirect()->route('product-transfer-receives.show', [$subdomain, $transferId]);
            }

            return view('client.pages.product-transfer-receives.receivedReject', compact('subdomain', 'productTransfer'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    public function receivedRejectStore(Request $request, $subdomain, $transferId) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-product-transfer-receives'])) {
            $productTransfer = ProductTransfer::findOrFail($transferId);

            if ($productTransfer->status != 2) {
                Session::flash('warning', 'Something went wrong, Please check product transfer status.');
                return redirect()->route('product-transfer-receives.show', [$subdomain, $transferId]);
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
                $input['status'] = 6;

                //add to in product inventory
                foreach ($productTransfer->productTransferItems()->get() as $item) {
                    $product = Product::findOrFail($item->product_id);
                    $product->increment('quantity', $item->quantity);
                }

                $productTransfer->update($input);
                DB::commit();

                Session::flash('success', 'Product Transfer Rejected successfully.');
                return redirect()->route('product-transfer-receives.show', [$subdomain, $transferId]);
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
}
