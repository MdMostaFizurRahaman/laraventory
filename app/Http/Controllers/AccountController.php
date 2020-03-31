<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AccountRequest;

class AccountController extends Controller
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-accounts'])) {

            $accounts = Account::orderBy('account_name', 'asc');

            if ($request->get('name')) {
                $accounts->where('account_name', 'LIKE', '%' . $request->get('name') . '%');
            }

            if ($request->get('account_number')) {
                $accounts->where('account_number', 'LIKE', '%' . $request->get('account_number') . '%');
            }

            if ($request->get('mobile')) {
                $accounts->where('account_mobile_number', 'LIKE', '%' . $request->get('mobile') . '%');
            }

            if ($request->get('branch_name')) {
                $accounts->where('branch_name', 'LIKE', '%' . $request->get('branch_name') . '%');
            }

            if ($request->get('branch_code')) {
                $accounts->where('branch_code', 'LIKE', '%' . $request->get('branch_code') . '%');
            }

            if ($request->get('bank_id')) {
                $accounts->where('bank_id', $request->get('bank_id'));
            }

            $accounts = $accounts->paginate(20);
            $banks = Bank::pluck('name', 'id')->toArray();
            return view('client.pages.accounts.index', compact('accounts', 'banks', 'subdomain'));
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-accounts'])) {
            $banks = Bank::pluck('name', 'id')->toArray();
            return view('client.pages.accounts.create', compact('subdomain', 'banks'));
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
    public function store($subdomain, AccountRequest $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-accounts'])) {
            Account::create($request->all());
            return redirect()->route('accounts.index', $subdomain)->with('success', 'Account created successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show($subdomain, Account $account)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-accounts'])) {
            return view('client.pages.accounts.show', compact('account', 'subdomain'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain, Account $account)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-accounts'])) {
            $banks = Bank::pluck('name', 'id')->toArray();
            return view('client.pages.accounts.edit', compact('account', 'banks', 'subdomain'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain, AccountRequest $request, Account $account)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-accounts'])) {
            $input = $request->all();

            if (!$request->has('status')) {
                $input['status'] = 0;
            }
            $account->update($input);
            return redirect()->route('accounts.index', $subdomain)->with('success', 'Account updated successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, Account $account)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['delete-accounts'])) {

            if ($account->expenses()->exists()) {
                return redirect()->back()->with('error', 'You can not delete it now. There are some expenses to it.');
            }

            $account->delete();
            return redirect()->route('accounts.index', $subdomain)->with('success', 'Account deleted successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }
}
