<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductCategoryRequest;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($subdomain, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-product-categories'])) {

            $categories = ProductCategory::orderBy('name', 'ASC');

            if ($request->get('name')) {
                $categories->where('name', 'LIKE', '%' . $request->get('name') . '%');
            }

            $categories = $categories->paginate(20);
            return view('client.pages.product-categories.index', compact('categories', 'subdomain'));
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    public function create($subdomain)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-product-categories'])) {

            return view('client.pages.product-categories.create', compact('subdomain'));
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
    public function store($subdomain, ProductCategoryRequest $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-product-categories'])) {

            ProductCategory::create($request->all() + ['client_id' => Auth::user()->clientId]);
            return redirect()->route('product-categories.index', $subdomain)->with('success', 'Product category created Successfully');
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain, ProductCategory $productCategory)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-product-categories'])) {

            $categories = ProductCategory::findOrFail($productCategory->id);
            return view('client.pages.product-categories.edit', compact('subdomain','categories'));
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain, ProductCategoryRequest $request, ProductCategory $productCategory)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-product-categories'])) {

            $productCategory->update($request->all());
            return redirect()->route('product-categories.index', $subdomain)->with('success', 'Product category updated Successfully');
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, ProductCategory $productCategory)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['delete-product-categories'])) {

            $productCategory->delete();
            return redirect()->route('product-categories.index', $subdomain)->with('success', 'Product category deleted Successfully');
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }
}
