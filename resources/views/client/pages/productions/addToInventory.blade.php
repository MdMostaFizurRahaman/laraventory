@extends('layouts.client')

@section('title')
Edit Production
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-md-6">
                <h3 class="m-0 text-dark">Production Info </h3>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-info card-outline">
                    {{-- <div class="card-header"> --}}
                    {{-- <h5>Production Info</h5> --}}
                    {{-- </div> --}}
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th width="10%">PN#</th>
                                <th width="10%">Name</th>
                                <th width="10%">Production Date</th>
                                <th width="10%">Finish Date</th>
                                <th width="10%" class="text-right">Quantity</th>
                                <th width="10%" class="text-center">Status</th>
                                <th width="10%">Created At</th>
                                <th width="10%">Updated At</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$production->productionNumber}}</td>
                                    <td>{{$production->name}}</td>
                                    <td>{{$production->productionDate}}</td>
                                    <td>{{$production->finishDate}}</td>
                                    <td class="text-right">
                                        @if ($production->finishDate)
                                        {{ Helper::money($production->quantity)}}
                                        @endif
                                    </td>
                                    <td class="text-center">{!! Helper::productionStatusLabel($production->status) !!}
                                    </td>
                                    <td>{{$production->createdAt->diffForHumans()}}</td>
                                    <td>{{$production->updatedAt->diffForHumans()}}</td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @include('massages.success')

        {{-- @include('massages.errors') --}}
        <div class="row">
            @if($production->status ==2)
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    {!! Form::model($production, ['route' => ['productions.addToInventoryStore', $subdomain,
                    $production->id],
                    'method' =>'POST']) !!}
                    <div class="card-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-group">
                                    {!! Form::label('product_id','Select Product') !!}
                                    {!! Form::select('product_id',['' => 'Choose an option'] +
                                    $products, null, ['class'=>'form-control select2']) !!}
                                    @if ($errors->has('product_id'))
                                    <div class="error text-danger">{{ $errors->first('product_id') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label("input_quantity","Input Quantity") }}
                                {{Form::text("input_quantity", null,["class" => "form-control",'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"])}}
                                @if ($errors->has('input_quantity'))
                                <div class="error text-danger">{{ $errors->first('input_quantity') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Add to Batch</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            @endif

            <div class="col-md-12">
                @include('massages.warning')
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5>Product Inventory Added List</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th>SN.</th>
                                <th>Product Name</th>
                                <th>Input Quantity</th>
                                <th>Inventory Added Quantity</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                @if($production->status<3) <th>Actions</th>
                                    @endif

                            </thead>
                            <tbody>
                                @foreach ($production->batchQuantities as $batchQuantity)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$batchQuantity->product ? $batchQuantity->product->name_code_batch_quantity : ''}}
                                    </td>
                                    <td>{{$batchQuantity->input_quantity}}</td>
                                    <td>{{$batchQuantity->product_quantity}}</td>
                                    <td>
                                        <small
                                            class="text-primary">{{$batchQuantity->createdBy ? $batchQuantity->createdBy->name : ''}}</small>
                                    </td>
                                    <td>{{$batchQuantity->created_at->diffForHumans()}}</td>
                                    <td>{{$batchQuantity->updated_at->diffForHumans()}}</td>
                                    @if ($production->status < 3) <td>

                                        <a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete"
                                            onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $batchQuantity->id }}').submit(); } event.returnValue = false; return false;">
                                            <i class="fa fa-trash"></i></a>
                                        {!! Form::open(['method'=>'DELETE',
                                        'action'=>['ProductionController@batchQuantityDestroy', $subdomain,
                                        $batchQuantity->id],
                                        'id'=>'deleteForm'.$batchQuantity->id]) !!}
                                        {!! Form::close() !!}

                                        </td>
                                        @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($production->batchQuantities->count() >0 && $production->status ==2)
                    <div class="card-footer">
                        <a href="#" class="btn btn-success" data-toggle="tooltip"
                            onclick="if (confirm(&quot;Are you sure you want to add ?&quot;)) { document.getElementById('submitForm{{ $production->id }}').submit(); } event.returnValue = false; return false;">
                            Add To Inventory</a>
                        {!! Form::open(['method'=>'POST',
                        'action'=>['ProductionController@completedInventory', $subdomain,
                        $production->id],
                        'id'=>'submitForm'.$production->id]) !!}
                        {!! Form::close() !!}
                    </div>
                    @endif

                </div>
            </div>
        </div><!-- /.card -->


    </div>
</div>
</div><!-- /.container-fluid -->
</div>
@endsection

@push('scripts')


<script>
    $(document).ready(function () {
        //
        });
</script>

@endpush
