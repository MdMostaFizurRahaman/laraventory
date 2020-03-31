@extends('layouts.client')

@section('title')
New Production
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Create Production</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        {{-- @include('massages.success') --}}
        {{-- @include('massages.errors') --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5>Create Production Info</h5>
                    </div>
                    {!! Form::open(['route' => ['productions.store', $subdomain], 'method' =>'post']) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label("name", "Production Name") }}
                                    {{Form::text("name", null,["class" => "form-control"])}}
                                    @if ($errors->has('name'))
                                    <div class="error text-danger">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('production_date', 'Production Date') !!}
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        {!! Form::text('production_date', null, ['class'=>'form-control float-right'])
                                        !!}
                                    </div>
                                    @if ($errors->has('production_date'))
                                    <div class="error text-danger">{{ $errors->first('production_date') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {{ Form::label("Note", null) }}
                                    {{Form::textarea("note", null,["class" => "form-control", 'rows' => 2])}}
                                    @if ($errors->has('note'))
                                    <div class="error text-danger">{{ $errors->first('note') }}</div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Save
                            Draft & Next</button>
                        <a href="{{route('productions.index', $subdomain)}}" type="button"
                            class="btn btn-danger">Cancel</a>

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
        $('#production_date').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'YYYY-MM-DD',
            },
        });

    });
</script>

@endpush
