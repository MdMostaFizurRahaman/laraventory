@extends('layouts.admin')


@section('title')
Add Client
@endsection


@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Create Client Info</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    {!! Form::open(['route' => 'clients.store', 'method' =>'post']) !!}
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label("Client Name", null) }}
                                    {{Form::text("name", null,["class" => "form-control"])}}
                                    @if ($errors->has('name'))
                                    <div class="error text-danger">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {{ Form::label("Phone", null) }}
                                    {{Form::text("phone", null,["class" => "form-control"])}}
                                    @if ($errors->has('phone'))
                                    <div class="error text-danger">{{ $errors->first('phone') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {{ Form::label("Primary Email", null) }}
                                    {{Form::email("email", null,["class" => "form-control"])}}
                                    @if ($errors->has('email'))
                                    <div class="error text-danger">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {{ Form::label("Secondary Email", null) }}
                                    {{Form::email("secondary_email", null,["class" => "form-control"])}}
                                    @if ($errors->has('secondary_email'))
                                    <div class="error text-danger">{{ $errors->first('secondary_email') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {!! Form::label('client_website', 'Client Website') !!}
                                    {!! Form::text('client_website', null, ['class'=>'form-control']) !!}
                                    @if ($errors->has('client_website'))
                                    <div class="error text-danger">{{ $errors->first('client_website') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('client_url', 'Client URL') !!}
                                    {!! Form::text('client_url', null, ['class'=>'form-control']) !!}
                                    @if ($errors->has('client_url'))
                                    <div class="error text-danger">{{ $errors->first('client_url') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {!! Form::label('status', 'Status') !!}
                                    {!! Form::select('status', [''=>'Choose an option'] +
                                    Config::get('constant.ACTIVE_CLIENT_STATUSES'), null, ['class'=>'form-control
                                    select2']) !!}
                                    @if ($errors->has('status'))
                                    <div class="error text-danger">{{ $errors->first('status') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('contact_person_name', 'Contact Person Name') !!}
                                    {!! Form::text('contact_person_name', null, ['class'=>'form-control']) !!}
                                    @if ($errors->has('contact_person_name'))
                                    <div class="error text-danger">{{ $errors->first('contact_person_name') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('contact_person_phone', 'Contact Person Phone') !!}
                                    {!! Form::text('contact_person_phone', null, ['class'=>'form-control']) !!}
                                    @if ($errors->has('contact_person_phone'))
                                    <div class="error text-danger">{{ $errors->first('contact_person_phone') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('contact_person_secondary_phone', 'Contact Person Secondary Phone')
                                    !!}
                                    {!! Form::text('contact_person_secondary_phone', null, ['class'=>'form-control'])
                                    !!}
                                    @if ($errors->has('contact_person_secondary_phone'))
                                    <div class="error text-danger">
                                        {{ $errors->first('contact_person_secondary_phone') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('contact_person_email', 'Contact Person Email') !!}
                                    {!! Form::text('contact_person_email', null, ['class'=>'form-control']) !!}
                                    @if ($errors->has('contact_person_email'))
                                    <div class="error text-danger">{{ $errors->first('contact_person_email') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('address', 'Address') !!}
                                    {!! Form::textarea('address', null, ['class'=>'form-control', 'size' => '30x4']) !!}
                                    @if ($errors->has('contact_person_email'))
                                    <div class="error text-danger">{{ $errors->first('contact_person_email') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Save</button>

                            @if(Auth::guard('admin')->user()->hasRole('admin') ||
                            Auth::guard('admin')->user()->can(['read-clients']))
                            <a href="{{route('clients.index')}}" type="button" class="btn btn-danger">Cancel</a>
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
    });
</script>
@endpush
