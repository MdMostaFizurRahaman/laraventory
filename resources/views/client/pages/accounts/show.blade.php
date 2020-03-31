@extends('layouts.client')

@section('title')
Show Account
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Account Info</h1>
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
                                    <th style="width: 20%;">Account Name</th>
                                    <td style="width: 80%;">{{ $account->accountName }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Account Number</th>
                                    <td style="width: 80%;">{{ $account->accountNumber }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Account Mobile</th>
                                    <td style="width: 80%;">{{ $account->accountMobileNumber }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Opening Balance</th>
                                    <td style="width: 80%;">{{ $account->openingBalance }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Current Balance</th>
                                    <td style="width: 80%;">{{ $account->balance }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Branch Name</th>
                                    <td style="width: 80%;">{{ $account->branchName }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Branch Code</th>
                                    <td style="width: 80%;">{{ $account->branchCode }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Bank</th>
                                    <td style="width: 80%;">{{ $account->bank ? $account->bank->name : '' }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Address</th>
                                    <td style="width: 80%;">{{ $account->address }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Status</th>
                                    <td style="width: 80%;">{!! Helper::bankAccountStatusLabel($account->status) !!}
                                    </td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Created By</th>
                                    <td style="width: 80%;">
                                        {{ $account->createdBy ? $account->createdBy->name : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Updated By</th>
                                    <td style="width: 80%;">{{ $account->updatedBy ? $account->updatedBy->name : '' }}
                                    </td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Created At</th>
                                    <td style="width: 80%;">{{ $account->createdAt->diffForHumans() }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Updated At</th>
                                    <td style="width: 80%;">{{ $account->updatedAt->diffForHumans() }}</td>
                                </tr>
                            </table>
                        </div>

                    </div>
                    <div class="card-footer">
                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('read-accounts'))
                        <a href="{{route('accounts.index', $subdomain)}}" type="button" class="btn btn-danger">Back</a>
                        @endif
                    </div>
                </div><!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection
