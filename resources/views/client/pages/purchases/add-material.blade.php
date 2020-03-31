@extends('layouts.client')

@section('title')
Add Material
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class="m-0 text-dark">Add Material to Purchase #{{$purchase->poNumber}}</h3>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        @include('massages.success')
        {{-- @include('massages.errors') --}}
        @include('massages.warning')
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5>Purchase Info</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>PO</th>
                                    <th>Supplier</th>
                                    <th>Account</th>
                                    <th>Status</th>
                                    <th>Purchase Date</th>
                                    <th>Receive Date</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                </tr>
                                <tr>
                                    <td>{{$purchase->poNumber}}</td>
                                    <td>{{$purchase->supplier->name}}</td>
                                    <td>{{$purchase->account->accountName}}</td>
                                    <td>{!! Helper::purchaseStatusLabel($purchase->status) !!}</td>
                                    <td>{{$purchase->purchaseDate}}</td>
                                    <td>{{$purchase->receiveDate}}</td>
                                    <td>{{$purchase->created_at->diffForHumans()}}</td>
                                    <td>{{$purchase->updated_at->diffForHumans()}}</td>
                                </tr>
                                <tr class="text-center">
                                    <th colspan="4">Note</th>
                                    <th colspan="4">Terms & Condition</th>
                                </tr>

                                <tr>
                                    <td colspan="4">{{$purchase->note}}</td>
                                    <td colspan="4">{{$purchase->condition}}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if($purchase->status ==1)
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5>Add Material Info</h5>
                    </div>
                    {!! Form::open(['route' => ['purchases.materials.store', $subdomain, $purchase->id], 'method'
                    =>'post']) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('Material', null) !!}
                                    {!! Form::select('material_id',['' => 'Choose an option'] + $materials, null,
                                    ['class' => 'form-control select2']) !!}
                                    @if ($errors->has('material_id'))
                                    <div class="error text-danger">{{ $errors->first('material_id') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {!! Form::label('quantity','Quantity') !!}
                                    {!! Form::text('quantity', null, ['class' => 'form-control quantity',
                                    'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g,
                                    '$1');"]) !!}
                                    @if ($errors->has('quantity'))
                                    <div class="error text-danger">{{ $errors->first('quantity') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {!! Form::label('rate','Rate') !!}
                                    {!! Form::text('rate', null, ['class' => 'form-control rate' ,
                                    'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g,
                                    '$1');"])
                                    !!}
                                    @if ($errors->has('rate'))
                                    <div class="error text-danger">{{ $errors->first('rate') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {!! Form::label('total','Total') !!}
                                    {!! Form::text('total', null, ['class' => 'form-control total readonly' ,
                                    'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g,
                                    '$1');"]) !!}
                                    @if ($errors->has('total'))
                                    <div class="error text-danger">{{ $errors->first('total') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label("Note", null) }}
                                    {{Form::textarea("note", null,["class" => "form-control", 'rows' => 3])}}
                                    @if ($errors->has('note'))
                                    <div class="error text-danger">{{ $errors->first('note') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Save</button>
                        <a href="{{route('purchases.show', [$subdomain, $purchase->id])}}" type="button"
                            class="btn btn-danger">Cancel</a>
                    </div>
                    {!! Form::close() !!}
                </div><!-- /.card -->
            </div>
            @endif

        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection


@push('scripts')
<script>
    $(document).ready(function () {

            $(".quantity,.rate").on('change',function () {
                calculation();
            });

        });

        function calculation(){
            $('.total').val($('.quantity').val() * $('.rate').val());
        }

</script>
@endpush
