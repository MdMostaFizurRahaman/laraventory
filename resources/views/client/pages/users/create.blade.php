@extends('layouts.client')

@section('title')
Add User
@endsection

@push('styles')

@endpush

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Create User</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header with-border">
                        <h3 class="card-title">Create User Info</h3>
                    </div>
                    {!! Form::open(['route' => ['users.store', $subdomain], 'method' =>'post', 'files'=>true]) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label("Full Name", null) }}
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
                                    {!! Form::label('password', 'Password') !!}
                                    {!! Form::password('password', ['class'=>'form-control']) !!}
                                    @if ($errors->has('password'))
                                    <div class="error text-danger">{{ $errors->first('password') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {!! Form::label('password_confirmation', 'Confirm Password') !!}
                                    {!! Form::password('password_confirmation', ['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    <div class="icheck-primary">
                                        {!! Form::checkbox('status', '1', 1, ['id'=>'status', 'class'=>'form-control'])
                                        !!}
                                        {!! Form::label('status', '&nbsp;Active') !!}
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label("Address", null) }}
                                    {{Form::textarea("address", null,["class" => "form-control",'rows' => '3'])}}
                                    @if ($errors->has('address'))
                                    <div class="error text-danger">{{ $errors->first('address') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {!! Form::label("role_id", 'Role') !!}
                                    {!! Form::select('role_id',['' => 'Choose an option'] + $roles, null, ['class' =>
                                    'form-control select2']) !!}
                                    @if ($errors->has('role_id'))
                                    <div class="error text-danger">{{ $errors->first('role_id') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary"><i
                                        class="fa fa-save mr-2"></i>Save</button>
                                @if(Auth::user()->hasRole('admin') || Auth::user()->can(['read-users']))
                                <a href="{{route('users.index', $subdomain)}}" type="button"
                                    class="btn btn-danger">Cancel</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div><!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection
