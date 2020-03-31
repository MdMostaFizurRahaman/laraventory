@extends('layouts.client')

@section('title')
Edit Production
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-md-6">
                <h3 class="m-0 text-dark">Production Info </h3>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-info card-outline">
                    {{-- <div class="card-header"> --}}
                    {{-- <h5>Production Info</h5> --}}
                    {{-- </div> --}}
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th width="10%">PN#</th>
                                <th width="10%">Name</th>
                                <th width="10%">Production Date</th>
                                <th width="10%">Finish Date</th>
                                <th width="10%" class="text-right">Quantity</th>
                                <th width="10%" class="text-center">Status</th>
                                <th width="10%">Created At</th>
                                <th width="10%">Updated At</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$production->productionNumber}}</td>
                                    <td>{{$production->name}}</td>
                                    <td>{{$production->productionDate}}</td>
                                    <td>{{$production->finishDate}}</td>
                                    <td class="text-right">
                                        @if ($production->finishDate)
                                        {{ Helper::money($production->quantity)}}
                                        @endif
                                    </td>
                                    <td class="text-center">{!! Helper::productionStatusLabel($production->status) !!}
                                    </td>
                                    <td>{{$production->createdAt->diffForHumans()}}</td>
                                    <td>{{$production->updatedAt->diffForHumans()}}</td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @include('massages.success')
        @include('massages.errors')
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    {!! Form::model($production, ['route' => ['productions.complete', $subdomain, $production->id],
                    'method' =>'PATCH']) !!}
                    <div class="card-body">

                        <div class="form-group">
                            {!! Form::label('finish_date', 'Finish Date') !!}
                            <div class="input-group date">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                {!! Form::text('finish_date', null, ['class'=>'form-control float-right'])
                                !!}
                            </div>
                            @if ($errors->has('finish_date'))
                            <div class="error text-danger">{{ $errors->first('finish_date') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label("quantity","Quantity") }}
                            {{Form::text("quantity", null,["class" => "form-control",'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"])}}
                            @if ($errors->has('quantity'))
                            <div class="error text-danger">{{ $errors->first('quantity') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            {!! Form::label('Note', null) !!}
                            {{Form::textarea("note", null,["class" => "form-control", 'rows' => 3])}}
                            @if ($errors->has('note'))
                            <div class="error text-danger">{{ $errors->first('note') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"
                            onclick="if (confirm('Are you sure you want to Finish ?')){ loaderAddClass().submit();} event.returnValue = false; return false;"><i
                                class="fa fa-save mr-2"></i>Finish</button>
                        <a href="{{route('productions.show', [$subdomain, $production->id])}}" type="button"
                            class="btn btn-danger"><i class="fas fa-backward mr-2"></i>Back</a>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5>Material List</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th width="5%">#</th>
                                <th width="30%">Material Name</th>
                                <th width="10%">Quantity</th>
                                <th width="10%">Rate</th>
                                <th width="20%" class="text-right">Amount</th>
                                @if ($production->status == 0)
                                <th width="10%" class="text-center">Actions</th>
                                @endif
                            </thead>
                            <tbody>
                                @foreach ($production->productionMaterials as $material)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$material->material->name}}</td>
                                    <td>{{$material->quantity}}</td>
                                    <td>{{$material->rate}}</td>
                                    <td class="text-right">{{Helper::money($material->total)}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right">Total</td>
                                    <td class="text-right">
                                        {{Helper::money($production->productionMaterials->sum('total'))}}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- /.card -->


    </div>
</div>
</div><!-- /.container-fluid -->
</div>
@endsection

@push('scripts')


<script>
    $(document).ready(function () {
        $('#finish_date').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'YYYY-MM-DD',
            },
        });
        });
</script>

@endpush
