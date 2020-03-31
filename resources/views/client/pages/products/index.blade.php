@extends('layouts.client')

@section('title')
Products
@endsection


@section('content')

<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Products</h1>
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
                        <h5>Product List</h5>
                    </div>
                    {!! Form::open(['method'=>'GET', 'action'=>['ProductController@index',$subdomain]]) !!}

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
                                    {!! Form::label('code', 'Code') !!}
                                    {!! Form::text('code', request()->code, ['class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('category_id', 'Category') !!}
                                    {!! Form::select('category_id',['0'=>'All']+$categories, request()->category_id,
                                    ['class' =>
                                    'form-control select2']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('unit_id', 'Unit') !!}
                                    {!! Form::select('unit_id',['0'=>'All']+$units, request()->unit_id, ['class' =>
                                    'form-control select2']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('currency_id', 'Currency') !!}
                                    {!! Form::select('currency_id',['0'=>'All']+$currencies, request()->currency_id,
                                    ['class' =>
                                    'form-control select2']) !!}
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
                                <th>No</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Category</th>
                                <th>Batch Quantity</th>
                                {{-- <th>Description</th> --}}
                                <th>Sale Price</th>
                                <th>Currency</th>
                                <th>Stock In Hand</th>
                                <th>Unit</th>
                                <th>Qnt. Is Decimal</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th style="min-width:150px">Actions</th>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                <tr>
                                    <td>{{$product->id}}</td>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->code}}</td>
                                    <td>{{$product->category ? $product->category->name : ''}}</td>
                                    <td>{{$product->batch_quantity}}</td>
                                    {{-- <td>{{$product->description}}</td> --}}
                                    <td>{{$product->salePrice}}</td>
                                    <td>{{$product->currency ? $product->currency->name : ''}}</td>
                                    <td>{{$product->quantity}}</td>
                                    <td>{{$product->unit ? $product->unit->name : ''}}</td>
                                    <td>
                                        @if ($product->is_numeric)
                                        <span class="text-success">YES</span>
                                        @else
                                        <span class="text-warning">NO</span>
                                        @endif
                                    </td>
                                    <td>{{ $product->created_at->diffForHumans() }}</td>
                                    <td>{{ $product->updated_at->diffForHumans() }}</td>
                                    <td>
                                        @if(Auth::user()->hasRole('admin') ||
                                        Auth::user()->can(['read-products']))
                                        <a href="{{route('products.show', [$subdomain, $product->id])}}"
                                            class="btn btn-sm btn-info" data-toggle="tooltip" title="Show Details"><i
                                                class="fas fa-binoculars"></i></a>
                                        @endif

                                        @if(Auth::user()->hasRole('admin') ||
                                        Auth::user()->can(['update-products']))
                                        <a href="{{route('products.edit',[$subdomain, $product->id])}}"
                                            class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                        @endif

                                        @if(Auth::user()->hasRole('admin') ||
                                        Auth::user()->can(['delete-products']))
                                        <a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete"
                                            onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $product->id }}').submit(); } event.returnValue = false; return false;"><i
                                                class="fa fa-trash"></i></a>
                                        {!! Form::open(['method'=>'DELETE', 'action'=>['ProductController@destroy',
                                        $subdomain, $product->id], 'id'=>'deleteForm'.$product->id]) !!}
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
                            Page {{ $products->currentPage() }} , showing {{ $products->count() }}
                            records out of {{ $products->total() }} total
                        </ul>
                    </div>
                    <div class="card-footer py-2">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $products->appends(request()->all())->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
