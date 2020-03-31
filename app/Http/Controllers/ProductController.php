<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Helpers\Helper;
use App\Models\Product;
use App\Currency;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Config;

class ProductController extends Controller
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
    public function index(Request $request, $subdomain)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-products'])) {
            $products = Product::orderBy('name', 'asc');

            if ($request->get('name')) {
                $products->where('name', 'LIKE', '%' . $request->get('name') . '%');
            }

            if ($request->get('code')) {
                $products->where('code', 'LIKE', '%' . $request->get('code') . '%');
            }

            if ($request->get('category_id')) {
                $products->where('category_id', $request->get('category_id'));
            }

            if ($request->get('unit_id')) {
                $products->where('unit_id', $request->get('unit_id'));
            }

            if ($request->get('currency_id')) {
                $products->where('currency_id', $request->get('currency_id'));
            }

            $products = $products->with('category', 'currency', 'unit')->paginate(50);

            $categories = ProductCategory::pluck('name', 'id')->toArray();
            $units = Unit::pluck('name', 'id')->toArray();
            $currencies = Currency::pluck('name', 'id')->toArray();

            return view('client.pages.products.index', compact('products', 'categories', 'units', 'currencies', 'subdomain'));
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($subdomain)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-products'])) {
            $categories = ProductCategory::pluck('name', 'id')->toArray();
            $units = Unit::pluck('name', 'id')->toArray();
            $currencies = Currency::pluck('name', 'id')->toArray();
            return view('client.pages.products.create', compact('categories', 'units', 'currencies', 'subdomain'));
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
    public function store($subdomain, ProductRequest $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-products'])) {

            $data = $request->all();

            if ($request->file('image')) {
                $imagePath = Helper::uploadFile($request->file('image'), null, Config::get('constant.PRODUCT_IMAGE'));
                $data['image'] = $imagePath;
            }

            Product::create($data);
            return redirect()->route('products.index', $subdomain)->with('success', 'Product created successfully');
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($subdomain, Product $product)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-products'])) {

            return view('client.pages.products.show', compact('subdomain', 'product'));
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain, Product $product)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-products'])) {

            $categories = ProductCategory::pluck('name', 'id')->toArray();
            $units = Unit::pluck('name', 'id')->toArray();
            $currencies = Currency::pluck('name', 'id')->toArray();
            return view('client.pages.products.edit', compact('subdomain', 'product', 'categories', 'units', 'currencies'));
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain, ProductRequest $request, Product $product)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-products'])) {
            $data = $request->all();
            if (!$request->has('is_numeric')) {
                $data['is_numeric'] = 0;
            }
            if ($request->file('image')) {
                $imagePath = Helper::uploadFile($request->file('image'), null, Config::get('constant.PRODUCT_IMAGE'));
                $data['image'] = $imagePath;
            }

            $product->update($data);
            return redirect()->route('products.index', $subdomain)->with('success', 'Product updated successfully');
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, Product $product)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['delete-products'])) {
            $product->delete();
            return redirect()->route('products.index', $subdomain)->with('success', 'Product deleted successfully');
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }
}
