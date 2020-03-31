@extends('layouts.client')

@section('title')
Suppliers
@endsection


@section('content')

<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Supplier List</h1>
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
                        <h5>Supplier List</h5>
                    </div>
                    {!! Form::open(['method'=>'GET', 'action'=>['SupplierController@index',$subdomain]]) !!}
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('name', 'Name') !!}
                                    {!! Form::text('name', request()->name, ['class'=>'form-control'])
                                    !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('email', 'Email') !!}
                                    {!! Form::text('email', request()->email, ['class'=>'form-control'])
                                    !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('mobile', 'Mobile') !!}
                                    {!! Form::text('mobile', request()->mobile, ['class'=>'form-control'])
                                    !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('company', 'Company') !!}
                                    {!! Form::text('company', request()->company, ['class'=>'form-control'])
                                    !!}
                                </div>
                            </div>

                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <button type="submit" class="btn btn-primary"> Filter </button>
                    </div>
                    {!! Form::close() !!}

                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th>No</th>
                                <th>Name</th>
                                <th>Company</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Balance</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th style="min-width:130px">Actions</th>
                            </thead>
                            <tbody>
                                @foreach ($suppliers as $supplier)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$supplier->name}}</td>
                                    <td>{{$supplier->company}}</td>
                                    <td><a class="text-info" href="javascript:void(0)">{{$supplier->mobile}}</a>
                                    </td>
                                    <td><a class="text-info" href="javascript:void(0)">{{$supplier->email}}</a>
                                    </td>
                                    <td>{{$supplier->balance}}</td>
                                    <td>{{$supplier->created_at->diffForHumans()}}</td>
                                    <td>{{$supplier->updated_at->diffForHumans()}}</td>
                                    <td>
                                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('read-suppliers'))
                                        <a href="{{route('suppliers.show', [$subdomain, $supplier->id])}}"
                                            class="btn btn-sm btn-info" data-toggle="tooltip" title="Show Details"><i
                                                class="fas fa-binoculars"></i></a>
                                        @endif

                                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('update-suppliers'))
                                        <a href="{{route('suppliers.edit', [$subdomain, $supplier->id])}}"
                                            class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                        @endif

                                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('delete-suppliers'))
                                        <a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete"
                                            onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $supplier->id }}').submit(); } event.returnValue = false; return false;"><i
                                                class="fa fa-trash"></i></a>
                                        {!! Form::open(['method'=>'DELETE', 'action'=>['SupplierController@destroy',
                                        $subdomain, $supplier->id], 'id'=>'deleteForm'.$supplier->id]) !!}
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
                            Page {{ $suppliers->currentPage() }} , showing {{ $suppliers->count() }}
                            records out of {{ $suppliers->total() }} total
                        </ul>
                    </div>
                    <div class="card-footer py-2">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $suppliers->appends(request()->all())->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
