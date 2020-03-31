@extends('layouts.admin')

@section('title')
Permissions
@endsection

@section('content')

<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Permission Groups List</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        @include('massages.success')
        @include('massages.error')
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <th>No</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                <tr>
                                    <td>{{$permission->id}}</td>
                                    <td>{{$permission->name}}</td>
                                    <td>{{$permission->description}}</td>
                                    <td>{{$permission->created_at->diffForHumans()}}</td>
                                    <td>{{$permission->updated_at->diffForHumans()}}</td>
                                    <td>
                                        @if(Auth::guard('admin')->user()->hasRole('admin') ||
                                        Auth::guard('admin')->user()->can('update-admin-permissions'))
                                        <a data-toggle="tooltip" title="Edit"
                                            href="{{route('admin-permissions.edit', $permission->id)}}"
                                            class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        @endif

                                        @if(Auth::guard('admin')->user()->hasRole('admin') ||
                                        Auth::guard('admin')->user()->can('delete-admin-permissions'))
                                        <a href="#" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-sm"
                                            onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $permission->id }}').submit(); } event.returnValue = false; return false;"><i
                                                class="fa fa-trash"></i> </a>
                                        {!! Form::open(['method'=>'DELETE',
                                        'action'=>['Admin\AdminPermissionController@destroy', $permission->id],
                                        'id'=>'deleteForm'.$permission->id]) !!}
                                        {!! Form::close() !!}
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer pb-0">
                        <ul class="pagination pagination-sm m-0 float-right">
                            Page {{ $permissions->currentPage() }} , showing {{ $permissions->count() }}
                            records out of {{ $permissions->total() }} total
                        </ul>
                    </div>
                    <div class="card-footer py-2">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $permissions->appends(request()->all())->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
