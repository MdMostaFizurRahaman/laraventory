@extends('layouts.client')

@section('title')
Material Categories
@endsection


@section('content')

<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-md-12">
                <h1 class="m-0 text-dark">Material Categories</h1>
                @if(Auth::user()->hasRole('admin') || Auth::user()->can('create-material-categories'))
                <a href="{{route('material-categories.create', $subdomain)}}" type="submit" class="btn btn-primary float-right">Add New Category</a>
                @endif
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        @include('massages.success')
        @include('massages.error')
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    {!! Form::open(['method'=>'GET', 'action'=>['MaterialCategoryController@index',$subdomain]]) !!}

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('name', 'Name') !!}
                                    {!! Form::text('name', request()->name, ['class'=>'form-control']) !!}
                                </div>
                            </div>

                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <button type="submit" class="btn btn-primary"> Filter </button>
                    </div>
                    {!! Form::close() !!}

                    <div class="card-body p-0">
                        <table class="table">
                            <thead>
                                <th style="min-width:50px;">ID.</th>
                                <th style="min-width:50px;">Name</th>
                                <th style="min-width:100px;">Description</th>
                                <th style="min-width:50px;">Created At</th>
                                <th style="min-width:50px;">Updated At</th>
                                <th style="min-width: 100px">Actions</th>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                <tr>
                                    <td>{{$category->id}}</td>
                                    <td>{{$category->name}}</td>
                                    <td>{{$category->description}}</td>
                                    <td>{{ $category->created_at->diffForHumans() }}</td>
                                    <td>{{ $category->updated_at->diffForHumans() }}</td>
                                    <td>
                                        @if(Auth::user()->hasRole('admin') ||
                                        Auth::user()->can('update-material-categories'))
                                        <a href="{{route('material-categories.edit', [$subdomain, $category->id])}}"
                                            class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                        @endif

                                        @if(Auth::user()->hasRole('admin') ||
                                        Auth::user()->can('delete-material-categories'))
                                        <a href="#" class="btn btn-danger btn-sm"
                                            onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $category->id }}').submit(); } event.returnValue = false; return false;"
                                            title="Delete"><i class="fa fa-trash"></i></a>
                                        {!! Form::open(['method'=>'DELETE',
                                        'action'=>['MaterialCategoryController@destroy',$subdomain, $category->id],
                                        'id'=>'deleteForm'.$category->id]) !!}
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
                            Page {{ $categories->currentPage() }} , showing {{ $categories->count() }}
                            records out of {{ $categories->total() }} total
                        </ul>
                    </div>
                    <div class="card-footer py-2">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $categories->appends(request()->all())->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
