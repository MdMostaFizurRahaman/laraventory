@extends('layouts.client')

@section('title')
Add Material
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Create Material</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        {{-- @include('massages.errors') --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card-header">
                    <h5>Create Material Info</h5>
                </div>
                <div class="card card-primary card-outline">
                    {!! Form::open(['route' => ['materials.store', $subdomain], 'method' =>'post']) !!}
                    <div class="card-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label("Material Name", null) }}
                                {{Form::text("name", null,["class" => "form-control"])}}
                                @if ($errors->has('name'))
                                <div class="error text-danger">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                {{ Form::label("Description", null) }}
                                {{Form::textarea("description", null,["class" => "form-control",'rows' => '2'])}}
                                @if ($errors->has('description'))
                                <div class="error text-danger">{{ $errors->first('description') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                {{ Form::label('opening_stock',"Opening Stock") }}
                                {{Form::text("opening_stock", 0,["class" => "form-control",'oninput'=>"this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"])}}
                                @if ($errors->has('opening_stock'))
                                <div class="error text-danger">{{ $errors->first('opening_stock') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                {{ Form::label('alert_quantity',"Alert Quantity") }}
                                {{Form::text("alert_quantity", 0,["class" => "form-control",'oninput'=>"this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"])}}
                                @if ($errors->has('alert_quantity'))
                                <div class="error text-danger">{{ $errors->first('alert_quantity') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                {!! Form::label('category_id', 'Category') !!}
                                {!! Form::select('category_id',['' => 'Choose an option'] + $categories, null, ['class'
                                =>
                                'form-control select2']) !!}
                                @if ($errors->has('category_id'))
                                <div class="error text-danger">{{ $errors->first('category_id') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                {!! Form::label('unit_id', 'Unit') !!}
                                {!! Form::select('unit_id',['' => 'Choose an option'] + $units, null, ['class' =>
                                'form-control select2']) !!}
                                @if ($errors->has('unit_id'))
                                <div class="error text-danger">{{ $errors->first('unit_id') }}</div>
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>
                            Save</button>

                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-materials']))
                        <a href="{{route('materials.index', $subdomain)}}" type="button"
                            class="btn btn-danger">Cancel</a>
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
            // $('.select2').select2({
            //     theme: 'bootstrap4'
            // });
        });
</script>

@endpush
