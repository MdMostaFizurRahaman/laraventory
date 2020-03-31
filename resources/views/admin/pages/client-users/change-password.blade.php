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
                <h1 class="m-0 text-dark">Change Client User Password</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    {!! Form::model($user, ['method'=>'PATCH',
                    'action'=>['Admin\ClientUserController@changePasswordStore', $user->id]]) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('name', 'Name') !!}
                                    <input class="form-control" disabled="disabled" type="text"
                                        value="{{ $user->name }}">
                                </div>

                                <div class="form-group">
                                    {!! Form::label('email', 'Email') !!}
                                    <input class="form-control" disabled="disabled" type="text"
                                        value="{{ $user->email }}">
                                </div>

                                <div class="form-group">
                                    {!! Form::label('password', 'New Password') !!}
                                    {!! Form::password('password', ['class'=>'form-control']) !!}
                                    @if ($errors->has('password'))
                                    <div class="error text-danger">{{ $errors->first('password') }}</div>
                                    @endif
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
                            Auth::guard('admin')->user()->can(['read-client-users']))
                            <a href="{{route('client-users.index')}}" type="button" class="btn btn-danger">Cancel</a>
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
