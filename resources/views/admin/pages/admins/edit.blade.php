@extends('layouts.admin')


@section('title')
Add Client User
@endsection

@push('styles')

@endpush

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Create Admin User Info</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    {!! Form::model($admin, ['method'=>'PUT', 'route' => ['admins.update', $admin->id]]) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    {!! Form::label('role_id', 'Role') !!}
                                    {!! Form::select('role_id', [''=>'Choose an option']+$roles, null,
                                    ['class'=>'form-control select2', 'id'=>'role_id']) !!}
                                    @if ($errors->has('role_id'))
                                    <div class="error text-danger">{{ $errors->first('role_id') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('name', 'Name') !!}
                                    {!! Form::text('name', null, ['class'=>'form-control']) !!}
                                    @if ($errors->has('name'))
                                    <div class="error text-danger">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('email', 'Email') !!}
                                    {!! Form::text('email', null, ['class'=>'form-control']) !!}
                                    @if ($errors->has('email'))
                                    <div class="error text-danger">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <div class="icheck-primary">
                                        {!! Form::checkbox('status', '1', null, ['id'=>'status', 'class'=>'form-control'])
                                        !!}
                                        {!! Form::label('status', '&nbsp;Active') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="permission" style="display:{{ $display }}">
                        <div class="card-header pb-0 border-0">
                            <h3 class="card-title">
                                <span class="allpermissions">Permissions</span>

                                <div class="selectrevert icheck-primary d-inline">
                                    <input type="checkbox" id="selectAll">
                                    <label for="selectAll">Select All</label>
                                </div>
                                <div class="revert icheck-primary d-inline">
                                    <input type="checkbox" id="selectRevert">
                                    <label for="selectRevert">Select Revert</label>
                                </div>

                            </h3>
                        </div>

                        <div class="card-body">
                            @foreach($permissionGroups as $permissionGroup)
                            <div class="card-header border-0 pb-0">
                                <h3 class="card-title">
                                    <span class="permissionscategory">{{ $permissionGroup->name }}
                                    </span>
                                    <div class="selectrevertcategory icheck-primary d-inline">
                                        <input type="checkbox" id="selectCategotyAll{{ $permissionGroup->id }}"
                                            class="selectcategory">
                                        <label for="selectCategotyAll{{ $permissionGroup->id }}">Select
                                            All</label>
                                    </div>

                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="row">
                                        @foreach($permissionGroup->permissions as $permission)
                                        <div class="col-md-3">
                                            <div class="icheck-primary d-inline">
                                                {!! Form::checkbox('permissions[]', $permission->id, null
                                                ,['class'=>'check','id'=>'checkboxPermission' . $permission->id])
                                                !!}
                                                {!! Form::label('checkboxPermission' . $permission->id,
                                                $permission->display_name,['class'=>'permissionlabel',
                                                'style'=>'padding-left:5px;margin-top:10px;']) !!}
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Save</button>

                        @if(Auth::guard('admin')->user()->hasRole('admin') ||
                        Auth::guard('admin')->user()->can(['read-admins']))
                        <a href="{{route('admins.index')}}" type="button" class="btn btn-danger">Cancel</a>
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
        $('.select2').select2({
            placeholder: "Choose an option",
            theme: 'bootstrap4'
        });


        //show hide
        $('#role_id').on('change', function () {
            if (this.value == '2') {
                $(".permission").show();
            } else {
                $(".permission").hide();
            }
        });

        //select permissions
        let triggeredByChild = false;

        $('#selectAll').on('click', function (event) {
            if($(this).prop("checked") == true){
                $('.check').prop("checked", true);
                $('.selectcategory').prop("checked", true);
                $('#selectRevert').prop("checked", false);
            }else{
                $('.check').prop("checked", false);
                $('.selectcategory').prop("checked", false);
            }
        });


        $('#selectRevert').on('click', function (event) {
            if($(this).prop("checked") == true){
                $('#selectAll').prop("checked", false);
                $('.selectcategory').prop("checked", false);
                $('.check').prop("checked", false);
            }else{
                $('.check').prop("checked", true);
                $('#selectAll').prop("checked", true);
                $('.selectcategory').prop("checked", true);
            }
        });

        // Removed the checked state from "All" if any checkbox is unchecked
        $('.check').on('click', function (event) {
            if ($('.check').filter(':checked').length == $('.check').length) {
                $('#selectAll').prop("checked", true);
            }else{
                $('#selectAll').prop("checked", false);
            }
        });

        // Category wise Select
        $('.selectcategory').on('click', function (event) {
            // alert($(this).parent().parent().attr('class'));
            if($(this).prop("checked") == true){
                $(this).parent().parent().parent().next().find('.check').prop("checked", true);
            }else{
                $(this).parent().parent().parent().next().find('.check').prop("checked", false);
            }
            // calculate length
            if ($('.check').filter(':checked').length == $('.check').length) {
                $('#selectAll').prop("checked", true);
            }else{
                $('#selectAll').prop("checked", false);
            }

        });



    });

</script>
@endpush
