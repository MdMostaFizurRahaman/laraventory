<?php

namespace App\Http\Controllers\Admin;

use App\Bank;
use Illuminate\Http\Request;
use App\Http\Requests\BankRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
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
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::user()->can(['read-banks'])) {

            $banks = Bank::orderBy('name', 'asc');
            if ($request->get('name')) {
                $banks->where('name', 'LIKE', '%' . $request->get('name') . '%');
            }

            $banks = $banks->paginate(20);

            return view('admin.pages.banks.index', compact('banks'));
        } else {
            return view('error.unauthorized');
        }
    }

    public function create()
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::user()->can(['create-banks'])) {

            return view('admin.pages.banks.create');
        } else {
            return view('error.unauthorized');
        }
    }


    public function store(BankRequest $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::user()->can(['create-banks'])) {

            Bank::create($request->all());
            return redirect()->route('banks.index')->with('success', 'Bank created successfully');
        } else {
            return view('error.unauthorized');
        }
    }

    public function edit(Bank $bank)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::user()->can(['update-banks'])) {

            return view('admin.pages.banks.edit', compact('bank'));
        } else {
            return view('error.unauthorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(BankRequest $request, Bank $bank)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::user()->can(['update-banks'])) {

            $bank->update($request->all());
            return redirect()->route('banks.index')->with('success', 'Bank updated successfully');
        } else {
            return view('error.unauthorized');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::user()->can(['delete-banks'])) {

            $accounts = DB::table('accounts')->where('bank_id', $bank->id)->get();

            if ($accounts->count() > 0) {
                return redirect()->route('banks.index')->with('warning', 'You can not delete it now. There are some accounts associate with it.');
            }

            $bank->delete();
            return redirect()->route('banks.index')->with('success', 'Bank deleted successfully');
        } else {
            return view('error.unauthorized');
        }
    }
}
