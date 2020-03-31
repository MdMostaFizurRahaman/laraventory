@extends('layouts.client')

@section('title')
Show Branch Product
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content">
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Branch Product Info</h1>
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
                                    <th style="width: 20%;">ID</th>
                                    <td style="width: 80%;">
                                        {{ $branchProductInventory->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Branch Name</th>
                                    <td style="width: 80%;">
                                        {{ $branchProductInventory->branch ? $branchProductInventory->branch->name : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Product Name/Code/Batch</th>
                                    <td style="width: 80%;">
                                        {{ $branchProductInventory->product ? $branchProductInventory->product->name_code_batch_quantity : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Sale Price</th>
                                    <td style="width: 80%;">{{ $branchProductInventory->sale_price}}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Currency</th>
                                    <td style="width: 80%;">{{ $branchProductInventory->product->currency ? $branchProductInventory->product->currency->name : ''}}
                                </td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Stock In Hand</th>
                                    <td style="width: 80%;">{{ $branchProductInventory->quantity }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Alert Quantity</th>
                                    <td style="width: 80%;">{{ $branchProductInventory->alert_quantity }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">VAT</th>
                                    <td style="width: 80%;">{{ $branchProductInventory->vat }}%</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Category</th>
                                    <td style="width: 80%;">
                                        {{ $branchProductInventory->product ? $branchProductInventory->product->category_name : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Unit</th>
                                    <td style="width: 80%;">{{ $branchProductInventory->product->unit ? $branchProductInventory->product->unit->name : '' }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Created By</th>
                                    <td style="width: 80%;">
                                        {{ $branchProductInventory->createdBy ? $branchProductInventory->createdBy->name : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Updated By</th>
                                    <td style="width: 80%;">
                                        {{ $branchProductInventory->updatedBy ? $branchProductInventory->updatedBy->name : '' }}
                                    </td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Created At</th>
                                    <td style="width: 80%;">{{ $branchProductInventory->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Updated At</th>
                                    <td style="width: 80%;">{{ $branchProductInventory->updated_at->diffForHumans() }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        @if(Auth::user()->hasRole('admin') ||
                        Auth::user()->can(['read-branch-product-inventories']))
                        <a href="{{route('branch-product-inventories.index', $subdomain)}}" class="btn btn-danger"><i
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
