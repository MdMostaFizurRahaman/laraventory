<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Branch;
use App\Models\BranchUser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BranchUserController extends Controller
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
    public function index($subdomain)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($subdomain, $branchId)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-branch-users'])) {
            $branchUsers = BranchUser::where('branch_id', $branchId)->get();

            $branch = Branch::findOrFail($branchId);
            $users = User::where('client_id', Auth::user()->client_id)
                ->whereNotIn('id', function ($query) use ($branchId) {
                    $query->select('user_id')
                        ->from(with(new BranchUser)->getTable())
                        ->where('client_id', Auth::user()->client_id)
                        ->where('branch_id', $branchId)
                        ->whereNull('deleted_at');
                })
                ->pluck('name', 'id')->toArray();

            // dd($users);
            return view('client.pages.branch-users.create', compact('branchUsers', 'branch', 'users', 'subdomain'));
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
    public function store($subdomain, $branchId, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-branch-users'])) {
            $messages = [
                'user_id.required' => 'User field is required',
                'user_id.unique' => 'User already exists',
            ];

            $this->validate($request, [
                'user_id' => [
                    'required',
                    Rule::unique('branch_users', 'user_id')->where('branch_id', $branchId)->whereNull('deleted_at'),
                ],
            ], $messages);

            $input = $request->all();
            $input['branch_id'] = $branchId;
            // dd($input);
            $branchUsers = BranchUser::create($input);

            Session::flash('success', 'Branch User created successfully');
            return redirect()->route('branch-users.create', [$subdomain, $branchId]);
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($subdomain, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $subdomain, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain,  $branchId, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['delete-branch-users'])) {
            $branchUser = BranchUser::findOrFail($id);

            $branchUser->delete();
            Session::flash('success', 'Branch User removed successfully');
            return redirect()->route('branch-users.create', [$subdomain, $branchId]);
        } else {
            return view('error.client-unauthorized');
        }
    }
}
