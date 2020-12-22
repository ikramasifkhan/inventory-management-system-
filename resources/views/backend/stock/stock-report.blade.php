@extends('backend.layouts.master')

@section('title')
    Stock report
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Stock report</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Stock report</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="card col-12">
                <div class="card-header">
                    <h3 class="text-info">
                        Stock list
                        <a class="btn btn-info float-right" href="{{route('stock.report.pdf')}}" target="_blank"><i
                                class="fa fa-download"></i> Download this report</a>
                    </h3>
                    @include('_errors')
                </div>
                <div class="card-body table-responsive">
                    <table class="table  table-bordered table-hover">
                        <tr>
                            <th>Sl no</th>
                            <th>Product name</th>
                            <th>Category name</th>
                            <th>Supplier name</th>
                            <th>In quantity</th>
                            <th>Out quantity</th>
                            <th>Stock</th>
                            <th>Unit</th>
                        </tr>
                        @foreach($products as $key =>$product)
                            @php
                                $buying_total = \App\Models\Purchase::where('category_id', $product->category_id)
                                    ->where('product_id', $product->id)
                                    ->where('status', 1)
                                    ->sum('quantity');
                                $selling_total = \App\Models\InvoiceDetail::where('category_id', $product->category_id)
                                        ->where('product_id', $product->id)
                                        ->where('status', 1)
                                        ->sum('selling_qty');
                            @endphp
                            <tr>
                                <td>{{$key = $key+1}}</td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->category->name}}</td>
                                <td>{{$product->supplier->name}}</td>
                                <td>{{$buying_total}}</td>
                                <td>{{$selling_total}}</td>
                                <td>{{$product->quantity}}</td>
                                <td>{{$product->unit->name}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
@endsection
