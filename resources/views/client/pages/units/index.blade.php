@extends('layouts.client')

@section('title')
Units
@endsection


@section('content')

<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Units</h1>
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
                        <h5>Unit List</h5>
                    </div>

                    {!! Form::open(['method'=>'GET', 'action'=>['UnitController@index',$subdomain]]) !!}
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('name', 'Short Name') !!}
                                    {!! Form::text('name', request()->name, ['class'=>'form-control'])
                                    !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('display_name', 'Display Name') !!}
                                    {!! Form::text('display_name', request()->display_name, ['class'=>'form-control'])
                                    !!}
                                </div>
                            </div>

                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <button type="submit" class="btn btn-primary"> Filter </button>
                    </div>
                    {!! Form::close() !!}

                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th>No</th>
                                <th>Short Name</th>
                                <th>Display Name</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                @foreach ($units as $unit)
                                <tr>
                                    <td>{{$unit->id}}</td>
                                    <td>{{$unit->name}}</td>
                                    <td>{{$unit->display_name}}</td>
                                    <td>{{$unit->description}}</td>
                                    <td>{{ $unit->created_at->diffForHumans() }}</td>
                                    <td>{{ $unit->updated_at->diffForHumans() }}</td>
                                    <td>
                                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('update-units'))
                                        <a href="{{route('units.edit',[$subdomain, $unit->id])}}"
                                            class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                        @endif

                                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('delete-units'))
                                        <a href="#" class="btn btn-danger btn-sm"
                                            onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $unit->id }}').submit(); } event.returnValue = false; return false;"
                                            title="Delete"><i class="fa fa-trash"></i></a>
                                        {!! Form::open(['method'=>'DELETE', 'action'=>['UnitController@destroy',
                                        $subdomain, $unit->id], 'id'=>'deleteForm'.$unit->id]) !!}
                                        {!! Form::close() !!}
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer pb-0">
                        <ul class="pagination pagination-sm m-0 float-right">
                            Page {{ $units->currentPage() }} , showing {{ $units->count() }}
                            records out of {{ $units->total() }} total
                        </ul>
                    </div>
                    <div class="card-footer py-2">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $units->appends(request()->all())->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
