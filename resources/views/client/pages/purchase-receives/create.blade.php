@extends('layouts.client')

@section('title')
New Receive
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h3 class="m-0 text-dark float-left">Purchase Order</h3>
                <a href="{{route('purchases.show', [$subdomain, $purchase->id])}}" type="button"
                    class="btn btn-danger float-right"><i class="fas fa-backward mr-2"></i>Cancel & Back</a>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
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
        </div>
    </div>

    @php
    $purchaseMaterials = $purchase->purchaseMaterials()->whereColumn('quantity','>','received_quantity')->get();
    @endphp
    @if ($purchaseMaterials->count() >0)
    {!! Form::open(['route' => ['purchases.receives.store', $subdomain, $purchase->id], 'method' =>'post']) !!}
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h5>Receive Item Info</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th>No</th>
                                <th>Material Name</th>
                                <th>Ordered</th>
                                <th>Received</th>
                                <th>Receive Quantity</th>
                            </thead>
                            <tbody>
                                @foreach($purchaseMaterials as $material)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$material->material->name}}</td>
                                    <td>{{$material->quantity}}</td>
                                    <td>{{$material->receivedQuantity}}</td>
                                    <td>
                                        <div class="form-group">
                                            {!! Form::text("receive_quantity[$material->id]", null, ['class' =>
                                            'form-control','oninput'=>"this.value = this.value.replace(/[^0-9.]/g,
                                            '').replace(/(\..*)\./g, '$1');"]) !!}
                                            {!! Form::hidden("max_quantity[$material->id]",$material->quantity -
                                            $material->receivedQuantity , ['class' => 'form-control']) !!}
                                            @if ($errors->has("receive_quantity.$material->id"))
                                            <div class="error text-danger">
                                                {{ $errors->first("receive_quantity.$material->id") }}</div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- @include('massages.success') --}}
        {{-- @include('massages.errors') --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5>Receive Info</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('receive_date', 'Receive Date') !!}
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        {!! Form::text('receive_date', null, ['class'=>'form-control float-right'])
                                        !!}
                                    </div>
                                    @if ($errors->has('receive_date'))
                                    <div class="error text-danger">{{ $errors->first('receive_date') }}</div>
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

                    </div>
                </div><!-- /.card -->
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary"><i
                            class="fas fa-hourglass-half mr-2"></i>Receive</button>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
    {!! Form::close() !!}
    @endif

</div>
@endsection


@push('scripts')
<script>
    $(document).ready(function () {
        $('#receive_date').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'YYYY-MM-DD',
            },
        });
    });
</script>
@endpush
