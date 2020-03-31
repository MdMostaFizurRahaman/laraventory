@extends('layouts.client')

@section('title')
Branch Users
@endsection


@section('content')

<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Create Branch User</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        @include('massages.success')
        @include('massages.error')
        @include('massages.warning')
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-info card-outline">
                    <div class="card-body">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <th>ID</th>
                                    <th>Branch Name</th>
                                    <th>Manager</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                </thead>
                                <tbody>
                                    <td>{{$branch->id}}</td>
                                    <td>{{$branch->name}}</td>
                                    <td>{{$branch->manager->name}}</td>
                                    <td><a class="text-info" href="javascript:void(0)">{{$branch->mobile}}</a></td>
                                    <td><a class="text-info" href="javascript:void(0)">{{$branch->email}}</a>
                                    </td>
                                    <td>{{Helper::getConstantName('BRANCH_TYPES', $branch->type)}}</td>
                                    <td>{!! Helper::branchStatusLabel($branch->status) !!}</td>
                                    <td>{{ $branch->created_at->diffForHumans() }}</td>
                                    <td>{{ $branch->updated_at->diffForHumans() }}</td>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5>Create Cost Info</h5>
                    </div>

                    {!! Form::open(array('url' => route('branch-users.store' ,[$subdomain,$branch->id]),
                    'method' => 'POST')) !!}
                    <div class="card-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('user_id', 'User') !!}
                                {!! Form::select('user_id',['' => 'Choose an option'] + $users, null, ['class'
                                => 'form-control select2']) !!}
                                @if ($errors->has('user_id'))
                                <div class="error text-danger">{{ $errors->first('user_id') }}</div>
                                @endif
                            </div>

                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i> Save</button>

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-branches']))
                        <a href="{{route('branches.index', $subdomain)}}" type="button" class="btn btn-danger">Back To
                            Branch</a>
                        @endif

                    </div>
                    {!! Form::close() !!}
                </div>

                <div class="card-header">
                    <h3 class="card-title">User List</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <th style="min-width:50px;">No</th>
                            <th style="min-width:50px;">Name</th>
                            <th style="min-width:50px;">Mobile</th>
                            <th style="min-width:50px;">Email</th>
                            <th style="min-width:150px;">Address</th>
                            <th style="min-width:50px;">Created At</th>
                            <th style="min-width:50px;">Updated At</th>
                            <th style="min-width:50px;">Actions</th>
                        </thead>
                        <tbody>
                            @foreach ($branchUsers as $branchUser)
                            <tr>
                                <td>{{$branchUser->id}}</td>
                                <td>{{$branchUser->user ? $branchUser->user->name : ''}}</td>
                                <td><a class="text-info"
                                        href="javascript:void(0)">{{$branchUser->user ? $branchUser->user->mobile : ''}}</a>
                                </td>
                                <td><a class="text-info"
                                        href="javascript:void(0)">{{$branchUser->user ? $branchUser->user->email : ''}}</a>
                                </td>
                                <td>{{$branchUser->user ? $branchUser->user->address : ''}}</td>
                                <td>{{ $branchUser->created_at->diffForHumans() }}</td>
                                <td>{{ $branchUser->updated_at->diffForHumans() }}</td>
                                <td>
                                    @if(Auth::user()->hasRole('admin') || Auth::user()->can('delete-users'))
                                    <a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete"
                                        onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $branchUser->id }}').submit(); } event.returnValue = false; return false;"><i
                                            class="fa fa-trash"></i></a>
                                    {!! Form::open(['method'=>'DELETE', 'action'=>['BranchUserController@destroy',
                                    $subdomain, $branch->id,$branchUser->id], 'id'=>'deleteForm'.$branchUser->id]) !!}
                                    {!! Form::close() !!}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
