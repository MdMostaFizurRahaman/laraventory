@extends('layouts.admin')


@section('title')
Admin Users
@endsection


@section('content')
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Admin User List</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        @include('massages.success')
        @include('massages.error')
        @include('massages.warning')
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    {!! Form::open(['method'=>'GET', 'action'=>['Admin\AdminController@index']]) !!}

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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </tr>

                            @foreach($admins as $admin)
                            <tr>
                                <td>{{ $admin->id }}</td>
                                <td>{{ $admin->name }}</td>
                                <td><a class="text-info" href="javascript:void(0)">{{$admin->email}}</a></td>
                                <td>{{ $admin->role ? $admin->role->name : '' }}</td>
                                <td>{!! Helper::activeInactiveStatus($admin->status) !!}</td>
                                <td>{{ $admin->created_at->diffForHumans() }}</td>
                                <td>{{ $admin->updated_at->diffForHumans() }}</td>
                                <td>
                                    @if(Auth::guard('admin')->user()->hasRole('admin') ||
                                    Auth::guard('admin')->user()->can('update-admins'))
                                    <a class="btn btn-primary btn-sm" href="{{route('admins.edit', $admin->id)}}"
                                        data-toggle="tooltip" title="Edit"> <i class="fas fa-edit"></i></a>

                                    <a class="btn btn-info btn-sm"
                                        href="{{ route('admins.change.password', $admin->id) }}"
                                        data-toggle="tooltip" title="Change Password"> <i class="fas fa-lock"></i></a>
                                    @endif

                                    @if(Auth::guard('admin')->user()->hasRole('admin') ||
                                    Auth::guard('admin')->user()->can('delete-admins'))
                                    <a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete"
                                        onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $admin->id }}').submit(); } event.returnValue = false; return false;"><i
                                            class="fa fa-trash"></i></a>

                                    {!! Form::open(['method'=>'DELETE', 'action'=>['Admin\AdminController@destroy',
                                    $admin->id], 'id'=>'deleteForm'.$admin->id]) !!}
                                    {!! Form::close() !!}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>

                    <div class="card-footer pb-0">
                        <ul class="pagination pagination-sm m-0 float-right">
                            Page {{ $admins->currentPage() }} , showing {{ $admins->count() }}
                            records out of {{ $admins->total() }} total
                        </ul>
                    </div>
                    <div class="card-footer py-2">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $admins->appends(request()->all())->links() }}
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
