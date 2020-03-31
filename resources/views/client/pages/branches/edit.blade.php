@extends('layouts.client')

@section('title')
Edit Branch
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Update Branch</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5>Update Branch Info</h5>
                    </div>
                    {!! Form::model($branch, ['route' => ['branches.update', $subdomain, $branch->id], 'method'
                    =>'put']) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label("Branch Name", null) }}
                                    {{Form::text("name", null,["class" => "form-control"])}}
                                    @if ($errors->has('name'))
                                    <div class="error text-danger">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {{ Form::label("Mobile", null) }}
                                    {{Form::text("mobile", null,["class" => "form-control"])}}
                                    @if ($errors->has('mobile'))
                                    <div class="error text-danger">{{ $errors->first('mobile') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {{ Form::label("Email", null) }}
                                    {{Form::email("email", null,["class" => "form-control"])}}
                                    @if ($errors->has('email'))
                                    <div class="error text-danger">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {{ Form::label("Manager", null) }}
                                    {{Form::select("manager_id",['' => 'Choose an option']+$users, null,["class" => "form-control select2"])}}
                                    @if ($errors->has('manager_id'))
                                    <div class="error text-danger">{{ $errors->first('manager_id') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {{ Form::label("Branch Type", null) }}
                                    {{Form::select("type",['' => 'Choose an option']+ Config::get('constant.BRANCH_TYPES'), null, ["class" => "form-control select2"])}}
                                    @if ($errors->has('type'))
                                    <div class="error text-danger">{{ $errors->first('type') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label("Address", null) }}
                                    {{Form::textarea("address", null,["class" => "form-control",'rows' => '3'])}}
                                    @if ($errors->has('address'))
                                    <div class="error text-danger">{{ $errors->first('address') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {{ Form::label("Status", null) }}
                                    {{Form::select("status",['' => 'Choose an option'] + Config::get('constant.BRANCH_STATUSES'),null,["class" => "form-control select2"])}}
                                    @if ($errors->has('status'))
                                    <div class="error text-danger">{{ $errors->first('status') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Save</button>

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-branches']))
                        <a href="{{route('branches.index', $subdomain)}}" type="button"
                            class="btn btn-danger">Cancel</a>
                        @endif
                    </div>
                </div>
                {!! Form::close() !!}
            </div><!-- /.card -->
        </div>
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->
</div>
@endsection
