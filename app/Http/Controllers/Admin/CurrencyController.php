<?php

namespace App\Http\Controllers\Admin;

use App\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CurrencyRequest;

class CurrencyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::user()->can(['read-currencies'])) {

            $currencies = Currency::orderBy('name', 'asc');
            if ($request->get('name')) {
                $currencies->where('name', 'LIKE', '%' . $request->get('name') . '%');
            }

            if ($request->get('symbol')) {
                $currencies->where('symbol', 'LIKE', '%' . $request->get('symbol') . '%');
            }

            $currencies = $currencies->paginate(20);

            return view('admin.pages.currencies.index', compact('currencies'));
        } else {
            return view('error.unauthorized');
        }
    }

    public function create()
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::user()->can(['create-currencies'])) {

            return view('admin.pages.currencies.create');
        } else {
            return view('error.unauthorized');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CurrencyRequest $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::user()->can(['create-currencies'])) {

            Currency::create($request->all());
            return redirect()->route('currencies.index')->with('success', 'Currency created successfully');
        } else {
            return view('error.unauthorized');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::user()->can(['update-currencies'])) {

            return view('admin.pages.currencies.edit', compact('currency'));
        } else {
            return view('error.unauthorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(CurrencyRequest $request, Currency $currency)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::user()->can(['update-currencies'])) {

            $currency->update($request->all());
            return redirect()->route('currencies.index')->with('success', 'Currency updated successfully');
        } else {
            return view('error.unauthorized');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::user()->can(['delete-currencies'])) {
            $currency->delete();
            return redirect()->route('currencies.index')->with('success', 'Currency deleted successfully');
        } else {
            return view('error.unauthorized');
        }
    }
}
