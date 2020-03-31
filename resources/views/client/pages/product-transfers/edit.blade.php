@extends('layouts.client')

@section('title')
Edit Product Transfers
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-md-6">
                <h3 class="m-0 text-dark">Edit Product Transfers</h3>
            </div>
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        {{-- @include('massages.success') --}}
        {{-- @include('massages.errors') --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    {!! Form::model($productTransfer, ['route' => ['product-transfers.update', $subdomain,
                    $productTransfer->id],
                    'method'
                    =>'put']) !!}
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
                                        {!! Form::text('expected_receive_date', null, ['class'=>'form-control
                                        float-right'])
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
                        @if ($productTransfer->status == 0)
                        <button type="submit" name="action" value="save&draft" class="btn btn-primary"><i
                                class="fa fa-save mr-2"></i>Update</button>
                        <button type="submit" name="action" value="save&startProcess" class="btn btn-info"><i
                                class="fas fa-paper-plane mr-2"></i>Save & Process Start</button>
                        <a href="{{route('product-transfers.index', $subdomain)}}" type="button"
                            class="btn btn-danger">Back</a>
                        @else
                        <a href="{{route('product-transfers.index', $subdomain)}}" type="button"
                            class="btn btn-danger"><i class="fas fa-backward mr-2"></i>Back</a>
                        @endif
                    </div>
                    {!! Form::close() !!}
                </div><!-- /.card -->
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
@endsection

@push('scripts')


<script>
    $(document).ready(function () {
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        });
</script>

@endpush
