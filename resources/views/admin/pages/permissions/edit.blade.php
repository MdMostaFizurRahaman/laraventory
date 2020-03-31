@extends('layouts.admin')

@section('title')
Edit Permission
@endsection

@push('styles')
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{asset('theme')}}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
@endpush

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Update Permission Group Info</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    {!! Form::open(['route' => ['permissions.update', $permission->id], 'method' =>'put']) !!}
                    <div class="card-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label("Permission Name", null) }}
                                {{Form::text("name", $permission->name,["class" => "form-control","placeholder" => "Name",])}}
                                @if ($errors->has('name'))
                                <div class="error text-danger">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                {{ Form::label("Description", null) }}
                                {{Form::textarea("description",  $permission->description,["class" => "form-control",'rows' => '3'])}}
                                @if ($errors->has('description'))
                                <div class="error text-danger">{{ $errors->first('description') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="icheck-primary">
                                    {!! Form::checkbox('status', '1', $permission->status, ['id'=>'status',
                                    'class'=>'form-control']) !!}
                                    {!! Form::label('status', '&nbsp;Active') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 mt-3">
                            <div class="col-lg-12">
                                <h4 class="d-inline-block mr-5">Select Permissions</h4>
                                <div class="icheck-primary d-inline-block">
                                    <input type="checkbox" id="checkAll" />
                                    <label for="checkAll">Select All</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @foreach ($permission->clientPermissionForUpdate as $item)
                            <div class="col-md-3">
                                <div class="icheck-primary">
                                    <input type="checkbox" class="checkBoxClass" id="{{$item->id}}" name="permissions[]"
                                        {{in_array($item->id, $permission->permissions()->pluck('id')->toArray()) ? 'checked' : ''}}
                                        value="{{$item->id}}" />
                                    <label for="{{$item->id}}">{{$item->display_name}}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        @if(Auth::guard('admin')->user()->hasRole('admin') ||
                        Auth::guard('admin')->user()->can(['read-client-permissions']))
                        <a href="{{route('permissions.index')}}" type="button" class="btn btn-danger">Cancel</a>
                        @endif
                    </div>
                    {!! Form::close() !!}
                </div>
            </div><!-- /.card -->
        </div>
    </div><!-- /.container-fluid -->
</div>
@endsection


@push('scripts')
<script>
    $(document).ready(function () {
            $("#checkAll").click(function () {
                $(".checkBoxClass").prop('checked', $(this).prop('checked'));
            });

            $(".checkBoxClass").change(function(){
                if (!$(this).prop("checked")){
                    $("#checkAll").prop("checked",false);
                }
            });
        });
</script>
@endpush
