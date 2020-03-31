@extends('layouts.client')

@section('title')
Branches
@endsection


@section('content')

<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Branch List</h1>
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
                    <div class="card-header">
                        <h5>Branch List</h5>
                    </div>

                    {!! Form::open(['method'=>'GET', 'action'=>['BranchController@index',$subdomain]]) !!}

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('name', 'Branch Name') !!}
                                    {!! Form::text('name', request()->name, ['class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('mobile', 'Branch Mobile') !!}
                                    {!! Form::text('mobile', request()->mobile, ['class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('email', 'Branch Email') !!}
                                    {!! Form::text('email', request()->email, ['class'=>'form-control']) !!}
                                </div>
                            </div>

                        </div>
                        <!-- /.row -->
                        <button type="submit" class="btn btn-primary"> Filter </button>
                    </div>
                    {!! Form::close() !!}

                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th>No</th>
                                <th>Branch Name</th>
                                <th>Manager</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th style="min-width:160px">Actions</th>
                            </thead>
                            <tbody>
                                @foreach ($branches as $branch)
                                <tr>
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
                                    <td>
                                        @if(Auth::user()->hasRole('admin') ||
                                        Auth::user()->can(['create-branch-users']))
                                        <a href="{{route('branch-users.create', [$subdomain, $branch->id])}}"
                                            class="btn btn-sm btn-success" data-toggle="tooltip" title="Branch users"><i
                                                class="fas fa-users"></i></a>
                                        @endif

                                        @if(Auth::user()->hasRole('admin') ||
                                        Auth::user()->can(['read-branches']))
                                        <a href="{{route('branches.show', [$subdomain, $branch->id])}}"
                                            class="btn btn-sm btn-info" data-toggle="tooltip" title="Show Details"><i
                                                class="fas fa-binoculars"></i></a>
                                        @endif

                                        @if(Auth::user()->hasRole('admin') ||
                                        Auth::user()->can(['update-branches']))
                                        <a href="{{route('branches.edit', [$subdomain, $branch->id])}}"
                                            class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                        @endif

                                        @if(Auth::user()->hasRole('admin') ||
                                        Auth::user()->can(['delete-branches']))
                                        <a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete"
                                            onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $branch->id }}').submit(); } event.returnValue = false; return false;"><i
                                                class="fa fa-trash"></i></a>
                                        {!! Form::open(['method'=>'DELETE', 'action'=>['BranchController@destroy',
                                        $subdomain, $branch->id], 'id'=>'deleteForm'.$branch->id]) !!}
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
                            Page {{ $branches->currentPage() }} , showing {{ $branches->count() }}
                            records out of {{ $branches->total() }} total
                        </ul>
                    </div>
                    <div class="card-footer py-2">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $branches->appends(request()->all())->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
