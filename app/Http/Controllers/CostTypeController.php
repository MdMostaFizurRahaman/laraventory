<?php

namespace App\Http\Controllers;

use App\Models\CostType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CostTypeRequest;

class CostTypeController extends Controller
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-cost-types'])) {

            $costTypes = CostType::orderBy('name', 'asc');
            if ($request->get('name')) {
                $costTypes->where('name', 'LIKE', '%' . $request->get('name') . '%');
            }

            $costTypes = $costTypes->paginate(20);

            return view('client.pages.cost-types.index', compact('costTypes', 'subdomain'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    public function create($subdomain)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-cost-types'])) {

            return view('client.pages.cost-types.create', compact('subdomain'));
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
    public function store($subdomain, CostTypeRequest $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-cost-types'])) {

            CostType::create($request->all() + ['client_id' => Auth::user()->clientId]);
            return redirect()->route('cost-types.index', $subdomain)->with('success', 'Cost type created successfully.');
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CostType  $costType
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain, CostType $costType)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-cost-types'])) {

            return view('client.pages.cost-types.edit', compact('subdomain', 'costType'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CostType  $costType
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain, CostTypeRequest $request, CostType $costType)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-cost-types'])) {

            $costType->update($request->all());
            return redirect()->route('cost-types.index', $subdomain)->with('success', 'Cost type updated successfully.');
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CostType  $costType
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, CostType $costType)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['delete-cost-types'])) {

            if ($costType->costs()->exists()) {
                return redirect()->route('cost-types.index', $subdomain)->with('error', 'You can not delete it now. There are some costs related to it');
            }

            $costType->delete();
            return redirect()->route('cost-types.index', $subdomain)->with('success', 'Cost type deleted successfully.');
        } else {
            return view('error.client-unauthorized');
        }
    }
}
