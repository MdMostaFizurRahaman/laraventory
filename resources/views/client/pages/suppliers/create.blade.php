@extends('layouts.client')

@section('title')
Add Supplier
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Create Supplier</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5>Create Supplier Info</h5>
                    </div>
                    {!! Form::open(['route' => ['suppliers.store', $subdomain], 'method' =>'post']) !!}
                    <div class="card-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label("Supplier Name", null) }}
                                {{Form::text("name", null,["class" => "form-control"])}}
                                @if ($errors->has('name'))
                                <div class="error text-danger">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                {{ Form::label("Mobile", null) }}
                                {{Form::text("mobile", null,["class" => "form-control"])}}
                                @if ($errors->has('mobile'))
                                <div class="error text-danger">{{ $errors->first('mobile') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                {{ Form::label("Email", null) }}
                                {{Form::email("email", null,["class" => "form-control"])}}
                                @if ($errors->has('email'))
                                <div class="error text-danger">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                {{ Form::label("Company", null) }}
                                {{Form::text("company", null,["class" => "form-control"])}}
                                @if ($errors->has('company'))
                                <div class="error text-danger">{{ $errors->first('company') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                {{ Form::label("Address", null) }}
                                {{Form::textarea("address", null,["class" => "form-control",'rows' => '3'])}}
                                @if ($errors->has('address'))
                                <div class="error text-danger">{{ $errors->first('address') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                {{ Form::label("Opening Balance", null) }}
                                {{Form::text("opening_balance",null,["class" => "form-control",'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"])}}
                                @if ($errors->has('opening_balance'))
                                <div class="error text-danger">{{ $errors->first('opening_balance') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Save</button>
                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('read-suppliers'))
                        <a href="{{route('suppliers.index', $subdomain)}}" type="button"
                            class="btn btn-danger">Cancel</a>
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
