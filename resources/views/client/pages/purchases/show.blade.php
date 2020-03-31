@extends('layouts.client')

@section('title')
Purchases Details
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-md-6">
                <h3 class="m-0 text-dark">Purchase Info</h3>
            </div><!-- /.col -->
            <div class="col-md-6 text-right">

                @if ($purchase->status == 1 && $purchase->purchaseMaterials->count() > 0)
                @if(Auth::user()->hasRole('admin') || Auth::user()->can('update-purchases'))
                <a href="#" class="btn btn-success" onclick="if (confirm(&quot;Are you sure you want to submit ?&quot;)) { document.getElementById('purchaseSubmit{{ $purchase->id }}').submit(); } event.returnValue = false; return false;">Purchase
                    Submit</a>
                {!! Form::open(['method'=>'POST',
                'action'=>['PurchaseController@purchaseSubmit', $subdomain,$purchase->id],
                'id'=>'purchaseSubmit'.$purchase->id,'style'=>'display:inline-block']) !!}
                {!! Form::close() !!}
                @endif
                @endif

                @if (in_array($purchase->status ,[3,4]))
                @if(Auth::user()->hasRole('admin') || Auth::user()->can('update-purchases'))
                <a href="#" class="btn btn-success" onclick="if (confirm(&quot;Are you sure you want to confirm ?&quot;)) { document.getElementById('confirmReceived{{ $purchase->id }}').submit(); } event.returnValue = false; return false;">Confirm
                    Received</a>

                {!! Form::open(['method'=>'POST',
                'action'=>['PurchaseController@confirmReceived', $subdomain,$purchase->id],
                'id'=>'confirmReceived'.$purchase->id,'style'=>'display:inline-block']) !!}
                {!! Form::close() !!}
                @endif
                @endif

                @if (in_array($purchase->status ,[2,3]))
                @if(Auth::user()->hasRole('admin') || Auth::user()->can('create-receives'))
                <a href="{{route('purchases.receives.create', [$subdomain, $purchase->id])}}" class="btn btn-info mr-2"><i class="fas fa-hourglass-start mr-2"></i>Receive</a>
                @endif
                @endif

                @if (in_array($purchase->status ,[5,6]))
                @if(Auth::user()->hasRole('admin') || Auth::user()->can('create-bills'))
                <a href="{{route('purchases.bills.create', [$subdomain, $purchase->id])}}" class="btn btn-primary"><i class="fas fa-file-invoice-dollar mr-2"></i>Bill</a>
                @endif
                @endif

            </div>
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
                                    <th>Expected Receive Date</th>
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

        {{-- purchase Materials section --}}
        @include('massages.success')
        @include('massages.warning')
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="d-inline-block float-left">Materials Info</h5>
                        <div class="float-right">
                            @if ($purchase->status == 1)
                            <a href="{{route('purchases.materials.add', [$subdomain, $purchase->id])}}" class="btn btn-primary"><i class="fas fa-plus-circle fa-fw"></i> Add Item</a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th>#</th>
                                <th>Material Name</th>
                                <th>Note</th>
                                <th>Quantity</th>
                                <th>Rate</th>
                                <th class="text-right">Amount</th>
                                @if ($purchase->status == 1)
                                <th class="text-center">Actions</th>
                                @endif
                            </thead>
                            <tbody>
                                @foreach ($purchase->purchaseMaterials()->get() as $material)
                                <tr>
                                    <td>{{$material->id}}</td>
                                    <td>{{$material->material ? $material->material->name : ''}}</td>
                                    <td>{{$material->note}}</td>
                                    <td>{{$material->quantity}}</td>
                                    <td>{{$material->rate}}</td>
                                    <td class="text-right">{{Helper::money($material->total)}}</td>
                                    @if ($purchase->status == 1)
                                    <td class="text-center">
                                        <a href="{{route('purchases.materials.edit',[$subdomain,$purchase->id, $material->id])}}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>

                                        <a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete" onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $material->id }}').submit(); } event.returnValue = false; return false;"><i class="fa fa-trash"></i></a>
                                        {!! Form::open(['method'=>'DELETE',
                                        'action'=>['PurchaseController@removeMaterial', $subdomain,$purchase->id,
                                        $material->id], 'id'=>'deleteForm'.$material->id]) !!}
                                        {!! Form::close() !!}
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right text-bold">Total Amount</td>
                                    <td class="text-right text-bold">
                                        {{Helper::money($purchase->purchaseMaterials()->sum('total'))}}</td>
                                    @if ($purchase->status == 1)
                                    <td></td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        {{-- purchase received section --}}

        <div class="row">
            <div class="col-lg-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h5 class="d-inline-block float-left">Receive Info</h5>
                    </div>
                    <div class="card-body">
                        @foreach ($purchase->receives as $receive)
                        <div class="card-title mb-2 mt-2">
                            Receive Number: {{$receive->roNumber}}, Receive Date: {{$receive->receiveDate}}
                            @if(in_array($purchase->status, [3, 4]))
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('delete-receives'))
                            <a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete" onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $receive->id }}').submit(); } event.returnValue = false; return false;"><i class="fa fa-trash"></i></a>
                            {!! Form::open(['method'=>'DELETE', 'action'=>['ReceiveController@destroy', $subdomain,
                            $purchase->id, $receive->id], 'id'=>'deleteForm'.$receive->id]) !!}
                            {!! Form::close() !!}
                            @endif
                            @endif
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <th width="5%">#</th>
                                <th width="80%">Material Name</th>
                                <th width="10%">Quantity</th>
                            </thead>
                            <tbody>
                                @foreach ($receive->receiveMaterials as $material)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$material->material ? $material->material->name : ''}}</td>
                                    <td>{{$material->quantity}}</td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- purchase bills section --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h5 class="d-inline-block float-left">Bill Info</h5>
                    </div>
                    <div class="card-body">
                        @foreach ($purchase->bills as $bill)
                        <div class="card-title mb-2 mt-2">
                            Bill Number: {{$bill->billNumber}}, Bill Date: {{$bill->billDate}}

                            @if(in_array($purchase->status, [6,7]))
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('delete-bills'))
                            <a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete" onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $bill->id }}').submit(); } event.returnValue = false; return false;"><i class="fa fa-trash"></i></a>
                            {!! Form::open(['method'=>'DELETE', 'action'=>['PurchaseBillController@destroy', $subdomain,
                            $purchase->id, $bill->id], 'id'=>'deleteForm'.$bill->id]) !!}
                            {!! Form::close() !!}
                            @endif
                            @endif
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <th width="5%">#</th>
                                <th width="65%">Material Name</th>
                                <th width="10%">Quantity</th>
                                <th width="10%">Rate</th>
                                <th width="10%" class="text-right">Total</th>
                            </thead>
                            <tbody>
                                @foreach ($bill->billMaterials as $material)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$material->material->name}}</td>
                                    <td>{{$material->quantity}}</td>
                                    <td>{{$material->rate}}</td>
                                    <td class="text-right">{{Helper::money($material->total)}}
                                        {{$bill->currency->symbol}}</td>
                                </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <td colspan="4" class="text-right"><strong>Total</strong></td>
                                <td class="text-right">{{Helper::money($bill->billMaterials->sum('total'))}}
                                    {{$bill->currency->symbol}}</td>
                            </tfoot>
                        </table>
                        @endforeach
                    </div>
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