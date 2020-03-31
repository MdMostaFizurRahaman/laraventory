@extends('layouts.client')

@section('title')
Add Production
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class="m-0 text-dark">Add Material to Production #{{$production->productionNumber}}</h3>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <div class="container-fluid">
        @include('massages.success')
        {{-- @include('massages.errors') --}}
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    {!! Form::open(['route' => ['productions.materials.store', $subdomain, $production->id], 'method'
                    =>'post']) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    {!! Form::label('Select Batch', null) !!}
                                    {!! Form::select('purchase_material_id',['' => 'Choose an option'] +
                                    $purchaseMaterials, null, ['class'=>'form-control select2']) !!}
                                    @if ($errors->has('purchase_material_id'))
                                    <div class="error text-danger">{{ $errors->first('purchase_material_id') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {!! Form::label('quantity','Quantity') !!}
                                    {!! Form::text('quantity', null, ['class' => 'form-control
                                    quantity','oninput'=>"this.value = this.value.replace(/[^0-9.]/g,
                                    '').replace(/(\..*)\./g, '$1');"]) !!}
                                    @if ($errors->has('quantity'))
                                    <div class="error text-danger">{{ $errors->first('quantity') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {{ Form::label("Note", null) }}
                                    {{Form::textarea("note", null,["class" => "form-control", 'rows' => 3])}}
                                    @if ($errors->has('note'))
                                    <div class="error text-danger">{{ $errors->first('note') }}</div>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><i
                                            class="fa fa-save mr-2"></i>Save</button>
                                    <a href="{{route('productions.show', [$subdomain, $production->id])}}" type="button"
                                        class="btn btn-danger">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div><!-- /.card -->
            </div>
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5>Production Info</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="30%">PN</th>
                                    <td>{{$production->productionNumber}}</td>
                                </tr>

                                <tr>
                                    <th width="30%">Production Date</th>
                                    <td>{{$production->productionDate}}</td>
                                </tr>

                                <tr>
                                    <th width="30%">Note</th>
                                    <td>{{$production->note}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection


@push('scripts')
<script>
    $(document).ready(function () {
            $('.total').val($('.quantity').val() * $('.rate').val());

            $(".quantity,.rate").keyup(function () {
                $('.total').val($('.quantity').val() * $('.rate').val());
            });
        });
</script>
@endpush
