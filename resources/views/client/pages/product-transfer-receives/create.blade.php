@extends('layouts.client')

@section('title')
Add Product Transfers
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Add Product Transfer Info</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        {{-- @include('massages.success') --}}
        {{-- @include('massages.errors') --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    {!! Form::open(['route' => ['product-transfers.store', $subdomain], 'method' =>'post']) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('branch_id','Branch') !!}
                                    {!! Form::select('branch_id',['' => 'Choose an option'] + $branches, null,
                                    ['class' => 'form-control select2']) !!}
                                    @if ($errors->has('branch_id'))
                                    <div class="error text-danger">{{ $errors->first('branch_id') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('processing_date', 'Processing Date') !!}
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        {!! Form::text('processing_date', null, ['class'=>'form-control float-right'])
                                        !!}
                                    </div>
                                    @if ($errors->has('processing_date'))
                                    <div class="error text-danger">{{ $errors->first('processing_date') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('expected_receive_date', 'Expected Receive Date') !!}
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        {!! Form::text('expected_receive_date', null, ['class'=>'form-control float-right'])
                                        !!}
                                    </div>
                                    @if ($errors->has('expected_receive_date'))
                                    <div class="error text-danger">{{ $errors->first('expected_receive_date') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
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
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Save Draft</button>
                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-product-transfers']))
                        <a href="{{route('product-transfers.index', $subdomain)}}" type="button" class="btn btn-danger">Cancel</a>
                        @endif
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
    $(document).ready(function() {
        $('#processing_date').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'YYYY-MM-DD',
            },
        });
        $('#expected_receive_date').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'YYYY-MM-DD',
            },
        });

    });
</script>

@endpush
