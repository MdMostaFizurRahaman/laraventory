@extends('layouts.client')

@section('title')
    Add Payment
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content">
        <div class="content-header">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h3 class="m-0 text-dark">New Payment #{{$purchase->poNumber}}</h3>
              </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
        <div class="container-fluid">
            @include('massages.success')
            @include('massages.errors')
        <div class="row">

        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-primary card-outline">
                    {!! Form::open(['route' => ['purchases.payments.store', $subdomain, $purchase->id], 'method' =>'post']) !!}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        {!! Form::label('Transaction Category', null) !!}
                                        {!! Form::select('category_id',['' => 'Choose an option'] + $categories, null, ['class' => 'form-control select2']) !!}
                                    @if ($errors->has('category_id'))
                                        <div class="error text-danger">{{ $errors->first('category_id') }}</div>
                                    @endif
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('Amount', null) !!}
                                        {!! Form::number('amount', $purchase->totalDue, ['class' => 'form-control', 'step' => 'any']) !!}
                                    @if ($errors->has('amount'))
                                        <div class="error text-danger">{{ $errors->first('amount') }}</div>
                                    @endif
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('Description/Ref', null) !!}
                                        {!! Form::text('ref', null, ['class' => 'form-control' , 'step' => 'any']) !!}
                                    @if ($errors->has('ref'))
                                        <div class="error text-danger">{{ $errors->first('ref') }}</div>
                                    @endif
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('Transaction Date', null) !!}
                                        {!! Form::date('transaction_date', date('Y-m-d'), ['class' => 'form-control']) !!}
                                    @if ($errors->has('transaction_date'))
                                        <div class="error text-danger">{{ $errors->first('transaction_date') }}</div>
                                    @endif
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('Payment Methods', null) !!}
                                        {!! Form::select('method',Config::get('constant.PAYMENT_METHODS'), null, ['class' => 'form-control select2']) !!}
                                    @if ($errors->has('method'))
                                        <div class="error text-danger">{{ $errors->first('method') }}</div>
                                    @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <button type="submit"   class="btn btn-primary"><i class="fa fa-save mr-2"></i>Save</button>
                                        <a href="{{route('purchases.edit', [$subdomain, $purchase->id])}}" type="button" class="btn btn-danger">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div><!-- /.card -->
            </div>
            <div class="col-lg-6">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5>Purchase Info</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th width="30%">PO</th>
                                        <td>{{$purchase->poNumber}}</td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Supplier</th>
                                        <td>{{$purchase->supplier->name}}</td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Account</th>
                                        <td>{{$purchase->account->accountName}}</td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Total Amount</th>
                                        <td>{{Helper::money($purchase->total)}}</td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Total Payment</th>
                                        <td>{{Helper::money($purchase->totalPayment)}}</td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Total Due</th>
                                        <td>{{Helper::money($purchase->totalDue)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function () {
            $('.total').val($('.quantity').val() * $('.rate').val());

            $(".quantity,.rate").keyup(function () {
                $('.total').val($('.quantity').val() * $('.rate').val());
            });
        });
    </script>
@endpush


