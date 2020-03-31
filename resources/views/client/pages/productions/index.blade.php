@extends('layouts.client')

@section('title')
Production History
@endsection


@section('content')

<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Production History</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        @include('massages.success')
        @include('massages.error')
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5>Production List</h5>
                    </div>
                    {!! Form::open(['method'=>'GET', 'action'=>['ProductionController@index',$subdomain]]) !!}

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('name', 'Name') !!}
                                    {!! Form::text('name', request()->name, ['class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('production_number', 'Production Number') !!}
                                    {!! Form::text('production_number', request()->production_number,
                                    ['class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('production_start_date', 'Production Start Date') !!}
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        {!! Form::text('production_start_date', request()->production_start_date,
                                        ['class'=>'form-control multi-date float-right','autocomplete'=>'off'])
                                        !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('production_end_date', 'Production End Date') !!}
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        {!! Form::text('production_end_date', request()->production_end_date,
                                        ['class'=>'form-control multi-date float-right','autocomplete'=>'off'])
                                        !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('finish_start_date', 'Finish Start Date') !!}
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        {!! Form::text('finish_start_date', request()->finish_start_date,
                                        ['class'=>'form-control multi-date float-right','autocomplete'=>'off'])
                                        !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('finish_end_date', 'Finish End Date') !!}
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        {!! Form::text('finish_end_date', request()->finish_end_date,
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
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th width="10%">PN#</th>
                                <th width="10%">Name</th>
                                <th width="10%">Production Date</th>
                                <th width="10%">Finish Date</th>
                                <th width="10%" class="text-right">Quantity</th>
                                <th width="10%" class="text-center">Status</th>
                                <th width="10%">Created At</th>
                                <th width="10%">Updated At</th>
                                <th width="10%">Actions</th>
                            </thead>
                            <tbody>
                                @foreach ($productions as $production)
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
                                    <td>

                                        @if(Auth::user()->hasRole('admin') ||
                                        Auth::user()->can(['update-productions']))

                                        @if($production->status <=1) <a
                                            href="{{route('productions.edit',[$subdomain, $production->id])}}"
                                            class="btn btn-sm btn-primary" data-toggle="tooltip" title="Update"><i
                                                class="fa fa-edit"></i></a>
                                            @endif

                                            @if (in_array($production->status,[0,1,2]))
                                            <a href="{{route('productions.show',[$subdomain, $production->id])}}"
                                                class="btn btn-sm btn-info" data-toggle="tooltip"
                                                title="Material & Cost"><i class="fa fa-binoculars"></i></a>
                                            @endif


                                            @endif


                                            @if (in_array($production->status,[2,3]))
                                            <a href="{{route('productions.addToInventory',[$subdomain, $production->id])}}"
                                                class="btn btn-sm btn-success" data-toggle="tooltip"
                                                title="Inventory"><i class="fa fa-eye"></i></a>
                                            @endif

                                            @if(Auth::user()->hasRole('admin') ||
                                            Auth::user()->can(['delete-productions']))
                                            @if($production->status < 1) <a href="#" class="btn btn-danger btn-sm"
                                                data-toggle="tooltip" title="Delete"
                                                onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $production->id }}').submit(); } event.returnValue = false; return false;">
                                                <i class="fa fa-trash"></i></a>
                                                {!! Form::open(['method'=>'DELETE',
                                                'action'=>['ProductionController@destroy', $subdomain, $production->id],
                                                'id'=>'deleteForm'.$production->id]) !!}
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
                            Page {{ $productions->currentPage() }} , showing {{ $productions->count() }}
                            records out of {{ $productions->total() }} total
                        </ul>
                    </div>
                    <div class="card-footer py-2">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $productions->appends(request()->all())->links() }}
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
