@extends('layouts.client')

@section('title')
Roles
@endsection

@section('content')

<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Role List</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        @include('massages.success')
        @include('massages.error')
        @include('massages.warning')
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    {!! Form::open(['method'=>'GET', 'action'=>['RoleController@index',$subdomain]]) !!}

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('display_name', 'Name') !!}
                                    {!! Form::text('display_name', request()->display_name, ['class'=>'form-control'])
                                    !!}
                                </div>
                            </div>

                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <button type="submit" class="btn btn-primary"> Filter </button>
                    </div>
                    {!! Form::close() !!}

                    <div class="card-header">
                        <h3 class="card-title">Role List</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th style="min-width:50px;">No</th>
                                <th style="min-width:50px;">Name</th>
                                <th style="min-width:50px;">Description</th>
                                <th style="min-width:50px;">Created At</th>
                                <th style="min-width:50px;">Updated At</th>
                                <th style="min-width:150px;">Actions</th>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                <tr>
                                    <td>{{$role->id}}</td>
                                    <td>{{$role->display_name}}</td>
                                    <td>{{$role->description}}</td>
                                    <td>{{ $role->created_at->diffForHumans() }}</td>
                                    <td>{{ $role->updated_at->diffForHumans() }}</td>
                                    <td>
                                        @if ($role->name !== 'admin')
                                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('update-roles'))
                                        <a href="{{route('roles.edit', [$subdomain, $role->id])}}"
                                            class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                        @endif

                                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('delete-roles'))
                                        @if(!in_array($role->id,$userRoles))
                                        <a href="#" class="btn btn-danger btn-sm"
                                            onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $role->id }}').submit(); } event.returnValue = false; return false;"
                                            title="Delete"><i class="fa fa-trash"></i></a>
                                        {!! Form::open(['method'=>'DELETE',
                                        'action'=>['RoleController@destroy',$subdomain, $role->id],
                                        'id'=>'deleteForm'.$role->id]) !!}
                                        {!! Form::close() !!}
                                        @endif
                                        @endif

                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer pb-0">
                        <ul class="pagination pagination-sm m-0 float-right">
                            Page {{ $roles->currentPage() }} , showing {{ $roles->count() }}
                            records out of {{ $roles->total() }} total
                        </ul>
                    </div>
                    <div class="card-footer py-2">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $roles->appends(request()->all())->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
