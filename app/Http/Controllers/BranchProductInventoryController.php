<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BranchProductInventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class BranchProductInventoryController extends Controller {
    public function __construct() {
        $this->middleware('auth:web');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $subdomain) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-branch-product-inventories'])) {
            $branchProductInventories = BranchProductInventory::orderBy('branch_id', 'asc');

            if ($request->get('min_stock')) {
                $branchProductInventories->where('quantity', '>=', $request->get('min_stock'));
            }

            if ($request->get('branch_id')) {
                $branchProductInventories->where('branch_id', $request->get('branch_id'));
            }

            if ($request->get('product_id')) {
                $branchProductInventories->where('product_id', $request->get('product_id'));
            }

            $branchProductInventories = $branchProductInventories->with('product', 'branch')->paginate(50);

            $products = Product::get()->pluck('name_code_batch_quantity', 'id')->all();
            $branches = Branch::pluck('name', 'id')->all();

            return view('client.pages.branch-product-inventories.index', compact('branchProductInventories', 'products', 'branches', 'subdomain'));
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($subdomain) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-branch-product-inventories'])) {
            $products = Product::get()->pluck('name_code_batch_quantity', 'id')->all();
            $branches = Branch::pluck('name', 'id')->all();
            return view('client.pages.branch-product-inventories.create', compact('products', 'branches', 'subdomain'));
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $subdomain) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-branch-product-inventories'])) {
            $messages = [
                'product_id.required' => 'The Product field is required.',
                'product_id.unique' => 'The Product has already been taken for your selected branch.',
                'branch_id.required' => 'The Branch field is required.',
                'sale_price.required' => 'The Sale Price field is required.',
                'alert_quantity.required' => 'The Alert Quantity field is required.',
                'vat.required' => 'The Vat field is required.',
            ];

            $this->validate($request, [
                'branch_id' => 'required',
                'product_id' => [
                    'required',
                    Rule::unique('branch_product_inventories')->where('branch_id', $request->branch_id)->whereNull('deleted_at'),
                ],
                'sale_price' => 'required',
                'alert_quantity' => 'required',
                'vat' => 'required',

            ], $messages);

            $data = $request->all();

            BranchProductInventory::create($data);
            return redirect()->route('branch-product-inventories.index', $subdomain)->with('success', 'Branch Product created successfully');
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BranchProductInventory  $branchProductInventory
     * @return \Illuminate\Http\Response
     */
    public function show($subdomain, BranchProductInventory $branchProductInventory) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-branch-product-inventories'])) {
            return view('client.pages.branch-product-inventories.show', compact('subdomain', 'branchProductInventory'));
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BranchProductInventory  $branchProductInventory
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain, BranchProductInventory $branchProductInventory) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-branch-product-inventories'])) {
            $products = Product::get()->pluck('name_code_batch_quantity', 'id')->all();
            $branches = Branch::pluck('name', 'id')->all();
            return view('client.pages.branch-product-inventories.edit', compact('subdomain', 'products', 'branches', 'branchProductInventory'));
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BranchProductInventory  $branchProductInventory
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain, Request $request, BranchProductInventory $branchProductInventory) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-branch-product-inventories'])) {
            $messages = [
                'product_id.required' => 'The Product field is required.',
                'product_id.unique' => 'The Product has already been taken for your selected branch.',
                'branch_id.required' => 'The Branch field is required.',
                'sale_price.required' => 'The Sale Price field is required.',
                'quantity.required' => 'The Quantity field is required.',
                'alert_quantity.required' => 'The Alert Quantity field is required.',
                'vat.required' => 'The Vat field is required.',
            ];

            $this->validate($request, [
                'branch_id' => 'required',
                'product_id' => [
                    'required',
                    Rule::unique('branch_product_inventories')->where('branch_id', $request->branch_id)->whereNull('deleted_at')->ignore($branchProductInventory->id),
                ],
                'sale_price' => 'required',
                'quantity' => 'required',
                'alert_quantity' => 'required',
                'vat' => 'required',

            ], $messages);
            $data = $request->only('sale_price', 'quantity', 'alert_quantity', 'vat', 'status');
            if (!$request->has('status')) {
                $data['status'] = 0;
            }

            $branchProductInventory->update($data);
            return redirect()->route('branch-product-inventories.index', $subdomain)->with('success', 'Branch Product updated successfully');
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BranchProductInventory  $branchProductInventory
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, BranchProductInventory $branchProductInventory) {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['delete-branch-product-inventories'])) {
            if ($branchProductInventory->quantity > 0) {
                Session::flash('warning', 'There are quantity associate in this product inventory, Please at first remove the quantity and try again.');
                return redirect()->back();
            }
            $branchProductInventory->delete();
            return redirect()->route('branch-product-inventories.index', $subdomain)->with('success', 'Branch Product deleted successfully');
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }
}
