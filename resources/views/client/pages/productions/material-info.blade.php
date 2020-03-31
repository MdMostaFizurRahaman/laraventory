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
                                <a href="{{route('productions.materials.edit',[$subdomain,$production->id, $material->id])}}"
                                    class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit"><i
                                        class="fa fa-edit"></i></a>

                                <a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete"
                                    onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $material->id }}').submit(); } event.returnValue = false; return false;"><i
                                        class="fa fa-trash"></i></a>
                                {!! Form::open(['method'=>'DELETE', 'action'=>['ProductionController@removeMaterial',
                                $subdomain,$production->id, $material->id], 'id'=>'deleteForm'.$material->id]) !!}
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
