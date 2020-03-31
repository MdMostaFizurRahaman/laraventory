@extends('layouts.admin')


@section('title')
Add Client User
@endsection

@push('styles')

@endpush

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Create Client User Info</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    {!! Form::open(['route' => 'client-users.store', 'method' =>'post']) !!}
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    {!! Form::label('client_id', 'Client') !!}
                                    {!! Form::select('client_id', [''=>'Choose an option']+$clients, null,
                                    ['class'=>'form-control select2', 'id' => 'client_id']) !!}
                                    @if ($errors->has('client_id'))
                                    <div class="error text-danger">{{ $errors->first('client_id') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('role_id', 'Role') !!}
                                    {!! Form::select('role_id', [''=>'Choose an option']+$roles, null,
                                    ['class'=>'form-control select2', 'id'=>'role_id']) !!}
                                    @if ($errors->has('role_id'))
                                    <div class="error text-danger">{{ $errors->first('role_id') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('name', 'Name') !!}
                                    {!! Form::text('name', null, ['class'=>'form-control']) !!}
                                    @if ($errors->has('name'))
                                    <div class="error text-danger">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('email', 'Email') !!}
                                    {!! Form::text('email', null, ['class'=>'form-control']) !!}
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
        $('.select2').select2({
            placeholder: "Choose an option",
            theme: 'bootstrap4'
        });


        $("#client_id").on("change", function (e) {
            $('#role_id')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="">Loading</option>');
            $('#role_id').trigger('change');

            if ($('#client_id').val() == '') {
                $('#role_id')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">Choose an option</option>');
                $('#role_id').trigger('change');
            }
            else {
                $.ajax({
                    type: "POST",
                    data: {"_token": "{{ csrf_token() }}", client_id: $('#client_id').val()},
                    url: "{{ route('client.roles') }}",
                    success: function (data) {
                        $('#role_id')
                                .find('option')
                                .remove()
                                .end()
                                .append(data);
                        $('#role_id').trigger('change');
                    }
                });
            }
        });
    });

</script>
@endpush
