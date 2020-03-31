<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ExpenseRequest;

class ExpenseController extends Controller
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-expenses'])) {

            $expenses = Expense::orderBy('expense_date', 'desc');

            if ($request->get('expense_start_date')) {
                $expenses->whereDate('expense_date', '>=', $request->get('expense_start_date'));
            }

            if ($request->get('expense_end_date')) {
                $expenses->whereDate('expense_date', '<=', $request->get('expense_end_date'));
            }

            $expenses = $expenses->with('account')->paginate(20);
            return view('client.pages.expenses.index', compact('subdomain', 'expenses'));
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-expenses'])) {
            $accounts = Account::pluck('account_name', 'id')->toArray();
            return view('client.pages.expenses.create', compact('subdomain', 'accounts'));
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
    public function store($subdomain, ExpenseRequest $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-expenses'])) {

            DB::transaction(function () use ($request) {
                $expense = Expense::create($request->except('action'));
                $expense->account->decrement('balance', $expense->amount);
            });

            if ($request->action === 'save&create') {

                return redirect()->route('expenses.create', $subdomain)->with('success', 'Expense added successfully');
            }
            return redirect()->route('expenses.index', $subdomain)->with('success', 'Expense added successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain, Expense $expense)
    {
        // if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-expenses'])) {
        //     $accounts = Account::pluck('account_name', 'id')->toArray();
        //     return view('client.pages.expenses.edit',compact('subdomain', 'accounts', 'expense'));
        // } else {
        //     return view('error.client-unauthorized');
        // }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain, ExpenseRequest $request, Expense $expense)
    {
        // if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-expenses'])) {

        //     DB::transaction(function () use($request, $expense) {
        //         $expense->account->increment('balance', $expense->amount);
        //         $expense->update($request->all());
        //         Account::find($request->account_id)->decrement('balance', $request->amount);

        //     });

        //     return redirect()->route('expenses.index', $subdomain)->with('success', 'Expense updated successfully');
        // } else {
        //     return view('error.client-unauthorized');
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        // if (Auth::user()->hasRole('admin') || Auth::user()->can(['delete-expenses'])) {
        //
        // } else {
        //     return view('error.client-unauthorized');
        // }
    }
}
