@extends('layouts.client')

@section('title')
Product Transfer
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h3 class="m-0 text-dark">Product Transfer</h3>
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
                        <h5>Product Transfer Info</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <th>PT#</th>
                                    <th>Branch</th>
                                    <th>Processing Date</th>
                                    <th>Expected Receive Date</th>
                                    <th class="text-center">Status</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                </tr>
                                <tr>
                                    <td>{{$productTransfer->id}}</td>
                                    <td>{{$productTransfer->pt_number}}</td>
                                    <td>{{ $productTransfer->branch ? $productTransfer->branch->name : '' }}</td>
                                    <td>{{$productTransfer->processing_date}}</td>
                                    <td>{{$productTransfer->expected_receive_date}}</td>
                                    <td class="text-center">{!!
                                        Helper::productTransferStatusLabel($productTransfer->status)
                                        !!}</td>
                                    <td>{{$productTransfer->created_at->diffForHumans()}}</td>
                                    <td>{{$productTransfer->updated_at->diffForHumans()}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if($productTransfer->status == 2)
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5>Reject Product Transfer Info</h5>
                    </div>
                    {!! Form::open(['action'=>['ProductTransferController@transferRejectStore', $subdomain,
                    $productTransfer->id], 'method'
                    =>'post']) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label("rejection_note", "Rejection Note") }}
                                    {{Form::textarea("rejection_note", null,["class" => "form-control", 'rows' => 2])}}
                                    @if ($errors->has('rejection_note'))
                                    <div class="error text-danger">{{ $errors->first('rejection_note') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" onclick="if (confirm(&quot;Are you sure you want to Reject ?&quot;)) { return true; } event.returnValue = false; return false;"><i class="fa fa-ban mr-2"></i>Reject</button>
                        <a href="{{route('product-transfers.show', [$subdomain, $productTransfer->id])}}" type="button"
                            class="btn btn-danger">Back</a>
                    </div>
                    {!! Form::close() !!}
                </div><!-- /.card -->
            </div>
            @endif


            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="d-inline-block float-left">Product List</h5>
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
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection


@push('scripts')
<script>
    $(document).ready(function () {

        //For getting associate product price after changing product
        $('#product_id').on('change', function () {
                if ($(this).val() != '') {
                    const product_id = $(this).val();
                    const csrf_token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ route('client.getProductPrice', $subdomain) }}',
                        method: 'POST',
                        data: {'product_id': product_id, '_token': csrf_token},
                        //must be send csrf_token exactly to _token name otherwise not work
                        success: function (data) {
                            $('#rate').val(data);
                            calculation();
                        }
                    });
                } else {
                    $('#rate').val('0');
                }
            })

            $(".quantity,.rate").on('change',function () {
                calculation();
            });

        });

        function calculation(){
            $('.total').val($('.quantity').val() * $('.rate').val());
        }

</script>
@endpush
