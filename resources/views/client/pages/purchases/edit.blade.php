@extends('layouts.client')

@section('title')
Edit Purchases
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-md-6">
                <h3 class="m-0 text-dark">Purchase #{{$purchase->poNumber}} {!!
                    Helper::purchaseStatusLabel($purchase->status) !!} </h3>
            </div><!-- /.col -->
            <div class="col-lg-6 text-right">
                @if ($purchase->status)
                @if ($purchase->isReceivable())
                <a href="{{route('purchases.receives.create', [$subdomain, $purchase->id])}}"
                    class="btn btn-info mr-2"><i class="fas fa-hourglass-start mr-2"></i>Receive</a>
                @endif
                @if ($purchase->isBillable())
                <a href="{{route('purchases.bills.create', [$subdomain, $purchase->id])}}" class="btn btn-primary"><i
                        class="fas fa-file-invoice-dollar mr-2"></i>Bill</a>
                @endif
                @endif
            </div>
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        {{-- @include('massages.success') --}}
        {{-- @include('massages.errors') --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    {!! Form::model($purchase, ['route' => ['purchases.update', $subdomain, $purchase->id], 'method'
                    =>'put']) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('Supplier', null) !!}
                                    @if (!$purchase->status)
                                    {!! Form::select('supplier_id',['' => 'Choose an option'] + $suppliers, null,
                                    ['class' => 'form-control select2']) !!}
                                    @else
                                    {!! Form::text('supplier_id', $purchase->supplier->name, ['class' => 'form-control',
                                    'readonly']) !!}
                                    @endif
                                    @if ($errors->has('supplier_id'))
                                    <div class="error text-danger">{{ $errors->first('supplier_id') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Account', null) !!}
                                    @if (!$purchase->status)
                                    {!! Form::select('account_id',['' => 'Choose an option'] + $accounts, null, ['class'
                                    => 'form-control select2']) !!}
                                    @else
                                    {!! Form::text('account_id', $purchase->account->accountName, ['class' =>
                                    'form-control', 'readonly']) !!}
                                    @endif
                                    @if ($errors->has('account_id'))
                                    <div class="error text-danger">{{ $errors->first('account_id') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Currency', null) !!}
                                    @if (!$purchase->status)
                                    {!! Form::select('currency_id',['' => 'Choose an option'] + $currencies, null,
                                    ['class' => 'form-control select2']) !!}
                                    @else
                                    {!! Form::text('currency_id', $purchase->currency->name, ['class' => 'form-control',
                                    'readonly']) !!}
                                    @endif
                                    @if ($errors->has('currency_id'))
                                    <div class="error text-danger">{{ $errors->first('currency_id') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {!! Form::label('purchase_date', 'Purchase Date') !!}
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        {!! Form::text('purchase_date', null, ['class'=>'form-control float-right'])
                                        !!}
                                    </div>
                                    @if ($errors->has('purchase_date'))
                                    <div class="error text-danger">{{ $errors->first('purchase_date') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('receive_date', 'Expected Receive Date') !!}
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        {!! Form::text('receive_date', null, ['class'=>'form-control float-right'])
                                        !!}
                                    </div>
                                    @if ($errors->has('receive_date'))
                                    <div class="error text-danger">{{ $errors->first('receive_date') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label("Note", null) }}
                                    @if (!$purchase->status)

                                    {{Form::textarea("note", null,["class" => "form-control", 'rows' => 3])}}
                                    @else
                                    {{Form::textarea("note", null,["class" => "form-control", 'rows' => 3, 'readonly'])}}

                                    @endif
                                    @if ($errors->has('note'))
                                    <div class="error text-danger">{{ $errors->first('note') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {{ Form::label("Terms & Condition", null) }}
                                    @if (!$purchase->status)

                                    {{Form::textarea("condition", null,["class" => "form-control", 'rows' => 6])}}
                                    @else
                                    {{Form::textarea("condition", null,["class" => "form-control", 'rows' => 6, 'readonly'])}}

                                    @endif
                                    @if ($errors->has('condition'))
                                    <div class="error text-danger">{{ $errors->first('condition') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        @if ($purchase->status == 0)
                        <button type="submit" name="action" value="save&draft" class="btn btn-primary"><i
                                class="fa fa-save mr-2"></i>Update</button>
                        <button type="submit" name="action" value="save&issue" class="btn btn-info"><i
                                class="fas fa-paper-plane mr-2"></i>Save & Issue </button>
                        <a href="{{route('purchases.index', $subdomain)}}" type="button"
                            class="btn btn-danger">Cancel</a>
                        @else
                        <a href="{{route('purchases.index', $subdomain)}}" type="button" class="btn btn-danger"><i
                                class="fas fa-backward mr-2"></i>Back</a>
                        @endif
                    </div>
                    {!! Form::close() !!}
                </div><!-- /.card -->
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
@endsection

@push('scripts')

<script>
    $(document).ready(function() {
        $('#purchase_date').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'YYYY-MM-DD',
            },
        });
        $('#receive_date').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'YYYY-MM-DD',
            },
        });

    });
</script>

@endpush
