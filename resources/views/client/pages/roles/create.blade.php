@extends('layouts.client')

@section('title')
Add Role
@endsection

@push('styles')

@endpush

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Create Role</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        {!! Form::open(['route' => ['roles.store', $subdomain], 'method' =>'post']) !!}
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header with-border">
                        <h3 class="card-title">Create Role Info</h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label("display_name", 'Display Name') }}
                                {{Form::text("display_name", null,["class" => "form-control","placeholder" => "Display Name",])}}
                                @if ($errors->has('display_name'))
                                <div class="error text-danger">{{ $errors->first('display_name') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                {{ Form::label("description", 'Description') }}
                                {{Form::textarea("description", null,["class" => "form-control",'rows' => '3'])}}
                                @if ($errors->has('description'))
                                <div class="error text-danger">{{ $errors->first('description') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="permission" style="">
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
                            @if ($errors->has('permissions'))
                            <div class="error text-danger">{{ $errors->first('permissions') }}</div>
                            @endif

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

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-roles']))
                        <a href="{{route('roles.index', $subdomain)}}" type="button" class="btn btn-danger">Cancel</a>
                        @endif
                    </div>

                </div>
            </div><!-- /.card -->
        </div>
        {!! Form::close() !!}
    </div><!-- /.container-fluid -->
</div>
@endsection


@push('scripts')
<script>
    $(document).ready(function () {

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
