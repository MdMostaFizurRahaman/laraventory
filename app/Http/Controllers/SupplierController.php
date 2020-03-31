<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SupplierRequest;

class SupplierController extends Controller
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-suppliers'])) {
            $suppliers = Supplier::orderBy('name', 'asc');

            if ($request->get('name')) {
                $suppliers->where('name', 'LIKE', '%' . $request->get('name') . '%');
            }

            if ($request->get('email')) {
                $suppliers->where('email', 'LIKE', '%' . $request->get('email') . '%');
            }

            if ($request->get('mobile')) {
                $suppliers->where('mobile', 'LIKE', '%' . $request->get('mobile') . '%');
            }

            if ($request->get('company')) {
                $suppliers->where('company', 'LIKE', '%' . $request->get('company') . '%');
            }

            $suppliers = $suppliers->paginate(20);

            return view('client.pages.suppliers.index', compact('suppliers', 'subdomain'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($subdomain)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-suppliers'])) {
            return view('client.pages.suppliers.create', compact('subdomain'));
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
    public function store($subdomain, SupplierRequest $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-suppliers'])) {
            $data = $request->all();
            if (is_null($request->opening_balance)) {
                $data['opening_balance'] = 0;
            }
            Supplier::create($data);
            return redirect()->route('suppliers.index', $subdomain)->with('success', 'Supplier created successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show($subdomain, Supplier $supplier)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-suppliers'])) {
            return view('client.pages.suppliers.show', compact('supplier', 'subdomain'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Edit the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain, Supplier $supplier)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-suppliers'])) {
            return view('client.pages.suppliers.edit', compact('supplier', 'subdomain'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain, SupplierRequest $request, Supplier $supplier)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-suppliers'])) {
            $data = $request->all();
            if (is_null($request->opening_balance)) {
                $data['opening_balance'] = 0;
            }
            $supplier->update($data);
            return redirect()->route('suppliers.index', $subdomain)->with('success', 'Supplier updated successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, Supplier $supplier)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['delete-suppliers'])) {
            $supplier->delete();
            return redirect()->route('suppliers.index', $subdomain)->with('success', 'Supplier Deleted Successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }
}
