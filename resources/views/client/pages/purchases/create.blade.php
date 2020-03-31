@extends('layouts.client')

@section('title')
Add Purchases
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Add Purchases</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        {{-- @include('massages.success') --}}
        {{-- @include('massages.errors') --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    {!! Form::open(['route' => ['purchases.store', $subdomain], 'method' =>'post']) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('Supplier', null) !!}
                                    {!! Form::select('supplier_id',['' => 'Choose an option'] + $suppliers, null,
                                    ['class' => 'form-control select2']) !!}
                                    @if ($errors->has('supplier_id'))
                                    <div class="error text-danger">{{ $errors->first('supplier_id') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Account', null) !!}
                                    {!! Form::select('account_id',['' => 'Choose an option'] + $accounts, null, ['class'
                                    => 'form-control select2']) !!}
                                    @if ($errors->has('account_id'))
                                    <div class="error text-danger">{{ $errors->first('account_id') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Currency', null) !!}
                                    {!! Form::select('currency_id',['' => 'Choose an option'] + $currencies, null,
                                    ['class' => 'form-control select2']) !!}
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
                                    {{Form::textarea("note", null,["class" => "form-control", 'rows' => 2])}}
                                    @if ($errors->has('note'))
                                    <div class="error text-danger">{{ $errors->first('note') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {{ Form::label("condition","Terms & Condition", null) }}
                                    {{Form::textarea("condition", null,["class" => "form-control", 'rows' => 6])}}

                                    @if ($errors->has('condition'))
                                    <div class="error text-danger">{{ $errors->first('condition') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Save Draft</button>
                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-purchases']))
                        <a href="{{route('purchases.index', $subdomain)}}" type="button" class="btn btn-danger">Cancel</a>
                        @endif
                    </div>
                    {!! Form::close() !!}
                </div><!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
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