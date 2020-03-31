@extends('layouts.client')

@section('title')
Edit Product
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Update Product</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        {{-- @include('massages.errors') --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    {!! Form::model($product,['route' => ['products.update', $subdomain, $product->id], 'method'
                    =>'put', 'files'=>true]) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label("Product Name", null) }}
                                    {{Form::text("name", null,["class" => "form-control"])}}
                                    @if ($errors->has('name'))
                                    <div class="error text-danger">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {{ Form::label("Product Code", null) }}
                                    {{Form::text("code", null,["class" => "form-control"])}}
                                    @if ($errors->has('code'))
                                    <div class="error text-danger">{{ $errors->first('code') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('category_id', 'Category') !!}
                                    {!! Form::select('category_id',$categories, null, ['class' => 'form-control
                                    select2'])
                                    !!}
                                    @if ($errors->has('category_id'))
                                    <div class="error text-danger">{{ $errors->first('category_id') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {{ Form::label("batch_quantity","Batch Quantity") }}
                                    {{Form::text("batch_quantity", null,["class" => "form-control",'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"])}}
                                    @if ($errors->has('batch_quantity'))
                                    <div class="error text-danger">{{ $errors->first('batch_quantity') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {{ Form::label("vat", "VAT %") }}
                                    {{Form::text("vat",null,["class" => "form-control",'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"])}}
                                    @if ($errors->has('vat'))
                                    <div class="error text-danger">{{ $errors->first('vat') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {{ Form::label("sale_price", "Sale Price") }}
                                    {{Form::text("sale_price", null,["class" => "form-control",'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"])}}
                                    @if ($errors->has('sale_price'))
                                    <div class="error text-danger">{{ $errors->first('sale_price') }}</div>
                                    @endif
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    {!! Form::label('currency_id', 'Currency') !!}
                                    {!! Form::select('currency_id',$currencies, null, ['class' => 'form-control
                                    select2'])
                                    !!}
                                    @if ($errors->has('currency_id'))
                                    <div class="error text-danger">{{ $errors->first('currency_id') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {{ Form::label("alert_quantity", "Alert Quantity") }}
                                    {{Form::text("alert_quantity",null,["class" => "form-control",'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"])}}
                                    @if ($errors->has('alert_quantity'))
                                    <div class="error text-danger">{{ $errors->first('alert_quantity') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('unit_id', 'Unit') !!}
                                    {!! Form::select('unit_id',$units, null, ['class' => 'form-control select2']) !!}
                                    @if ($errors->has('unit_id'))
                                    <div class="error text-danger">{{ $errors->first('unit_id') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="icheck-primary">
                                        {!! Form::checkbox('is_numeric', 1, null, ['id'=>'is_numeric',
                                        'class'=>'form-control']) !!}
                                        {!! Form::label('is_numeric', '&nbsp;Take Decimal Quantity') !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label("Description", null) }}
                                    {{Form::textarea("description", null,["class" => "form-control",'rows' => '2'])}}
                                    @if ($errors->has('description'))
                                    <div class="error text-danger">{{ $errors->first('description') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {!! Form::label('image', 'Image') !!}
                                    {!! Form::file('image', null, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Save</button>
                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-products']))
                        <a href="{{route('products.index', $subdomain)}}" class="btn btn-danger"><i
                                class="fas fa-backward fa-fw"></i> Back</a>
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
    $(document).ready(function () {
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        });
</script>

@endpush
