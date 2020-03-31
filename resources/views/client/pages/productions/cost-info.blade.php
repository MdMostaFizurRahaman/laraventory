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
                                {!! Form::open(['method'=>'DELETE', 'action'=>['ProductionCostController@destroy',
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
