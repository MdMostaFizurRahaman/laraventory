@extends('layouts.admin')

@section('title')
Currencies
@endsection


@section('content')

<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Currencies</h1>
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
                        <h5>Edit Currency Info</h5>
                    </div>
                    {!! Form::model($currency, ['method'=>'PATCH',
                    'action'=>['Admin\CurrencyController@update',$currency->id]]) !!}
                    <div class="card-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('name', 'Currency Name') !!}
                                {!! Form::text('name', null, ['class' =>'form-control']) !!}
                                @if ($errors->has('name'))
                                <div class="error text-danger">{{ $errors->first('name') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                {!! Form::label('symbol', 'Currency Symbol') !!}
                                {!! Form::text('symbol', null, ['class' =>'form-control']) !!}
                                @if ($errors->has('symbol'))
                                <div class="error text-danger">{{ $errors->first('symbol') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                {!! Form::label('ratio', 'Ratio') !!}
                                {!! Form::text('ratio', null, ['class' =>'form-control','oninput'=>"this.value =
                                this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"]) !!}
                                @if ($errors->has('ratio'))
                                <div class="error text-danger">{{ $errors->first('ratio') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>
                            Update</button>

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-currencies']))
                        <a href="{{route('currencies.index')}}" type="submit" class="btn btn-danger">
                            Cancel</a>
                        @endif
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
