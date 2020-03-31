@extends('layouts.client')

@section('title')
Add Account
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Create Account</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5>Create Account Info</h5>
                    </div>
                    {!! Form::open(['route' => ['accounts.store', $subdomain], 'method' =>'post']) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label("Account Name", null) }}
                                    {{Form::text("account_name", null,["class" => "form-control"])}}
                                    @if ($errors->has('account_name'))
                                    <div class="error text-danger">{{ $errors->first('account_name') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {{ Form::label("Account Number", null) }}
                                    {{Form::text("account_number", null,["class" => "form-control"])}}
                                    @if ($errors->has('account_number'))
                                    <div class="error text-danger">{{ $errors->first('account_number') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {{ Form::label("Account Mobile Number", null) }}
                                    {{Form::text("account_mobile_number", null,["class" => "form-control"])}}
                                    @if ($errors->has('account_mobile_number'))
                                    <div class="error text-danger">{{ $errors->first('account_mobile_number') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {{ Form::label("Opening Balance", null) }}
                                    {{Form::text("opening_balance", null,["class" => "form-control",'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"])}}
                                    @if ($errors->has('opening_balance'))
                                    <div class="error text-danger">{{ $errors->first('opening_balance') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {{ Form::label("Status", null) }}
                                    {{Form::select("status",['' => 'Choose an option'] + Config::get('constant.BANK_ACCOUNT_STATUSES'),1,["class" => "form-control select2"])}}
                                    @if ($errors->has('status'))
                                    <div class="error text-danger">{{ $errors->first('status') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label("Branch Name", null) }}
                                    {{Form::text("branch_name", null,["class" => "form-control"])}}
                                    @if ($errors->has('branch_name'))
                                    <div class="error text-danger">{{ $errors->first('branch_name') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {{ Form::label("Branch Code", null) }}
                                    {{Form::text("branch_code", null,["class" => "form-control"])}}
                                    @if ($errors->has('branch_code'))
                                    <div class="error text-danger">{{ $errors->first('branch_code') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {{ Form::label("Bank Name", null) }}
                                    {{Form::select("bank_id",['' => 'Choose an option'] + $banks, null,["class" => "form-control select2"])}}
                                    @if ($errors->has('bank_id'))
                                    <div class="error text-danger">{{ $errors->first('bank_id') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {{ Form::label("Address", null) }}
                                    {{Form::textarea("address", null,["class" => "form-control", 'rows'=> 3])}}
                                    @if ($errors->has('address'))
                                    <div class="error text-danger">{{ $errors->first('address') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Save</button>
                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('read-accounts'))
                        <a href="{{route('accounts.index', $subdomain)}}" type="button" class="btn btn-danger">Back</a>
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
