@extends('layouts.client')

@section('title')
Costs
@endsection


@section('content')

<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Create Cost</h1>
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
                        <h5>Create Cost Info</h5>
                    </div>

                    {!! Form::open(array('url' => route('costs.store' ,$subdomain),
                    'method' => 'POST')) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('cost_type_id', 'Cost Type') !!}
                                    {!! Form::select('cost_type_id',['' => 'Choose an option'] + $costTypes, null,
                                    ['class'
                                    => 'form-control select2']) !!}
                                    @if ($errors->has('cost_type_id'))
                                    <div class="error text-danger">{{ $errors->first('cost_type_id') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {!! Form::label('purchase_id', 'PO Number') !!}
                                    {!! Form::select('purchase_id',['' => 'Choose an option'] + $purchases, null,
                                    ['class'
                                    => 'form-control select2']) !!}
                                    @if ($errors->has('purchase_id'))
                                    <div class="error text-danger">{{ $errors->first('purchase_id') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {!! Form::label('amount', 'Cost Amount') !!}
                                    {!! Form::text('amount', null, ['class' =>'form-control','oninput'=>"this.value =
                                    this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"]) !!}
                                    @if ($errors->has('amount'))
                                    <div class="error text-danger">{{ $errors->first('amount') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('description', 'Description') !!}
                                    {!! Form::textarea('description', null, ['rows' => '3', 'class' => 'form-control'])
                                    !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i> Save</button>

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-costs']))
                        <a href="{{route('costs.index', $subdomain)}}" type="submit" class="btn btn-danger">
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
