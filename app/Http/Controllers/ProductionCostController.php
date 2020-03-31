<?php

namespace App\Http\Controllers;

use App\Models\Production;
use Illuminate\Http\Request;
use App\Models\ProductionCost;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductionCostCategory;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ProductionCostRequest;

class ProductionCostController extends Controller
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($subdomain, Production $production)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-production-costs'])) {
            $categories = ProductionCostCategory::pluck('name', 'id')->toArray();
            return view('client.pages.production-costs.create', compact('subdomain', 'production', 'categories'));
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
    public function store($subdomain, ProductionCostRequest $request, Production $production)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-production-costs'])) {

            if ($production->status <> 0) {
                Session::flash('warning', 'Sorry! Something went wrong, Please check production status.');
                return redirect()->route('productions.show', [$subdomain, $production->id]);
            }

            ProductionCost::create($request->all() + ['production_id' => $production->id]);
            return redirect()->route('productions.show', [$subdomain, $production->id])->with('success', "Cost added successfully");
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductionCost  $productionCost
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain,  Production $production, ProductionCost $cost)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['edit-production-costs'])) {

            if ($production->status <> 0) {
                Session::flash('warning', 'Sorry! Something went wrong, Please check production status.');
                return redirect()->route('productions.show', [$subdomain, $production->id]);
            }

            $categories = ProductionCostCategory::pluck('name', 'id')->toArray();
            return view('client.pages.production-costs.edit', compact('subdomain', 'production', 'categories', 'cost'));
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductionCost  $productionCost
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain, ProductionCostRequest $request, Production $production, ProductionCost $cost)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['edit-production-costs'])) {
            if ($production->status <> 0) {
                Session::flash('warning', 'Sorry! Something went wrong, Please check production status.');
                return redirect()->route('productions.show', [$subdomain, $production->id]);
            }
            $cost->update($request->all());
            return redirect()->route('productions.show', [$subdomain, $production->id])->with('success', "Cost updated successfully");
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductionCost  $productionCost
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, Production $production, ProductionCost $cost)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['delete-production-costs'])) {
            $cost->delete();

            if ($production->status <> 0) {
                Session::flash('warning', 'Sorry! Something went wrong, Please check production status.');
                return redirect()->back();
            }

            return redirect()->route('productions.show', [$subdomain, $production->id])->with('success', "Cost deleted successfully");
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }
}
