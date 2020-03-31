@extends('layouts.client')

@section('title')
Show User
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">User Info</h1>
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
                                    <th style="width: 20%;">ID.</th>
                                    <td style="width: 80%;">{{ $user->id }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Name</th>
                                    <td style="width: 80%;">{{ $user->name }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Mobile</th>
                                    <td style="width: 80%;">{{ $user->mobile }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Address</th>
                                    <td style="width: 80%;">{{ $user->address }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Client</th>
                                    <td style="width: 80%;">{{ $user->client ? $user->client->name : '' }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Role</th>
                                    <td style="width: 80%;">{{ $user->role ? $user->role->display_name : '' }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Image</th>
                                    <td style="width: 80%;">
                                        <img style="height: 100px;"
                                             src="{{ asset(Helper::storagePath($user->image)) }}">
                                    </td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Created At</th>
                                    <td style="width: 80%;">{{ $user->created_at->diffForHumans() }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Updated At</th>
                                    <td style="width: 80%;">{{ $user->updated_at->diffForHumans() }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        @if(Auth::user()->hasRole('admin') || Auth::user()->can(['read-users']))
                        <a href="{{route('users.index', $subdomain)}}" type="button" class="btn btn-primary">Back</a>
                        @endif
                    </div>
                </div><!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection
