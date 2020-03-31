@extends('layouts.client')

@section('title')
Edit Branch Product
@endsection
@push('styles')
<style>
    span.select2.select2-container.select2-container--bootstrap4 {
        pointer-events: none;
        opacity: 0.7;
    }
</style>
@endpush

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Update Branch Product</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        {{-- @include('massages.errors') --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    {!! Form::model($branchProductInventory,['route' => ['branch-product-inventories.update',
                    $subdomain,
                    $branchProductInventory->id], 'method'
                    =>'put', 'files'=>true]) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('product_id', 'Product') !!}
                                    {!! Form::select('product_id',['' => 'Choose an option'] + $products, null,
                                    ['class' => 'form-control select2']) !!}
                                    @if ($errors->has('product_id'))
                                    <div class="error text-danger">{{ $errors->first('product_id') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('branch_id', 'Branch') !!}
                                    {!! Form::select('branch_id',['' => 'Choose an option'] + $branches, null,
                                    ['class' => 'form-control select2']) !!}
                                    @if ($errors->has('branch_id'))
                                    <div class="error text-danger">{{ $errors->first('branch_id') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {{ Form::label("quantity", "Quantity") }}
                                    {{Form::text("quantity",null,["class" => "form-control",'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"])}}
                                    @if ($errors->has('quantity'))
                                    <div class="error text-danger">{{ $errors->first('quantity') }}</div>
                                    @endif
                                </div>


                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label("sale_price", "Sale Price") }}
                                    {{Form::text("sale_price", null,["class" => "form-control",'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"])}}
                                    @if ($errors->has('sale_price'))
                                    <div class="error text-danger">{{ $errors->first('sale_price') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {{ Form::label("vat","VAT %") }}
                                    {{Form::text("vat",0,["class" => "form-control",'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"])}}
                                    @if ($errors->has('vat'))
                                    <div class="error text-danger">{{ $errors->first('vat') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {{ Form::label("alert_quantity", "Alert Quantity") }}
                                    {{Form::text("alert_quantity",0,["class" => "form-control",'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"])}}
                                    @if ($errors->has('alert_quantity'))
                                    <div class="error text-danger">{{ $errors->first('alert_quantity') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <div class="icheck-primary">
                                        {!! Form::checkbox('status', '1', null, ['id'=>'status',
                                        'class'=>'form-control'])
                                        !!}
                                        {!! Form::label('status', '&nbsp;Active') !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Save</button>
                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-branch-product-inventories']))
                        <a href="{{route('branch-product-inventories.index', $subdomain)}}" class="btn btn-danger"><i
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
