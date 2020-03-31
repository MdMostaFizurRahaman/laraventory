@extends('layouts.client')

@section('title')
Show Branch
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Branch Info</h1>
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
                                    <td style="width: 80%;">{{ $branch->name }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Name</th>
                                    <td style="width: 80%;">{{ $branch->manager->name ?? null }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Mobile</th>
                                    <td style="width: 80%;"><a class="text-info"
                                            href="javascript:void(0)">{{$branch->mobile}}</a></td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Email</th>
                                    <td style="width: 80%;"><a class="text-info"
                                            href="javascript:void(0)">{{$branch->email}}</a></td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Address</th>
                                    <td style="width: 80%;">{{ $branch->address }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Branch Type</th>
                                    <td style="width: 80%;">{{ Helper::getConstantName("BRANCH_TYPES",$branch->type) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Status</th>
                                    <td style="width: 80%;">{!! Helper::branchStatusLabel($branch->status) !!}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Created By</th>
                                    <td style="width: 80%;">
                                        {{ $branch->createdBy->name ?? null }}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Updated By</th>
                                    <td style="width: 80%;">{{ $branch->updatedBy->name ?? null }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Created At</th>
                                    <td style="width: 80%;">{{ $branch->created_at->diffForHumans() }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Updated At</th>
                                    <td style="width: 80%;">{{ $branch->updated_at->diffForHumans() }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-branches']))
                        <a href="{{route('branches.index', $subdomain)}}" type="button"
                            class="btn btn-info">Back</a>
                        @endif
                    </div>
                </div><!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection
