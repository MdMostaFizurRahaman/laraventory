<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use App\Models\CostType;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Http\Requests\CostRequest;
use Illuminate\Support\Facades\Auth;

class CostController extends Controller
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-costs'])) {

            $costs = Cost::orderBy('created_at', 'asc');

            if ($request->get('cost_type_id')) {
                $costs->where('cost_type_id', $request->get('cost_type_id'));
            }
            if ($request->get('purchase_id')) {
                $costs->where('purchase_id', $request->get('purchase_id'));
            }


            $costTypes = CostType::whereIn('id', $costs->pluck('cost_type_id', 'cost_type_id')->all())->pluck('name', 'id')->all();
            $purchases = Purchase::whereIn('id', $costs->pluck('purchase_id', 'purchase_id')->all())->pluck('po_number', 'id')->all();

            $costs = $costs->with('costType', 'purchase')->paginate(20);
            return view('client.pages.costs.index', compact('costs', 'subdomain', 'costTypes', 'purchases'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    public function create($subdomain)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-costs'])) {

            $costTypes = CostType::pluck('name', 'id')->toArray();
            $purchases = Purchase::where('status', '>=', 5)->pluck('po_number', 'id')->toArray();
            return view('client.pages.costs.create', compact('subdomain', 'costTypes', 'purchases'));
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

    public function store($subdomain, CostRequest $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-costs'])) {

            Cost::create($request->all() + ['client_id' => Auth::user()->id]);
            return redirect()->route('costs.index', $subdomain)->with('success', 'Cost added successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain, Cost $cost)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-costs'])) {
            $costs = Cost::paginate(10);
            $costTypes = CostType::pluck('name', 'id')->toArray();
            $purchases = Purchase::where('status', '>=', 5)->pluck('po_number', 'id')->toArray();
            return view('client.pages.costs.edit', compact('costs', 'subdomain', 'costTypes', 'purchases', 'cost'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain, CostRequest $request, Cost $cost)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-costs'])) {

            $cost->update($request->all());
            return redirect()->route('costs.index', $subdomain)->with('success', 'Cost updated successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, Cost $cost)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['delete-costs'])) {

            $cost->delete();
            return redirect()->route('costs.index', $subdomain)->with('success', 'Cost deleted successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }
}
