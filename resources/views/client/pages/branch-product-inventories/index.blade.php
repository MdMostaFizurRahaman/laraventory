@extends('layouts.client')

@section('title')
Branch Product Inventories
@endsection


@section('content')

<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Branch Product Inventories</h1>
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
                        <h5>Branch Product Inventory List</h5>
                    </div>
                    {!! Form::open(['method'=>'GET', 'action'=>['BranchProductInventoryController@index',$subdomain]]) !!}

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('branch_id', 'Branch') !!}
                                    {!! Form::select('branch_id',['0'=>'All']+$branches, request()->branch_id, ['class' =>
                                    'form-control select2']) !!}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('product_id', 'Product') !!}
                                    {!! Form::select('product_id',['0'=>'All']+$products, request()->product_id,
                                    ['class' =>
                                    'form-control select2']) !!}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('min_stock', 'Minimum Stock') !!}
                                    {!! Form::text('min_stock', request()->min_stock, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <button type="submit" class="btn btn-primary"> Filter </button>
                    </div>
                    {!! Form::close() !!}

                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th>ID</th>
                                <th>Branch</th>
                                <th>Product Name/Code/Batch</th>
                                <th>Category</th>
                                <th>Sale Price</th>
                                <th>Stock In Hand</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th style="min-width:150px">Actions</th>
                            </thead>
                            <tbody>
                                @foreach ($branchProductInventories as $inventory)
                                <tr>
                                    <td>{{ $inventory->id }}</td>
                                    <td>{{ $inventory->branch ? $inventory->branch->name : '' }}</td>
                                    <td>{{ $inventory->product ? $inventory->product->name_code_batch_quantity : '' }}</td>
                                    <td>{{ $inventory->product ? $inventory->product->category_name : '' }}</td>
                                    <td>{{ $inventory->sale_price }}</td>
                                    <td>{{ $inventory->quantity }}</td>
                                    <td>{!! Helper::activeInactiveStatus($inventory->status) !!}</td>
                                    <td>{{ $inventory->created_at->diffForHumans() }}</td>
                                    <td>{{ $inventory->updated_at->diffForHumans() }}</td>
                                    <td>
                                        @if(Auth::user()->hasRole('admin') ||
                                        Auth::user()->can(['read-branch-product-inventories']))
                                        <a href="{{route('branch-product-inventories.show', [$subdomain, $inventory->id])}}"
                                            class="btn btn-sm btn-info" data-toggle="tooltip" title="Show Details"><i
                                                class="fas fa-binoculars"></i></a>
                                        @endif

                                        @if(Auth::user()->hasRole('admin') ||
                                        Auth::user()->can(['update-branch-product-inventories']))
                                        <a href="{{route('branch-product-inventories.edit',[$subdomain, $inventory->id])}}"
                                            class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                        @endif

                                        @if(Auth::user()->hasRole('admin') ||
                                        Auth::user()->can(['delete-branch-product-inventories']))
                                        <a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete"
                                            onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $inventory->id }}').submit(); } event.returnValue = false; return false;"><i
                                                class="fa fa-trash"></i></a>
                                        {!! Form::open(['method'=>'DELETE', 'action'=>['BranchProductInventoryController@destroy',
                                        $subdomain, $inventory->id], 'id'=>'deleteForm'.$inventory->id]) !!}
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
                            Page {{ $branchProductInventories->currentPage() }} , showing {{ $branchProductInventories->count() }}
                            records out of {{ $branchProductInventories->total() }} total
                        </ul>
                    </div>
                    <div class="card-footer py-2">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $branchProductInventories->appends(request()->all())->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
