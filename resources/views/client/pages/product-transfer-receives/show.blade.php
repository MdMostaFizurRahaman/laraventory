@extends('layouts.client')

@section('title')
Product Transfers Details
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-md-6">
                <h3 class="m-0 text-dark">Product Transfers Details</h3>
            </div><!-- /.col -->
            <div class="col-md-6 text-right">

            </div>
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5>Product Transfers Info</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th style="width: 20%;">ID.</th>
                                <td style="width: 80%;">{{ $productTransfer->id }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">PT</th>
                                <td style="width: 80%;">{{ $productTransfer->pt_number }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Branch</th>
                                <td style="width: 80%;">
                                    {{ $productTransfer->branch ? $productTransfer->branch->name : '' }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Branch Address</th>
                                <td style="width: 80%;">
                                    {{ $productTransfer->branch ? $productTransfer->branch->address : ''}}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Processing Date</th>
                                <td style="width: 80%;">{{ $productTransfer->processing_date }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Process Completed Date</th>
                                <td style="width: 80%;">{{ $productTransfer->process_completed_date }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Expected Receive Date</th>
                                <td style="width: 80%;">{{ $productTransfer->expected_receive_date }}</td>
                            </tr>
                            <tr>
                                <th style="width: 20%;">Note</th>
                                <td style="width: 80%;">{{ $productTransfer->note }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Rejection Note</th>
                                <td style="width: 80%;">{{ $productTransfer->rejection_note }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Rejected By</th>
                                <td style="width: 80%;">
                                    {{ $productTransfer->rejectedBy ? $productTransfer->rejectedBy->name : '' }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Received Date</th>
                                <td style="width: 80%;">{{ $productTransfer->received_date }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Received By</th>
                                <td style="width: 80%;">
                                    {{ $productTransfer->receivedBy ? $productTransfer->receivedBy->name : '' }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Status</th>
                                <td style="width: 80%;">{!! Helper::productTransferStatusLabel($productTransfer->status)
                                    !!}
                                </td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Created At</th>
                                <td style="width: 80%;">{{ $productTransfer->created_at->diffForHumans() }}</td>
                            </tr>
                            <tr>
                                <th style="width: 20%;">Updated At</th>
                                <td style="width: 80%;">{{ $productTransfer->updated_at->diffForHumans() }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Product info section --}}
        @include('massages.success')
        @include('massages.warning')

        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="d-inline-block float-left">Products Info</h5>
                        <div class="float-right">
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('update-product-transfers'))

                            @if (in_array($productTransfer->status ,[2]))
                            <a href="{{route('product-transfer-receives.receivedReject', [$subdomain, $productTransfer->id])}}"
                                class="btn btn-danger">Transfer Reject</a>
                            @endif

                            @if (in_array($productTransfer->status ,[2,3]))
                            <a href="{{route('product-transfer-receives.create', [$subdomain, $productTransfer->id])}}"
                                class="btn btn-primary"><i class="fas fa-handshake"></i> Receive Item</a>
                            @endif

                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th>#</th>
                                <th>Product Name</th>
                                <th class="text-center">Quantity</th>
                                <th>Rate</th>
                                <th class="text-right">Amount</th>
                                @if ($productTransfer->status == 1)
                                <th class="text-center">Actions</th>
                                @endif
                            </thead>
                            <tbody>
                                @foreach ($productTransfer->productTransferItems()->get() as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->product ? $item->product->name : ''}}</td>
                                    <td class="text-center">
                                        {{$item->quantity}}
                                        <small class="d-block">Added By
                                            <span
                                                class="text-primary">{{ $item->createdBy ? $item->createdBy->name : "" }}</span></small>
                                    </td>
                                    <td>{{$item->rate}}</td>
                                    <td class="text-right">{{Helper::money($item->total)}}</td>
                                    @if ($productTransfer->status == 1)
                                    <td class="text-center">

                                        <a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete"
                                            onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $item->id }}').submit(); } event.returnValue = false; return false;"><i
                                                class="fa fa-trash"></i></a>

                                        {!! Form::open(['method'=>'DELETE',
                                        'action'=>['ProductTransferController@productItemDestroy',
                                        $subdomain,$productTransfer->id,
                                        $item->id], 'id'=>'deleteForm'.$item->id]) !!}
                                        {!! Form::close() !!}
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right text-bold">Total Amount</td>
                                    <td class="text-right text-bold">
                                        {{Helper::money($productTransfer->productTransferItems()->sum('total'))}}</td>
                                    @if ($productTransfer->status == 1)
                                    <td></td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @if ($productTransfer->productTransferItems()->get()->count() > 0 && $productTransfer->status == 1)
                    <div class="card-footer">

                        <a href="#" class="btn btn-info btn-sm" data-toggle="tooltip" title="Complete
                        Process"
                            onclick="if (confirm(&quot;Are you sure you want to Complete ?&quot;)) { document.getElementById('processCompleted{{ $productTransfer->id }}').submit(); } event.returnValue = false; return false;">Complete
                            Process</a>

                        {!! Form::open(['method'=>'POST',
                        'action'=>['ProductTransferController@processCompleted',
                        $subdomain,$productTransfer->id], 'id'=>'processCompleted'.$productTransfer->id]) !!}
                        {!! Form::close() !!}
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div><!-- /.container-fluid -->
</div>
@endsection

@push('scripts')


<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4'
        });
    });
</script>

@endpush
