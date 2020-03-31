@extends('layouts.client')

@section('title')
    Edit Expense
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content">
        <div class="content-header">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">Update Expense Info</h1>
              </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
        <div class="container-fluid">
            @include('massages.success')
            @include('massages.error')
        <div class="row">
            <div class="col-lg-12">
            <div class="card card-primary card-outline">
                {!! Form::model($expense, ['route' => ['expenses.update', $subdomain, $expense->id], 'method' =>'put']) !!}
                    <div class="card-body">
                        <div class="form-group">
                            {{ Form::label("Expense Date", null) }}
                            {{Form::date("expense_date", null,["class" => "form-control"])}}
                        @if ($errors->has('expense_date'))
                            <div class="error text-danger">{{ $errors->first('expense_date') }}</div>
                        @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label("Expense Description", null) }}
                            {{Form::textarea("description", null,["class" => "form-control", 'rows' => 2])}}
                        @if ($errors->has('description'))
                            <div class="error text-danger">{{ $errors->first('description') }}</div>
                        @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label("Expense Amount", null) }}
                            {{Form::number("amount", null,["class" => "form-control"])}}
                        @if ($errors->has('amount'))
                            <div class="error text-danger">{{ $errors->first('amount') }}</div>
                        @endif
                        </div>
                        <div class="form-group">
                            {!! Form::label('Account', null) !!}
                            {!! Form::select('account_id',['' => 'Choose an option'] + $accounts, null, ['class' => 'form-control select2']) !!}
                        @if ($errors->has('account_id'))
                            <div class="error text-danger">{{ $errors->first('account_id') }}</div>
                        @endif
                        </div>
                        <div class="form-group">
                            <button type="submit"  class="btn btn-primary"><i class="fa fa-save mr-2"></i>Save</button>
                            <a href="{{route('expenses.index', $subdomain)}}" type="button" class="btn btn-danger">Cancel</a>
                        </div>
                      </div>
                {!! Form::close() !!}
            </div><!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@push('scripts')


    <script>
        $(document).ready(function () {
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        });
    </script>

@endpush
