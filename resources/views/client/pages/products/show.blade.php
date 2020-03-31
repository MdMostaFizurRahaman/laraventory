@extends('layouts.client')

@section('title')
Show Product
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Product Info</h1>
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
                                    <th style="width: 20%;">Name</th>
                                    <td style="width: 80%;">{{ $product->name }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Code</th>
                                    <td style="width: 80%;">{{ $product->code }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Batch Quantity</th>
                                    <td style="width: 80%;">{{ $product->batch_quantity }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Sale Price</th>
                                    <td style="width: 80%;">{{ $product->sale_price}}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Currency</th>
                                    <td style="width: 80%;">{{ $product->currency ? $product->currency->name : ''}}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Description</th>
                                    <td style="width: 80%;">{{ $product->description }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Stock In Hand</th>
                                    <td style="width: 80%;">{{ $product->quantity }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Opening Quantity</th>
                                    <td style="width: 80%;">{{ $product->opening_quantity }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Alert Quantity</th>
                                    <td style="width: 80%;">{{ $product->alert_quantity }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">VAT</th>
                                    <td style="width: 80%;">{{ $product->vat }}%</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Category</th>
                                    <td style="width: 80%;">{{ $product->category ? $product->category->name : ''}}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Unit</th>
                                    <td style="width: 80%;">{{ $product->unit ? $product->unit->name : '' }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Product Image</th>
                                    <td style="width: 80%;">
                                        <div class="product-img">
                                                <img class="img-size-50"
                                             src="{{ asset(Helper::storagePath($product->image)) }}">
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Created By</th>
                                    <td style="width: 80%;">
                                        {{ $product->createdBy ? $product->createdBy->name : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Updated By</th>
                                    <td style="width: 80%;">{{ $product->updatedBy ? $product->updatedBy->name : '' }}
                                    </td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Created At</th>
                                    <td style="width: 80%;">{{ $product->created_at->diffForHumans() }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Updated At</th>
                                    <td style="width: 80%;">{{ $product->updated_at->diffForHumans() }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-products']))
                        <a href="{{route('products.index', $subdomain)}}" class="btn btn-danger"><i
                                class="fas fa-backward fa-fw"></i> Back</a>
                        @endif
                    </div>
                </div><!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection
