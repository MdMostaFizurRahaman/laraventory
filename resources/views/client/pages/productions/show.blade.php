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
                <h3 class="m-0 text-dark">Production Info</h3>
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
        @include('massages.errors')
        @include('massages.warning')

        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="d-inline-block float-left">Materials Info</h5>
                        @if ($production->status == 0)
                        <a href="{{route('productions.materials.add', [$subdomain, $production->id])}}"
                            class="btn btn-primary float-right"><i class="fas fa-plus-circle fa-fw"></i> Add Item</a>
                        @endif
                    </div>
                    @if ($production->productionMaterials()->exists())
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th width="5%">#</th>
                                <th width="30%">Material Name</th>
                                <th width="10%">Quantity</th>
                                <th width="10%">Rate</th>
                                <th width="20%" class="text-right">Amount</th>
                                @if ($production->status == 0)
                                <th width="10%" class="text-center">Actions</th>
                                @endif
                            </thead>
                            <tbody>
                                @foreach ($production->productionMaterials as $material)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$material->material->name}}</td>
                                    <td>{{$material->quantity}}</td>
                                    <td>{{$material->rate}}</td>
                                    <td class="text-right">{{Helper::money($material->total)}}</td>
                                    @if ($production->status == 0)
                                    <td class="text-center">
                                        {{-- <a href="{{route('productions.materials.edit',[$subdomain,$production->id, $material->id])}}"
                                        class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit"><i
                                            class="fa fa-edit"></i></a> --}}

                                        <a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete"
                                            onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $material->id }}').submit(); } event.returnValue = false; return false;"><i
                                                class="fa fa-trash"></i></a>
                                        {!! Form::open(['method'=>'DELETE',
                                        'action'=>['ProductionController@removeMaterial',
                                        $subdomain,$production->id, $material->id], 'id'=>'deleteForm'.$material->id])
                                        !!}
                                        {!! Form::close() !!}
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right text-bold">Total</td>
                                    <td class="text-right">{{Helper::money($production->materialCost)}}</td>
                                    @if ($production->status == 0)
                                    <td></td>
                                    @endif
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="d-inline-block float-left">Cost Info</h5>
                        @if ($production->status == 0)
                        <a href="{{route('productions.costs.create', [$subdomain, $production->id])}}"
                            class="btn btn-primary float-right"><i class="fas fa-plus-circle fa-fw"></i> Add Cost</a>
                        @endif
                    </div>
                    @if ($production->costs()->exists())
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th width="5%">#</th>
                                <th width="10%">Category</th>
                                <th width="40%">Description</th>
                                <th width="15%" class="text-right">Amount</th>
                                @if ($production->status == 0)
                                <th width="10%" class="text-center">Actions</th>
                                @endif
                            </thead>
                            <tbody>
                                @foreach ($production->costs as $cost)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$cost->category->name}}</td>
                                    <td>{{$cost->description}}</td>
                                    <td class="text-right">{{Helper::money($cost->amount)}}</td>
                                    @if ($production->status == 0)
                                    <td class="text-center">
                                        <a href="{{route('productions.costs.edit',[$subdomain,$production->id, $cost->id])}}"
                                            class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit"><i
                                                class="fa fa-edit"></i></a>

                                        <a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete"
                                            onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $cost->id }}').submit(); } event.returnValue = false; return false;"><i
                                                class="fa fa-trash"></i></a>
                                        {!! Form::open(['method'=>'DELETE',
                                        'action'=>['ProductionCostController@destroy',
                                        $subdomain,$production->id, $cost->id], 'id'=>'deleteForm'.$cost->id]) !!}
                                        {!! Form::close() !!}
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right text-bold">Total</td>
                                    <td class="text-right">{{Helper::money($production->cost)}}</td>
                                    @if ($production->status == 0)
                                    <td></td>
                                    @endif

                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-footer">

                        @if($production->status==0)
                        {!! Form::open(['method'=>'POST',
                        'action'=>['ProductionController@issued', $subdomain, $production->id],
                        'id'=>'deleteForm'.$production->id,'style'=>"display:inline-block"]) !!}

                        <button type="submit" name="submit" class="btn btn-success"
                            onclick="if (confirm('Are you sure you want to Issue ?')){ loaderAddClass().submit();} event.returnValue = false; return false;">
                            Issue Now
                        </button>
                        {!! Form::close() !!}
                        @endif


                        @if ($production->status == 1)
                        <a href="{{route('productions.showCompleteForm', [$subdomain, $production->id])}}"
                            class="btn btn-primary" style="border-radius: 0px;">Finish</a>

                        {!! Form::open(['method'=>'POST',
                        'action'=>['ProductionController@cancelIssued', $subdomain, $production->id],
                        'id'=>'deleteForm'.$production->id,'style'=>"display:inline-block"]) !!}

                        <button type="submit" name="submit" class="btn btn-danger"
                            onclick="if (confirm('Are you sure you want to Back ?')){ loaderAddClass().submit();} event.returnValue = false; return false;">
                            Cancel
                        </button>
                        {!! Form::close() !!}
                        @endif

                        @if (in_array($production->status,[2,3]))
                        <a href="{{route('productions.addToInventory', [$subdomain, $production->id])}}"
                            class="btn btn-primary" style="border-radius: 0px;">Inventory</a>
                        @endif




                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->
</div>
@endsection

@push('scripts')


<script>
    $(document).ready(function () {
        $('#production_date').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'YYYY-MM-DD',
            },
        });
        });
</script>

@endpush
