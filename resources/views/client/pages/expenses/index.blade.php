@extends('layouts.client')

@section('title')
Expenses
@endsection


@section('content')

<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Expense History</h1>
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
                        <h5>Expense List</h5>
                    </div>
                    {!! Form::open(['method'=>'GET', 'action'=>['ExpenseController@index',$subdomain]]) !!}

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('expense_start_date', 'Finish Start Date') !!}
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        {!! Form::text('expense_start_date', request()->expense_start_date,
                                        ['class'=>'form-control multi-date float-right','autocomplete'=>'off'])
                                        !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('expense_end_date', 'Expense End Date') !!}
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        {!! Form::text('expense_end_date', request()->expense_end_date,
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
                                <th>No</th>
                                <th>Expense Date</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Account</th>
                                <th>Created By</th>
                                <th>Updated By</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                {{-- <th>Actions</th> --}}
                            </thead>
                            <tbody>
                                @foreach ($expenses as $expense)
                                <tr>
                                    <td>{{$expense->id}}</td>
                                    <td>{{$expense->expenseDate}}</td>
                                    <td>{{$expense->description}}</td>
                                    <td>{{$expense->amount}}</td>
                                    <td>{{$expense->account->accountName ?? null}}</td>
                                    <td>{{$expense->createdBy->name ?? null}}</td>
                                    <td>{{$expense->updatedBy->name ?? null}}</td>
                                    <td>{{$expense->createdAt->diffForHumans()}}</td>
                                    <td>{{$expense->updatedAt->diffForHumans()}}</td>
                                    {{-- <td width="10%">
                                                <a href="{{route('expenses.edit',[$subdomain, $expense->id])}}"
                                    class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit"><i
                                        class="fa fa-edit"></i></a>

                                    <a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete"
                                        onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $expense->id }}').submit(); } event.returnValue = false; return false;"><i
                                            class="fa fa-trash"></i></a>
                                    {!! Form::open(['method'=>'DELETE', 'action'=>['ExpenseController@destroy',
                                    $subdomain, $expense->id], 'id'=>'deleteForm'.$expense->id]) !!}
                                    {!! Form::close() !!}
                                    </td> --}}
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer pb-0">
                        <ul class="pagination pagination-sm m-0 float-right">
                            Page {{ $expenses->currentPage() }} , showing {{ $expenses->count() }}
                            records out of {{ $expenses->total() }} total
                        </ul>
                    </div>
                    <div class="card-footer py-2">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $expenses->appends(request()->all())->links() }}
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
