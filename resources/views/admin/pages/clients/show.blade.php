@extends('layouts.admin')

@section('title')
    Client Info
@endsection

@section('content')
      <!-- Content Header (Page header) -->
      <div class="content">
        <div class="content-header">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">Client Info</h1>
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
                                    <th style="width: 30%;">Name</th>
                                    <td style="width: 70%;">{{ $client->name }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 30%;">Primary Email</th>
                                    <td style="width: 70%;">{{ $client->email }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 30%;">Secondary Email</th>
                                    <td style="width: 70%;">{{ $client->secondary_email }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 30%;">Phone</th>
                                    <td style="width: 70%;">{{ $client->phone }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 30%;">Client Website</th>
                                    <td style="width: 70%;">{{ $client->client_website }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 30%;">Client URL</th>
                                    <td style="width: 70%;"><a target="_blank" href="http://{{$client->client_url.'.' . env('APP_DOMAIN_URL') }}">{{$client->client_url.'.' . env('APP_DOMAIN_URL') }}</a></td>
                                </tr>

                                <tr>
                                    <th style="width: 30%;">Contact Person Name</th>
                                    <td style="width: 70%;">{{ $client->contact_person_name }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 30%;">Contact Person Phone</th>
                                    <td style="width: 70%;">{{ $client->contact_person_phone }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 30%;">Contact Person Secondary Phone</th>
                                    <td style="width: 70%;">{{ $client->contact_person_secondary_phone }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 30%;">Contact Person Email</th>
                                    <td style="width: 70%;">{{ $client->contact_person_email }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 30%;">Address</th>
                                    <td style="width: 70%;">{{ $client->address }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 30%;">Status</th>
                                    <td style="width: 70%;">{!! Helper::activeClientStatuslabel($client->status) !!}</td>
                                </tr>

                                <tr>
                                    <th style="width: 30%;">Created At</th>
                                    <td style="width: 70%;">{{ $client->created_at->diffForHumans() }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%;">Updated At</th>
                                    <td style="width: 70%;">{{ $client->updated_at->diffForHumans() }}</td>
                                </tr>
                            </table>
                        </div>
                        {{-- <div class="row">
                            <a href="{{route('clients.edit', $client->id)}}" class="btn btn-primary mr-2"><i class="fas fa-edit fa-fw"></i> Edit</a>
                            <a href="{{route('clients.index')}}" class="btn btn-danger"><i class="fas fa-backward fa-fw"></i> Back</a>
                        </div> --}}
                    </div>
                </div><!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection
