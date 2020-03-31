<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductionCostCategory;
use App\Http\Requests\ProductionCostCategoryRequest;

class ProductionCostCategoryController extends Controller
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-production-cost-categories'])) {
            $categories = ProductionCostCategory::orderBy('name', 'asc');
            if ($request->get('name')) {
                $categories->where('name', 'LIKE', '%' . $request->get('name') . '%');
            }

            $categories = $categories->paginate(20);


            return view('client.pages.production-cost-categories.index', compact('subdomain', 'categories'));
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-production-cost-categories'])) {

            return view('client.pages.production-cost-categories.create', compact('subdomain'));
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
    public function store($subdomain, ProductionCostCategoryRequest $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-production-cost-categories'])) {

            ProductionCostCategory::create($request->all() + ['client_id' => Auth::user()->clientId]);
            return redirect()->route('production-cost-categories.index', $subdomain)->with('success', 'Cost Category created successfully.');
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CostType  $costType
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain, ProductionCostCategory $productionCostCategory)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-production-cost-categories'])) {
            return view('client.pages.production-cost-categories.edit', compact('subdomain'))->with('category', $productionCostCategory);
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CostType  $costType
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain, ProductionCostCategoryRequest $request, ProductionCostCategory $productionCostCategory)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-production-cost-categories'])) {

            $productionCostCategory->update($request->all());
            return redirect()->route('production-cost-categories.index', $subdomain)->with('success', 'Cost Category updated successfully.');
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CostType  $costType
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, ProductionCostCategory $productionCostCategory)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['delete-production-cost-categories'])) {
            if ($productionCostCategory->productionCosts()->exists()) {
                return redirect()->route('production-cost-categories.index', $subdomain)->with('warning', 'You can not delete it now. There are some costs related to it');
            }

            $productionCostCategory->delete();
            return redirect()->route('production-cost-categories.index', $subdomain)->with('success', 'Cost Category deleted successfully.');
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }
}
