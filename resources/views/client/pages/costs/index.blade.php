@extends('layouts.client')

@section('title')
Costs
@endsection


@section('content')

<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Costs</h1>
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
                        <h5>Cost List</h5>
                    </div>

                    {!! Form::open(['method'=>'GET', 'action'=>['CostController@index',$subdomain]]) !!}

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('cost_type_id', 'Cost Type') !!}
                                    {!! Form::select('cost_type_id',['0' => 'All'] + $costTypes,
                                    request()->get('cost_type_id'),
                                    ['class'
                                    => 'form-control select2']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('purchase_id', 'PO Number') !!}
                                    {!! Form::select('purchase_id',['0' => 'All'] + $purchases,
                                    request()->get('purchase_id'),
                                    ['class'
                                    => 'form-control select2']) !!}
                                </div>
                            </div>

                        </div>
                        <!-- /.row -->
                        <button type="submit" class="btn btn-primary"> Filter </button>
                    </div>
                    {!! Form::close() !!}

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th>No</th>
                                <th>Cost Type</th>
                                <th>PO Number</th>
                                <th>Amount</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                @foreach ($costs as $cost)
                                <tr>
                                    <td>{{$cost->id}}</td>
                                    <td>{{$cost->costType ? $cost->costType->name : ''}}</td>
                                    <td>
                                        <a href="{{route('purchases.show', [$subdomain, $cost->purchase ? $cost->purchase->id : ''])}}"
                                            class="text-info">
                                            {{$cost->purchase ? $cost->purchase->poNumber : ''}}
                                        </a>
                                    </td>
                                    <td>{{$cost->amount}}</td>
                                    <td>{{$cost->description}}</td>
                                    <td>{{ $cost->created_at->diffForHumans() }}</td>
                                    <td>{{ $cost->updated_at->diffForHumans() }}</td>
                                    <td>
                                        @if(Auth::user()->hasRole('admin') ||
                                        Auth::user()->can(['update-costs']))
                                        <a href="{{route('costs.edit',[$subdomain, $cost->id])}}"
                                            class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        @endif

                                        @if(Auth::user()->hasRole('admin') ||
                                        Auth::user()->can(['delete-costs']))
                                        <a href="#" class="btn btn-danger btn-sm"
                                            onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $cost->id }}').submit(); } event.returnValue = false; return false;"><i
                                                class="fa fa-trash"></i> </a>
                                        {!! Form::open(['method'=>'DELETE', 'action'=>['CostController@destroy',
                                        $subdomain, $cost->id], 'id'=>'deleteForm'.$cost->id]) !!}
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
                            Page {{ $costs->currentPage() }} , showing {{ $costs->count() }}
                            records out of {{ $costs->total() }} total
                        </ul>
                    </div>
                    <div class="card-footer py-2">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $costs->appends(request()->all())->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
