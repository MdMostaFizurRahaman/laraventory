@extends('layouts.client')

@section('title')
Accounts
@endsection


@section('content')

<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Account List</h1>
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
                        <h5>Account List</h5>
                    </div>

                    {!! Form::open(['method'=>'GET', 'action'=>['AccountController@index',$subdomain]]) !!}
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('name', 'Account Name') !!}
                                    {!! Form::text('name', request()->name, ['class'=>'form-control'])
                                    !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('account_number', 'Account Number') !!}
                                    {!! Form::text('account_number', request()->account_number,
                                    ['class'=>'form-control'])
                                    !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('mobile', 'Mobile') !!}
                                    {!! Form::text('mobile', request()->mobile, ['class'=>'form-control'])
                                    !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('branch_name', 'Branch Name') !!}
                                    {!! Form::text('branch_name', request()->branch_name, ['class'=>'form-control'])
                                    !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('branch_code', 'Branch Code') !!}
                                    {!! Form::text('branch_code', request()->branch_code, ['class'=>'form-control'])
                                    !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('bank_id', 'Bank Name') !!}
                                    {!! Form::select("bank_id",['0' => 'All'] + $banks, request()->bank_id,["class" =>
                                    "form-control select2"]) !!}
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
                                <th> Account Name</th>
                                <th>Account Number</th>
                                <th>Account Mobile</th>
                                <th>Balance</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                @foreach ($accounts as $account)
                                <tr>
                                    <td>{{$account->id}}</td>
                                    <td>{{$account->accountName}}</td>
                                    <td>{{$account->accountNumber}}</td>
                                    <td>{{$account->accountMobileNumber}}</td>
                                    <td>{{$account->balance}}</td>
                                    <td>{!! Helper::bankAccountStatusLabel($account->status) !!}</td>
                                    <td>{{$account->created_at->diffForHumans()}}</td>
                                    <td>{{$account->updated_at->diffForHumans()}}</td>
                                    <td>
                                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('read-accounts'))
                                        <a href="{{route('accounts.show', [$subdomain, $account->id])}}"
                                            class="btn btn-sm btn-info" data-toggle="tooltip" title="Show Details"><i
                                                class="fas fa-binoculars"></i></a>
                                        @endif

                                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('update-accounts'))
                                        <a href="{{route('accounts.edit', [$subdomain, $account->id])}}"
                                            class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                        @endif

                                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('delete-accounts'))
                                        <a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete"
                                            onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $account->id }}').submit(); } event.returnValue = false; return false;"><i
                                                class="fa fa-trash"></i></a>
                                        {!! Form::open(['method'=>'DELETE', 'action'=>['AccountController@destroy',
                                        $subdomain, $account->id], 'id'=>'deleteForm'.$account->id]) !!}
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
                            Page {{ $accounts->currentPage() }} , showing {{ $accounts->count() }}
                            records out of {{ $accounts->total() }} total
                        </ul>
                    </div>
                    <div class="card-footer py-2">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $accounts->appends(request()->all())->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
