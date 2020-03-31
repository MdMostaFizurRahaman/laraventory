@extends('layouts.admin')


@section('title')
Change Password
@endsection

@push('styles')

@endpush

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Change Admin User Password</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    {!! Form::model($admin, ['method'=>'PATCH',
                    'action'=>['Admin\AdminController@changePasswordStore', $admin->id]]) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                @if ($errors->has('password'))
                                <div class="error text-danger">{{ $errors->first('password') }}</div>
                                @endif
                                <div class="form-group">
                                    {!! Form::label('name', 'Name') !!}
                                    <input class="form-control" disabled="disabled" type="text"
                                        value="{{ $admin->name }}">
                                </div>

                                <div class="form-group">
                                    {!! Form::label('email', 'Email') !!}
                                    <input class="form-control" disabled="disabled" type="text"
                                        value="{{ $admin->email }}">
                                </div>

                                <div class="form-group">
                                    {!! Form::label('password', 'New Password') !!}
                                    {!! Form::password('password', ['class'=>'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('password_confirmation', 'Confirm Password') !!}
                                    {!! Form::password('password_confirmation', ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Save</button>

                            @if(Auth::guard('admin')->user()->hasRole('admin') ||
                            Auth::guard('admin')->user()->can(['read-admins']))
                            <a href="{{route('admins.index')}}" type="button" class="btn btn-danger">Cancel</a>
                            @endif
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

@push('scripts')
<script>
    $(document).ready(function () {

    });
</script>
@endpush
