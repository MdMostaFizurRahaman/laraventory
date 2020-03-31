@extends('layouts.client')

@section('title')
Edit Production
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-md-6">
                <h3 class="m-0 text-dark">Production #{{$production->productionNumber}} {!!
                    Helper::productionStatusLabel($production->status) !!} </h3>
            </div><!-- /.col -->
            <div class="col-lg-6 text-right">
                @if ($production->status == 1)
                <a href="{{route('productions.showCompleteForm', [$subdomain, $production->id])}}"
                    class="btn btn-primary mr-2"><i class="fas fa-clipboard-list mr-2"></i>Complete</a>
                @endif
            </div>
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        @include('massages.success')
        @include('massages.errors')
        @include('massages.warning')
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    {!! Form::model($production, ['route' => ['productions.update', $subdomain, $production->id],
                    'method' =>'put']) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
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
                                    {{ Form::label("note","Note") }}
                                    {{Form::textarea("note", null,["class" => "form-control", 'rows' => 3])}}

                                    @if ($errors->has('note'))
                                    <div class="error text-danger">{{ $errors->first('note') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Update</button>

                        <a href="{{route('productions.index', $subdomain)}}" type="button"
                            class="btn btn-danger">Cancel</a>

                    </div>
                    {!! Form::close() !!}
                </div><!-- /.card -->
            </div>
        </div>
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
