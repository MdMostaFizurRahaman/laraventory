@extends('layouts.client')

@section('title')
    Edit Material
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content">
        <div class="content-header">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h3 class="m-0 text-dark">Update Purchase Material #{{$purchase->poNumber}}</h3>
              </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
        <div class="container-fluid">
            @include('massages.success')
            @include('massages.errors')
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-primary card-outline">
                    {!! Form::model($material, ['route' => ['purchases.materials.update', $subdomain, $purchase->id, $material->id], 'method' =>'put']) !!}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        {!! Form::label('Material', null) !!}
                                        {!! Form::select('material_id',['' => 'Choose an option'] + $materials, null, ['class' => 'form-control select2']) !!}
                                    @if ($errors->has('material_id'))
                                        <div class="error text-danger">{{ $errors->first('material_id') }}</div>
                                    @endif
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('Quantity', null) !!}
                                        {!! Form::number('quantity', null, ['class' => 'form-control quantity', 'step' => 'any']) !!}
                                    @if ($errors->has('quantity'))
                                        <div class="error text-danger">{{ $errors->first('quantity') }}</div>
                                    @endif
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('Rate', null) !!}
                                        {!! Form::number('rate', null, ['class' => 'form-control rate' , 'step' => 'any']) !!}
                                    @if ($errors->has('rate'))
                                        <div class="error text-danger">{{ $errors->first('rate') }}</div>
                                    @endif
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('Total', null) !!}
                                        {!! Form::number('total', null, ['class' => 'form-control total' , 'step' => 'any', 'readonly']) !!}
                                    @if ($errors->has('total'))
                                        <div class="error text-danger">{{ $errors->first('total') }}</div>
                                    @endif
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label("Note", null) }}
                                        {{Form::textarea("note", null,["class" => "form-control", 'rows' => 3])}}
                                    @if ($errors->has('note'))
                                        <div class="error text-danger">{{ $errors->first('note') }}</div>
                                    @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <button type="submit"   class="btn btn-primary"><i class="fa fa-save mr-2"></i>Save</button>
                                        <a href="{{route('purchases.edit', [$subdomain, $purchase->id])}}" type="button" class="btn btn-danger">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div><!-- /.card -->
            </div>
            <div class="col-lg-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5>Purchase Info</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="30%">PO</th>
                                    <td>{{$purchase->poNumber}}</td>
                                </tr>
                                <tr>
                                    <th width="30%">Supplier</th>
                                    <td>{{$purchase->supplier->name}}</td>
                                </tr>
                                <tr>
                                    <th width="30%">Account</th>
                                    <td>{{$purchase->account->accountName}}</td>
                                </tr>
                                <tr>
                                    <th width="30%">Purchase Date</th>
                                    <td>{{$purchase->purchaseDate}}</td>
                                </tr>
                                <tr>
                                    <th width="30%">Receive Date</th>
                                    <td>{{$purchase->receiveDate}}</td>
                                </tr>
                                <tr>
                                    <th width="30%">Note</th>
                                    <td>{{$purchase->note}}</td>
                                </tr>
                                <tr>
                                    <th width="30%">Terms & Condition</th>
                                    <td>{{$purchase->condition}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function () {
            $('.total').val($('.quantity').val() * $('.rate').val());

            $(".quantity,.rate").keyup(function () {
                $('.total').val($('.quantity').val() * $('.rate').val());
            });
        });
    </script>
@endpush


