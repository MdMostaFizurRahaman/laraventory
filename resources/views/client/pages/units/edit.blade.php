@extends('layouts.client')

@section('title')
Units
@endsection


@section('content')

<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Units</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        @include('massages.success')
        @include('massages.error')
        @include('massages.warning')
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">

                    <div class="card-header">
                        <h5>Edit Unit Info</h5>
                    </div>
                    {!! Form::model($unit, ['method'=>'PATCH', 'action'=>['UnitController@update', $subdomain,
                    $unit->id]]) !!}
                    <div class="card-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('name', 'Short Name') !!}
                                {!! Form::text('name', null,
                                ['class' =>'form-control']) !!}
                                @if ($errors->has('name'))
                                <div class="error text-danger">{{ $errors->first('name') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                {!! Form::label('display_name', 'Display Name') !!}
                                {!! Form::text('display_name', null, ['class' =>'form-control']) !!}
                                @if ($errors->has('display_name'))
                                <div class="error text-danger">{{ $errors->first('display_name') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                {!! Form::label('description', 'Description') !!}
                                {!! Form::textarea('description', null, ['rows' => '3', 'class' => 'form-control'])
                                !!}
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Update</button>

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-units']))
                        <a href="{{route('units.index', $subdomain)}}" type="button" class="btn btn-danger">Cancel</a>
                        @endif
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
