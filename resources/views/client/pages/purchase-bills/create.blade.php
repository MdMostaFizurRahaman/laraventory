@extends('layouts.client')

@section('title')
New Receive
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class="m-0 text-dark">New Purchase Bill</h3>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5>Purchase Info</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>PO</th>
                                    <th>Supplier</th>
                                    <th>Account</th>
                                    <th>Status</th>
                                    <th>Purchase Date</th>
                                    <th>Receive Date</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                </tr>
                                <tr>
                                    <td>{{$purchase->poNumber}}</td>
                                    <td>{{$purchase->supplier->name}}</td>
                                    <td>{{$purchase->account->accountName}}</td>
                                    <td>{!! Helper::purchaseStatusLabel($purchase->status) !!}</td>
                                    <td>{{$purchase->purchaseDate}}</td>
                                    <td>{{$purchase->receiveDate}}</td>
                                    <td>{{$purchase->created_at->diffForHumans()}}</td>
                                    <td>{{$purchase->updated_at->diffForHumans()}}</td>
                                </tr>
                                <tr class="text-center">
                                    <th colspan="4">Note</th>
                                    <th colspan="4">Terms & Condition</th>
                                </tr>

                                <tr>
                                    <td colspan="4">{{$purchase->note}}</td>
                                    <td colspan="4">{{$purchase->condition}}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @php
        $purchaseMaterials =
        $purchase->purchaseMaterials()->whereColumn('received_quantity','>','billed_quantity')->get();
        @endphp

        @if ($purchaseMaterials->count() >0)

        {!! Form::open(['route' => ['purchases.bills.store', $subdomain, $purchase->id], 'method' =>'post']) !!}
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5>Create Bill Info</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">

                                <div class="form-group">
                                    {!! Form::label('bill_date', 'Bill Date') !!}
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        {!! Form::text('bill_date', null, ['class'=>'form-control float-right'])
                                        !!}
                                    </div>
                                    @if ($errors->has('bill_date'))
                                    <div class="error text-danger">{{ $errors->first('bill_date') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('due_date', 'Due Date') !!}
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        {!! Form::text('due_date', null, ['class'=>'form-control float-right'])
                                        !!}
                                    </div>
                                    @if ($errors->has('due_date'))
                                    <div class="error text-danger">{{ $errors->first('due_date') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {{ Form::label("Supplier", null) }}
                                    {{Form::text("supplier", $purchase->supplier ? $purchase->supplier->name : '',["class" => "form-control", 'readonly'])}}
                                    @if ($errors->has('supplier'))
                                    <div class="error text-danger">{{ $errors->first('supplier') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('Account', null) !!}
                                    {!! Form::select('account_id', $accounts, $purchase->accountId, ['class' =>
                                    'form-control select2']) !!}
                                    @if ($errors->has('account_id'))
                                    <div class="error text-danger">{{ $errors->first('account_id') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('Currency', null) !!}
                                    {!! Form::select('currency_id', $currencies, $purchase->currencyId, ['class' =>
                                    'form-control select2']) !!}
                                    @if ($errors->has('currency_id'))
                                    <div class="error text-danger">{{ $errors->first('currency_id') }}</div>
                                    @endif
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('Reference', null) !!}
                                    {!! Form::text('reference', null, ['class' => 'form-control']) !!}
                                    @if ($errors->has('reference'))
                                    <div class="error text-danger">{{ $errors->first('reference') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {{ Form::label("Note", null) }}
                                    {{Form::textarea("note", null,["class" => "form-control", 'rows' => 3])}}
                                    @if ($errors->has('note'))
                                    <div class="error text-danger">{{ $errors->first('note') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card  card-outline card-primary">
                    <div class="card-header">
                        <h5>Bill Item Info</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th>No</th>
                                <th>Material Name</th>
                                <th>Ordered</th>
                                <th>Billed</th>
                                <th>Bill Quantity</th>
                                <th>Rate</th>
                                {{-- <th width="15%">Total</th>  --}}
                            </thead>
                            <tbody>
                                @foreach ($purchaseMaterials as $material)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$material->material->name}}</td>
                                    <td>{{$material->quantity}}</td>
                                    <td>{{$material->billedQuantity}}</td>
                                    <td>
                                        <div class="form-group">
                                            {{-- Hidden Fields --}}
                                            {!! Form::hidden('material_id[]', $material->material_id, ['class'
                                            =>'form-control']) !!}
                                            {!! Form::hidden("max_quantity[$material->id]",$material->quantity -
                                            $material->billedQuantity , ['class' => 'form-control']) !!}
                                            {{-- End Hidden Fields --}}

                                            {!! Form::text("bill_quantity[$material->id]", null, ['class' =>
                                            'form-control bill_quantity','oninput'=>"this.value =
                                            this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"]) !!}
                                            @if ($errors->has("bill_quantity.$material->id"))
                                            <div class="error text-danger">
                                                {{ $errors->first("bill_quantity.$material->id") }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            {!! Form::text("rate[$material->id]", null, ['class' => 'form-control
                                            rate','oninput'=>"this.value = this.value.replace(/[^0-9.]/g,
                                            '').replace(/(\..*)\./g, '$1');"]) !!}
                                            @if ($errors->has("rate.$material->id"))
                                            <div class="error text-danger">{{ $errors->first("rate.$material->id") }}
                                            </div>
                                            @endif
                                        </div>
                                    </td>
                                    {{-- <td>
                                                        <div class="form-group">
                                                            {!! Form::number("total[$loop->index]", null, ['class' => 'form-control', 'readonly']) !!}
                                                            @if ($errors->has("total.$loop->index"))
                                                                <div class="error text-danger">{{ $errors->first("total.$loop->index") }}
                    </div>
                    @endif
                </div>
                </td> --}}
                </tr>
                @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-2"></i>Save</button>
            <a href="{{route('purchases.show', [$subdomain, $purchase->id])}}" type="button" class="btn btn-danger"><i
                    class="fas fa-backward mr-2"></i>Cancel & Back</a>
        </div>
    </div>
</div>
</div><!-- /.container-fluid -->
{!! Form::close() !!}
@endif
</div>
@endsection


@push('scripts')
<script>
    $(document).ready(function () {
            // $('.total').val($('.quantity').val() * $('.rate').val());

            // $(".bill_quantity,.rate").each(function(key, value){

            // })
            $('#bill_date').daterangepicker({
            singleDatePicker: true,
            locale: {
                    format: 'YYYY-MM-DD',
                },
            });
            $('#due_date').daterangepicker({
            singleDatePicker: true,
            locale: {
                    format: 'YYYY-MM-DD',
                },
            });
    });
</script>
@endpush
