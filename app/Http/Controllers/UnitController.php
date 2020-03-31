<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Requests\UnitRequest;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-units'])) {

            $units = Unit::orderBy('display_name', 'asc');

            if ($request->get('name')) {
                $units->where('name', 'LIKE', '%' . $request->get('name') . '%');
            }

            if ($request->get('display_name')) {
                $units->where('display_name', 'LIKE', '%' . $request->get('display_name') . '%');
            }

            $units = $units->with('materials', 'products')->paginate(50);

            return view('client.pages.units.index', compact('units', 'subdomain'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    public function create($subdomain)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-units'])) {

            return view('client.pages.units.create', compact('subdomain'));
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
    public function store($subdomain, UnitRequest $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-units'])) {
            $data = $request->all();
            $data['client_id'] = Auth::user()->client_id;
            Unit::create($data);
            return redirect()->route('units.index', $subdomain)->with('success', 'Unit created successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain, Unit $unit)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-units'])) {
            // dd($unit);
            return view('client.pages.units.edit', compact('unit', 'subdomain'));
        } else {
            return view('error.client-unauthorized');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain, UnitRequest $request, Unit $unit)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-units'])) {
            $unit->update($request->all());
            return redirect()->route('units.index', $subdomain)->with('success', 'Unit updated successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, Unit $unit)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['delete-units'])) {

            if ($unit->materials()->exists()) {
                return redirect()->route('units.index', $subdomain)->with('error', 'You can not delete it now. There are some materials associate with it.');
            }

            if ($unit->products()->exists()) {
                return redirect()->route('units.index', $subdomain)->with('error', 'You can not delete it now. There are some products associate with it.');
            }

            $unit->delete();
            return redirect()->route('units.index', $subdomain)->with('success', 'Unit deleted successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }
}
