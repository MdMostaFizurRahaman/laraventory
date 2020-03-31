@extends('layouts.client')

@section('title')
Add Expense
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Create Expense</h1>
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
                    {!! Form::open(['route' => ['expenses.store', $subdomain], 'method' =>'post']) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('expense_date', 'Expense Date') !!}
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        {!! Form::text('expense_date', null,
                                        ['class'=>'form-control multi-date float-right','autocomplete'=>'off'])
                                        !!}
                                    </div>
                                    @if ($errors->has('expense_date'))
                                    <div class="error text-danger">{{ $errors->first('expense_date') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {{ Form::label("Expense Amount", null) }}
                                    {{Form::text("amount", null, ["class" => "form-control",'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"])}}
                                    @if ($errors->has('amount'))
                                    <div class="error text-danger">{{ $errors->first('amount') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Account', null) !!}
                                    {!! Form::select('account_id',['' => 'Choose an option'] + $accounts, null, ['class'
                                    =>
                                    'form-control select2']) !!}
                                    @if ($errors->has('account_id'))
                                    <div class="error text-danger">{{ $errors->first('account_id') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label("Expense Description", null) }}
                                    {{Form::textarea("description", null,["class" => "form-control", 'rows' => 2])}}
                                    @if ($errors->has('description'))
                                    <div class="error text-danger">{{ $errors->first('description') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" name="action" value="save&create" class="btn btn-info"><i
                                class="fa fa-save mr-2"></i>Save & Create Another</button>
                        <button type="submit" name="action" value="save" class="btn btn-primary"><i
                                class="fa fa-save mr-2"></i>Save</button>

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-expenses']))
                        <a href="{{route('expenses.index', $subdomain)}}" type="button"
                            class="btn btn-danger">Cancel</a>
                        @endif
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
        $('#expense_date').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'YYYY-MM-DD',
            },
        });

        });
</script>

@endpush
