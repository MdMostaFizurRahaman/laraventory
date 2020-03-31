@extends('layouts.admin')

@section('title')
Banks
@endsection


@section('content')

<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Banks</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        @include('massages.success')
        @include('massages.error')
        @include('massages.warning')
        <div class="row">

            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5>Bank List</h5>
                    </div>
                    {!! Form::open(['method'=>'GET', 'action'=>['Admin\BankController@index']]) !!}

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('name', 'Name') !!}
                                    {!! Form::text('name', request()->name, ['class'=>'form-control']) !!}
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
                                <th>No</th>
                                <th>Name</th>
                                <th>address</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                @foreach ($banks as $bank)
                                <tr>
                                    <td>{{$bank->id}}</td>
                                    <td>{{$bank->name}}</td>
                                    <td>{{$bank->address}}</td>
                                    <td>{{ $bank->created_at->diffForHumans() }}</td>
                                    <td>{{ $bank->updated_at->diffForHumans() }}</td>
                                    <td>
                                        @if(Auth::user()->hasRole('admin') ||
                                        Auth::user()->can(['update-banks']))
                                        <a href="{{route('banks.edit',$bank->id)}}" class="btn btn-sm btn-primary"><i
                                                class="fa fa-edit"></i></a>
                                        @endif

                                        @if(Auth::user()->hasRole('admin') ||
                                        Auth::user()->can(['delete-banks']))
                                        <a href="#" class="btn btn-danger btn-sm"
                                            onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $bank->id }}').submit(); } event.returnValue = false; return false;"><i
                                                class="fa fa-trash"></i></a>
                                        {!! Form::open(['method'=>'DELETE',
                                        'action'=>['Admin\BankController@destroy',$bank->id],
                                        'id'=>'deleteForm'.$bank->id]) !!}
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
                            Page {{ $banks->currentPage() }} , showing {{ $banks->count() }}
                            records out of {{ $banks->total() }} total
                        </ul>
                    </div>
                    <div class="card-footer py-2">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $banks->appends(request()->all())->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
