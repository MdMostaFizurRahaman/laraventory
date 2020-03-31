@extends('layouts.client')

@section('title')
Users
@endsection


@section('content')

<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">User List</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        @include('massages.success')
        @include('massages.error')
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    {!! Form::open(['method'=>'GET', 'action'=>['UserController@index',$subdomain]]) !!}

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('name', 'Name') !!}
                                    {!! Form::text('name', request()->name, ['class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('email', 'Email') !!}
                                    {!! Form::text('email', request()->email, ['class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('mobile', 'Mobile') !!}
                                    {!! Form::text('mobile', request()->mobile, ['class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label("role_id", 'Role') !!}
                                    {!! Form::select('role_id',['0' => 'All'] + $roles, request()->role_id, ['class' =>
                                    'form-control select2']) !!}
                                </div>
                            </div>

                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <button type="submit" class="btn btn-primary"> Filter </button>
                    </div>
                    {!! Form::close() !!}

                    <div class="card-header">
                        <h3 class="card-title">User List</h3>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th style="min-width:50px;">No</th>
                                <th style="min-width:50px;">Name</th>
                                <th style="min-width:50px;">Role</th>
                                <th style="min-width:50px;">Mobile</th>
                                <th style="min-width:50px;">Email</th>
                                <th style="min-width:150px;">Address</th>
                                <th style="min-width:50px;">Status</th>
                                <th style="min-width:50px;">Created At</th>
                                <th style="min-width:50px;">Updated At</th>
                                <th style="min-width:150px;">Actions</th>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{ $user->role ? $user->role->name : '' }}</td>
                                    <td><a class="text-info" href="javascript:void(0)">{{$user->mobile}}</a></td>
                                    <td><a class="text-info" href="javascript:void(0)">{{$user->email}}</a></td>
                                    <td>{{$user->address}}</td>
                                    <td>{!! Helper::activeInactiveStatus($user->status) !!}</td>
                                    <td>{{ $user->created_at->diffForHumans() }}</td>
                                    <td>{{ $user->updated_at->diffForHumans() }}</td>
                                    <td>
                                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('read-users'))
                                        <a href="{{route('users.show', [$subdomain, $user->id])}}" data-toggle="tooltip"
                                            title="View" class="btn btn-sm btn-info"><i
                                                class="fa fa-binoculars"></i></a>
                                        @endif

                                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('update-users'))
                                        <a href="{{route('users.edit', [$subdomain, $user->id])}}"
                                            class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit"><i
                                                class="fa fa-edit"></i></a>

                                        <a href="{{route('users.change.password', [$subdomain, $user->id])}}"
                                            class="btn btn-sm btn-warning" data-toggle="tooltip" title="Change Password"><i
                                                class="fas fa-lock"></i></a>
                                        @endif

                                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('delete-users'))
                                        <a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete"
                                            onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $user->id }}').submit(); } event.returnValue = false; return false;"><i
                                                class="fa fa-trash"></i></a>
                                        {!! Form::open(['method'=>'DELETE', 'action'=>['UserController@destroy',
                                        $subdomain, $user->id], 'id'=>'deleteForm'.$user->id]) !!}
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
                            Page {{ $users->currentPage() }} , showing {{ $users->count() }}
                            records out of {{ $users->total() }} total
                        </ul>
                    </div>
                    <div class="card-footer py-2">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $users->appends(request()->all())->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
