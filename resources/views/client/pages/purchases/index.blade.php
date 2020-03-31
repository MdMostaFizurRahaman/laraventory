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
        @include('massages.warning')
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5>Purchase List</h5>
                    </div>

                    {!! Form::open(['method'=>'GET', 'action'=>['PurchaseController@index',$subdomain]]) !!}

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('po_number', 'PO Number') !!}
                                    {!! Form::text('po_number', request()->po_number, ['class' =>'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('supplier_id', 'Suppliers') !!}
                                    {!! Form::select('supplier_id',['0' => 'All'] + $suppliers,
                                    request()->get('supplier_id'),
                                    ['class'
                                    => 'form-control select2']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('account_id', 'Accounts') !!}
                                    {!! Form::select('account_id',['0' => 'All'] + $accounts,
                                    request()->get('account_id'),
                                    ['class'
                                    => 'form-control select2']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('currency_id', 'Currencies') !!}
                                    {!! Form::select('currency_id',['0' => 'All'] + $currencies,
                                    request()->get('currency_id'),
                                    ['class'
                                    => 'form-control select2']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('purchase_start_date', 'Purchase Start Date') !!}
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        {!! Form::text('purchase_start_date', request()->purchase_start_date,
                                        ['class'=>'form-control multi-date float-right','autocomplete'=>'off'])
                                        !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('purchase_end_date', 'Purchase End Date') !!}
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        {!! Form::text('purchase_end_date', request()->purchase_end_date,
                                        ['class'=>'form-control multi-date float-right','autocomplete'=>'off'])
                                        !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('receive_start_date', ' Expected Receive Start Date') !!}
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        {!! Form::text('receive_start_date', request()->receive_start_date,
                                        ['class'=>'form-control multi-date float-right','autocomplete'=>'off'])
                                        !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('receive_end_date', 'Expected Receive Start Date') !!}
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        {!! Form::text('receive_end_date', request()->receive_end_date,
                                        ['class'=>'form-control multi-date float-right','autocomplete'=>'off'])
                                        !!}
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.row -->
                        <button type="submit" class="btn btn-primary"> Filter </button>
                    </div>
                    {!! Form::close() !!}

                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th>PO#</th>
                                <th>Supplier</th>
                                <th>Purchase Date</th>
                                <th>Expected Receive Date</th>
                                <th class="text-right">Amount</th>
                                <th class="text-center">Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Actions</th>
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
                                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('read-purchases'))
                                        <a href="{{route('purchases.show',[$subdomain, $purchase->id])}}"
                                            class="btn btn-sm btn-info" data-toggle="tooltip" title="Detail"><i
                                                class="fa fa-eye"></i></a>
                                        @endif

                                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('update-purchases'))
                                        @if ($purchase->status <=1) <a
                                            href="{{route('purchases.edit',[$subdomain, $purchase->id])}}"
                                            class="btn btn-sm btn-primary" data-toggle="tooltip" title="Update"><i
                                                class="fa fa-edit"></i></a>
                                            @endif

                                            @endif

                                            @if(Auth::user()->hasRole('admin') ||
                                            Auth::user()->can('delete-purchases'))

                                            @if ($purchase->status < 1) <a href="#" class="btn btn-danger btn-sm"
                                                data-toggle="tooltip" title="Delete"
                                                onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $purchase->id }}').submit(); } event.returnValue = false; return false;">
                                                <i class="fa fa-trash"></i></a>
                                                {!! Form::open(['method'=>'DELETE',
                                                'action'=>['PurchaseController@destroy',
                                                $subdomain, $purchase->id], 'id'=>'deleteForm'.$purchase->id]) !!}
                                                {!! Form::close() !!}
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
                            Page {{ $purchases->currentPage() }} , showing {{ $purchases->count() }}
                            records out of {{ $purchases->total() }} total
                        </ul>
                    </div>
                    <div class="card-footer py-2">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $purchases->appends(request()->all())->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function () {

        $('.multi-date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

    });
</script>
@endpush
