<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Permission;
use App\PermissionGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PermissionController extends Controller
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
    public function index()
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['read-client-permissions'])) {

            $permissions = PermissionGroup::where('type', 'client')->where('status', true)->paginate(50);
            return view('admin.pages.permissions.index', compact('permissions'));
        } else {
            return view('error.unauthorized');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['create-client-permissions'])) {

            $usedPermissionId = DB::table('permission_group_permission')->distinct('permission_id')->pluck('permission_id')->toArray();
            $permissions = Permission::whereNotIn('id', $usedPermissionId)->where('type', 'client')->get();
            return view('admin.pages.permissions.create', compact('permissions'));
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
    public function store(PermissionRequest $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['create-client-permissions'])) {
            $permission = PermissionGroup::create([
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status ? 1 : 0,
            ]);

            if ($request->permissions) {
                $permission->permissions()->sync($request->permissions);
            }

            return redirect()->route('permissions.index')->with('success', 'Permission group created successfully');
        } else {
            return view('error.unauthorized');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PermissionGroup $permission)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['update-client-permissions'])) {

            return view('admin.pages.permissions.edit', compact('permission'));
        } else {
            return view('error.unauthorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, PermissionGroup $permission)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['update-client-permissions'])) {

            $permission->update([
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status ? 1 : 0,
            ]);

            $permission->permissions()->sync($request->permissions);
            return redirect()->route('permissions.index')->with('success', 'Permission group updated successfully');
        } else {
            return view('error.unauthorized');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PermissionGroup $permission)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['delete-client-permissions'])) {

            $permission->permissions()->sync([]);
            $permission->delete();
            return redirect()->route('permissions.index')->with('success', 'Permission group deleted successfully');
        } else {
            return view('error.unauthorized');
        }
    }
}
