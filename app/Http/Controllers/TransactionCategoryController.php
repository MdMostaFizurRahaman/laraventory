<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionCategory;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TransactionCategoryRequest;

class TransactionCategoryController extends Controller
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-transaction-categories'])) {

            $categories = TransactionCategory::orderBy('name', 'asc');
            if ($request->get('name')) {
                $categories->where('name', 'LIKE', '%' . $request->get('name') . '%');
            }

            $categories = $categories->paginate(20);
            return view('client.pages.transaction-categories.index', compact('categories', 'subdomain'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    public function create($subdomain)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-transaction-categories'])) {

            return view('client.pages.transaction-categories.create', compact('subdomain'));
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
    public function store($subdomain, TransactionCategoryRequest $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-transaction-categories'])) {

            TransactionCategory::create($request->all() + ['client_id' => Auth::user()->clientId]);
            return redirect()->route('transaction-categories.index', $subdomain)->with('success', 'Category created successfully');
        } else {
            abort(403);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransactionCategory  $transactionCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain, TransactionCategory $transactionCategory)
    {

        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-transaction-categories'])) {

            return view('client.pages.transaction-categories.edit', compact('transactionCategory', 'subdomain'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TransactionCategory  $transactionCategory
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain, TransactionCategoryRequest $request, TransactionCategory $transactionCategory)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-transaction-categories'])) {

            $transactionCategory->update($request->all() + ['status' => $request->status ?? 0]);
            return redirect()->route('transaction-categories.index', $subdomain)->with('success', 'Category updated successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransactionCategory  $transactionCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransactionCategory $transactionCategory)
    {
        //
    }
}
