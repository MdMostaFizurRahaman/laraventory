@extends('layouts.client')

@section('title')
Materials
@endsection


@section('content')

<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Materials</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        @include('massages.success')
        {{-- @include('massages.error') --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5>Material List</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th>No</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Opening Stock</th>
                                <th>RQA</th>
                                <th>Stock</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th style="min-width:100px">Actions</th>
                            </thead>
                            <tbody>
                                @foreach ($materials as $material)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$material->name}}</td>
                                    <td>{{$material->description}}</td>
                                    <td>{{$material->opening_stock}}</td>
                                    <td>{{$material->alertQuantity}}</td>
                                    <td>{{$material->quantity}}</td>
                                    <td>{{ $material->created_at->diffForHumans() }}</td>
                                    <td>{{ $material->updated_at->diffForHumans() }}</td>
                                    <td>
                                        @if(Auth::user()->hasRole('admin') ||
                                        Auth::user()->can(['update-materials']))
                                        <a href="{{route('materials.edit',[$subdomain, $material->id])}}"
                                            class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                        @endif

                                        @if(Auth::user()->hasRole('admin') ||
                                        Auth::user()->can(['delete-materials']))
                                        <a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete"
                                            onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $material->id }}').submit(); } event.returnValue = false; return false;"><i
                                                class="fa fa-trash"></i></a>
                                        {!! Form::open(['method'=>'DELETE', 'action'=>['MaterialController@destroy',
                                        $subdomain, $material->id], 'id'=>'deleteForm'.$material->id]) !!}
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
                            Page {{ $materials->currentPage() }} , showing {{ $materials->count() }}
                            records out of {{ $materials->total() }} total
                        </ul>
                    </div>
                    <div class="card-footer py-2">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $materials->appends(request()->all())->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
