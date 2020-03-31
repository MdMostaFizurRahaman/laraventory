@extends('layouts.admin')


@section('title')
Client Users
@endsection


@section('content')
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Client User List</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        @include('massages.success')
        @include('massages.error')
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    {!! Form::open(['method'=>'GET', 'action'=>['Admin\ClientUserController@index']]) !!}

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
                                    {!! Form::label('email', 'Email') !!}
                                    {!! Form::text('email', request()->email, ['class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('client_id', 'Client') !!}
                                    {!! Form::select('client_id', ['0'=>'All']+$clients,
                                    request()->client_id,
                                    ['class'=>'form-control select2', 'id'=>'client_id']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">

                                    {!! Form::label('role_id', 'Role') !!}
                                    {!! Form::select('role_id', ['0'=>'All']+$roles, request()->role_id,
                                    ['class'=>'form-control select2', 'id'=>'role_id']) !!}
                                </div>
                            </div>

                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <button type="submit" class="btn btn-primary"> Filter </button>
                    </div>
                    {!! Form::close() !!}

                    <div class="card-body">
                        <table class="table table-hover table-bordered">
                            <tr>
                                <th>ID</th>
                                <th>User Name</th>
                                <th>Client Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </tr>

                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->client ? $user->client->name : '' }}</td>
                                <td><a class="text-info" href="javascript:void(0)">{{$user->email}}</a></td>
                                <td>{{ $user->role ? $user->role->name : '' }}</td>
                                <td>{!! Helper::activeInactiveStatus($user->status) !!}</td>
                                <td>{{ $user->created_at->diffForHumans() }}</td>
                                <td>{{ $user->updated_at->diffForHumans() }}</td>
                                <td>
                                    @if(Auth::guard('admin')->user()->hasRole('admin') ||
                                    Auth::guard('admin')->user()->can('update-client-users'))
                                    <a class="btn btn-primary btn-sm" href="{{route('client-users.edit', $user->id)}}"
                                        data-toggle="tooltip" title="Edit"> <i class="fas fa-edit"></i></a>

                                    <a class="btn btn-info btn-sm"
                                        href="{{route('client-users.change.password', $user->id)}}"
                                        data-toggle="tooltip" title="Change Password"> <i class="fas fa-lock"></i></a>
                                    @endif

                                    @if(Auth::guard('admin')->user()->hasRole('admin') ||
                                    Auth::guard('admin')->user()->can('delete-client-users'))
                                    <a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete"
                                        onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $user->id }}').submit(); } event.returnValue = false; return false;"><i
                                            class="fa fa-trash"></i></a>

                                    {!! Form::open(['method'=>'DELETE', 'action'=>['Admin\ClientUserController@destroy',
                                    $user->id], 'id'=>'deleteForm'.$user->id]) !!}
                                    {!! Form::close() !!}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>

                    <div class="card-footer pb-0">
                        <ul class="pagination pagination-sm m-0 float-right">
                            Page {{ $users->currentPage() }} , showing {{ $users->count() }}
                            records out of {{ $users->total() }} total
                        </ul>
                    </div>
                    <div class="card-footer py-2">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $users->appends(request()->all())->links() }}
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
        $('.select2').select2({
            placeholder: "Choose an option",
            theme: 'bootstrap4'
        });
        $("#client_id").on("change", function (e) {
            $('#role_id')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="">Loading</option>');
            $('#role_id').trigger('change');

            if ($('#client_id').val() == '') {
                $('#role_id')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">Choose an option</option>');
                $('#role_id').trigger('change');
            }
            else {
                $.ajax({
                    type: "POST",
                    data: {"_token": "{{ csrf_token() }}", client_id: $('#client_id').val()},
                    url: "{{ route('client.roles') }}",
                    success: function (data) {
                        $('#role_id')
                                .find('option')
                                .remove()
                                .end()
                                .append(data);
                        $('#role_id').trigger('change');
                    }
                });
            }
        });

        //end
    });
</script>
@endpush
