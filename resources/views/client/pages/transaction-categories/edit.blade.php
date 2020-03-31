@extends('layouts.client')

@section('title')
Transaction Categories
@endsection

@push('styles')

@endpush


@section('content')

<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Transaction Categories</h1>
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
                        <h5>Edit Transaction Category Info</h5>
                    </div>

                    {!! Form::model($transactionCategory, ['method'=>'PATCH',
                    'action'=>['TransactionCategoryController@update',
                    $subdomain, $transactionCategory->id]]) !!}

                    <div class="card-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('name', 'Category Name') !!}
                                {!! Form::text('name', null, ['class' =>'form-control']) !!}
                                @if ($errors->has('name'))
                                <div class="error text-danger">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                {!! Form::label('description', 'Description') !!}
                                {!! Form::textarea('description', null, ['class' =>'form-control', 'rows'
                                =>
                                3]) !!}
                                @if ($errors->has('description'))
                                <div class="error text-danger">{{ $errors->first('description') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="icheck-primary">
                                    {!! Form::checkbox('status', 1, null, ['id'=>'status', 'class'=>'form-control']) !!}
                                    {!! Form::label('status', '&nbsp;Active') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i> Save</button>

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-transaction-categories']))
                        <a href="{{route('transaction-categories.index', $subdomain)}}" type="submit"
                            class="btn btn-danger">
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
