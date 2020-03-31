@extends('layouts.client')

@section('title')
    Purchase History
@endsection


@section('content')

<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0 text-dark">Purchase History</h1>
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
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th width="10%">PO #</th>
                                <th width="20%">Supplier</th>
                                <th width="10%">Purchase Date</th>
                                <th width="10%">Receive Date</th>
                                <th width="10%" class="text-right">Amount</th>
                                <th width="10%" class="text-center">Status</th>
                                <th width="10%">Created At</th>
                                <th width="10%">Updated At</th>
                                <th width="10%">Actions</th>
                            </thead>
                            <tbody>
                                    @foreach ($purchases as $purchase)
                                        <tr>
                                            <td>{{$purchase->poNumber}}</td>
                                            <td>{{$purchase->supplier->name}}</td>
                                            <td>{{$purchase->purchaseDate}}</td>
                                            <td>{{$purchase->receiveDate}}</td>
                                            <td class="text-right">{{Helper::money($purchase->total)}}</td>
                                            <td class="text-center">{!! Helper::purchaseStatusLabel($purchase->status) !!}</td>
                                            <td>{{$purchase->createdAt->diffForHumans()}}</td>
                                            <td>{{$purchase->updatedAt->diffForHumans()}}</td>
                                            <td>
                                                <a href="{{route('purchases.edit',[$subdomain, $purchase->id])}}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>

                                                <a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete"
                                                onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $purchase->id }}').submit(); } event.returnValue = false; return false;"><i
                                                    class="fa fa-trash"></i></a>
                                                {!! Form::open(['method'=>'DELETE', 'action'=>['PurchaseController@destroy', $subdomain, $purchase->id], 'id'=>'deleteForm'.$purchase->id]) !!}
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        {{-- {{$purchases->links()}} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
