@extends('layouts.client')

@section('title')
Material Categories
@endsection


@section('content')

<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Material Categories</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        @include('massages.success')
        @include('massages.error')
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5>Create Material Category Info</h5>
                    </div>
                    {!! Form::open(array('url' => route('material-categories.store' ,$subdomain),
                    'method' => 'POST')) !!}
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
                                {!! Form::textarea('description', null, ['rows' => '3',
                                'class' => 'form-control']) !!}
                            </div>

                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-material-categories']))
                        <a href="{{route('material-categories.index', $subdomain)}}" type="submit"
                            class="btn btn-danger"> Cancel</a>
                        @endif
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
