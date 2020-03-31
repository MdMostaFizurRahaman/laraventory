@extends('layouts.client')

@section('title')
Product Transfers
@endsection


@section('content')

<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Product Transfers History</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        @include('massages.success')
        @include('massages.error')
        @include('massages.warning')
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5>Product Transfer List</h5>
                    </div>

                    {!! Form::open(['method'=>'GET', 'action'=>['ProductTransferController@index',$subdomain]]) !!}

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('pt_number', 'PT Number') !!}
                                    {!! Form::text('pt_number', request()->pt_number, ['class' =>'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('branch_id', 'Branch') !!}
                                    {!! Form::select('branch_id',['0' => 'All'] + $branches,
                                    request()->get('branch_id'),
                                    ['class'
                                    => 'form-control select2']) !!}
                                </div>
                            </div>



                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('processing_start_date', 'Processing Start Date') !!}
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        {!! Form::text('processing_start_date', request()->processing_start_date,
                                        ['class'=>'form-control multi-date float-right','autocomplete'=>'off'])
                                        !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('processing_end_date', 'Processing End Date') !!}
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        {!! Form::text('processing_end_date', request()->processing_end_date,
                                        ['class'=>'form-control multi-date float-right','autocomplete'=>'off'])
                                        !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('receive_start_date', ' Expected Receive Start Date') !!}
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        {!! Form::text('receive_start_date', request()->receive_start_date,
                                        ['class'=>'form-control multi-date float-right','autocomplete'=>'off'])
                                        !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('receive_end_date', 'Expected Receive End Date') !!}
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        {!! Form::text('receive_end_date', request()->receive_end_date,
                                        ['class'=>'form-control multi-date float-right','autocomplete'=>'off'])
                                        !!}
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.row -->
                        <button type="submit" class="btn btn-primary"> Filter </button>
                    </div>
                    {!! Form::close() !!}

                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th>ID</th>
                                <th>PT#</th>
                                <th>Branch</th>
                                <th>Processing Date</th>
                                <th>Expected Receive Date</th>
                                <th class="text-center">Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                @foreach ($productTransfers as $productTransfer)
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
                                    <td>
                                        @if(Auth::user()->hasRole('admin') ||
                                        Auth::user()->can('read-product-transfers'))
                                        <a href="{{route('product-transfers.show',[$subdomain, $productTransfer->id])}}"
                                            class="btn btn-sm btn-info" data-toggle="tooltip" title="Detail"><i
                                                class="fa fa-eye"></i></a>
                                        @endif
                                        @if ($productTransfer->status == 1)
                                        <a href="{{route('product-transfers.addProductCreate',[$subdomain, $productTransfer->id])}}"
                                            class="btn btn-sm btn-success" data-toggle="tooltip" title="Add Products"><i
                                                class="fa fa-plus"></i></a>
                                        @endif
                                        @if ($productTransfer->status <1)
                                        @if(Auth::user()->
                                            hasRole('admin') ||
                                            Auth::user()->can('update-product-transfers'))
                                            <a href="{{route('product-transfers.edit',[$subdomain, $productTransfer->id])}}"
                                                class="btn btn-sm btn-primary" data-toggle="tooltip" title="Update"><i
                                                    class="fa fa-edit"></i></a>
                                            @endif

                                            @if(Auth::user()->hasRole('admin') ||
                                            Auth::user()->can('delete-product-transfers'))

                                            <a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                title="Delete"
                                                onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $productTransfer->id }}').submit(); } event.returnValue = false; return false;">
                                                <i class="fa fa-trash"></i></a>
                                            {!! Form::open(['method'=>'DELETE',
                                            'action'=>['ProductTransferController@destroy',
                                            $subdomain, $productTransfer->id],
                                            'id'=>'deleteForm'.$productTransfer->id]) !!}
                                            {!! Form::close() !!}
                                            @endif
                                            @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer pb-0">
                        <ul class="pagination pagination-sm m-0 float-right">
                            Page {{ $productTransfers->currentPage() }} , showing {{ $productTransfers->count() }}
                            records out of {{ $productTransfers->total() }} total
                        </ul>
                    </div>
                    <div class="card-footer py-2">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $productTransfers->appends(request()->all())->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function () {

        $('.multi-date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

    });
</script>
@endpush
