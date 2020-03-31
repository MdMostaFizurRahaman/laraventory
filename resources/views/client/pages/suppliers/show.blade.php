@extends('layouts.client')

@section('title')
Show Supplier
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Supplier Info</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <div class="row">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <th style="width: 20%;">Name</th>
                                    <td style="width: 80%;">{{ $supplier->name }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Company</th>
                                    <td style="width: 80%;">{{ $supplier->company }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Opening Balance</th>
                                    <td style="width: 80%;">{{ $supplier->opening_balance }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Balance</th>
                                    <td style="width: 80%;">{{ $supplier->balance }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Email</th>
                                    <td style="width: 80%;">{{ $supplier->email }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Mobile</th>
                                    <td style="width: 80%;">{{ $supplier->mobile }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Address</th>
                                    <td style="width: 80%;">{{ $supplier->address }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Created By</th>
                                    <td style="width: 80%;">
                                        {{ $supplier->createdBy->name ?? null }}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Updated By</th>
                                    <td style="width: 80%;">{{ $supplier->updatedBy->name ?? null }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Created At</th>
                                    <td style="width: 80%;">{{ $supplier->created_at->diffForHumans() }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Updated At</th>
                                    <td style="width: 80%;">{{ $supplier->updated_at->diffForHumans() }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('read-suppliers'))
                        <a href="{{route('suppliers.index', $subdomain)}}" type="button" class="btn btn-danger">Back</a>
                        @endif
                    </div>
                </div><!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection
