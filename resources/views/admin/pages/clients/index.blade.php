@extends('layouts.admin')


@section('title')
Clients
@endsection


@section('content')
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Clients</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        @include('massages.success')
        @include('massages.error')
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    {!! Form::open(['method'=>'GET', 'action'=>['Admin\ClientController@index']]) !!}

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
                                    {!! Form::label('email', 'Email/ Secondary Email') !!}
                                    {!! Form::text('email', request()->email, ['class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('phone', 'Phone') !!}
                                    {!! Form::text('phone', request()->phone, ['class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('url', 'Client Url') !!}
                                    {!! Form::text('url', request()->url, ['class'=>'form-control']) !!}
                                </div>
                            </div>

                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <button type="submit" class="btn btn-primary"> Filter </button>
                    </div>
                    {!! Form::close() !!}
                    <div class="card-header"><h5><i class="fas fa-list"></i> Client List</h5></div>
                    <div class="card-body">
                        <table class="table table-hover table-bordered">
                            <tr>
                                <th style="min-width:50px;">ID</th>
                                <th style="min-width:50px;">Name</th>
                                <th style="min-width:50px;">Email</th>
                                <th style="min-width:50px;">Phone</th>
                                <th style="min-width:50px;">Client Url</th>
                                <th style="min-width:50px;">Status</th>
                                <th style="min-width:50px;">Created At</th>
                                <th style="min-width:50px;">Updated At</th>
                                <th style="min-width:150px;">Actions</th>
                            </tr>

                            @foreach($clients as $client)
                            <tr>
                                <td>{{ $client->id }}</td>
                                <td>{{ $client->name }}</td>
                                <td><a href="javascript:void(0)" class="text-info">{{ $client->email }}</a></td>
                                <td>{{$client->phone}}</td>
                                <td><a target="_blank"
                                        href="http://{{$client->client_url.'.' . env('APP_DOMAIN_URL') }}">{{$client->client_url.'.' . env('APP_DOMAIN_URL') }}</a>
                                </td>
                                <td>{!! Helper::activeClientStatuslabel($client->status) !!}</td>
                                <td>{{ $client->created_at->diffForHumans() }}</td>
                                <td>{{ $client->updated_at->diffForHumans() }}</td>
                                <td>
                                    @if(Auth::guard('admin')->user()->hasRole('admin') ||
                                    Auth::guard('admin')->user()->can('read-clients'))

                                    <a href="{{route('clients.show', $client->id)}}" data-toggle="tooltip" title="View"
                                        class="btn btn-sm btn-info"><i class="fa fa-binoculars"></i></a>
                                    @endif

                                    @if(Auth::guard('admin')->user()->hasRole('admin') ||
                                    Auth::guard('admin')->user()->can('update-clients'))

                                    <a href="{{route('clients.edit', $client->id)}}" data-toggle="tooltip" title="Edit"
                                        class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    @endif

                                    @if(Auth::guard('admin')->user()->hasRole('admin') ||
                                    Auth::guard('admin')->user()->can('delete-clients'))
                                    <a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete"
                                        onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $client->id }}').submit(); } event.returnValue = false; return false;"><i
                                            class="fa fa-trash"></i></a>

                                    {!! Form::open(['method'=>'DELETE', 'action'=>['Admin\ClientController@destroy',
                                    $client->id], 'id'=>'deleteForm'.$client->id]) !!}
                                    {!! Form::close() !!}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="card-footer pb-0">
                        <ul class="pagination pagination-sm m-0 float-right">
                            Page {{ $clients->currentPage() }} , showing {{ $clients->count() }}
                            records out of {{ $clients->total() }} total
                        </ul>
                    </div>
                    <div class="card-footer py-2">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $clients->appends(request()->all())->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
