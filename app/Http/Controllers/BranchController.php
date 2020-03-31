<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Requests\BranchRequest;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-branches'])) {

            $branches = Branch::orderBy('name', 'asc');

            if ($request->get('name')) {
                $branches->where('name', 'LIKE', '%' . $request->get('name') . '%');
            }

            if ($request->get('mobile')) {
                $branches->where('mobile', 'LIKE', '%' . $request->get('mobile') . '%');
            }

            if ($request->get('email')) {
                $branches->where('email', 'LIKE', '%' . $request->get('email') . '%');
            }

            $branches = $branches->with('manager')->paginate(20);

            return view('client.pages.branches.index', compact('branches', 'subdomain'));
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-branches'])) {
            $users = User::where('client_id', Auth::user()->client_id)->pluck('name', 'id')->toArray();
            return view('client.pages.branches.create', compact('users', 'subdomain'));
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
    public function store($subdomain, BranchRequest $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-branches'])) {
            Branch::create($request->all());
            return redirect()->route('branches.index', $subdomain)->with('success', 'Branch created successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show($subdomain, Branch $branch)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-branches'])) {
            return view('client.pages.branches.show', compact('branch', 'subdomain'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain, Branch $branch)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-branches'])) {
            $users = User::where('client_id', Auth::user()->client_id)->pluck('name', 'id')->toArray();
            return view('client.pages.branches.edit', compact('branch', 'users', 'subdomain'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain, BranchRequest $request, Branch $branch)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-branches'])) {

            $branch->update($request->all());
            return redirect()->route('branches.index', $subdomain)->with('success', 'Branch udated successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, Branch $branch)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['delete-branches'])) {

            $branch->delete();
            return redirect()->route('branches.index', $subdomain)->with('success', 'Branch deleted successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }
}
