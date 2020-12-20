@extends('backend.layouts.master')

@section('title')
    Approve invoice
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Approve invoice</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Approve invoice</li>
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
                        Invoice no #{{$invoice->invoice_no}} ({{date('d-m-Y', strtotime($invoice->date))}})
                        <a class="btn btn-info float-right" href="{{route('invoice.pending.list')}}"><i
                                class="fa fa-list"></i> Pending invoice list</a>
                    </h3>
                    @include('_errors')
                </div>
                @php
                    $payment = App\Models\Payment::where('invoice_id', $invoice->id)->first();
                @endphp
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th colspan="4" class="text-center">Customer info</th>
                        </tr>
                        <tr>
                            <td><strong>Name:</strong> {{$payment->customer->name}} </td>
                            <td><strong>Mobile:</strong> {{$payment->customer->mobile}}</td>
                            <td><strong>Email:</strong> {{$payment->customer->email}} </td>
                            <td><strong>Address:</strong> {{$payment->customer->address}}</td>
                        </tr>
                        <tr>
                            @if($invoice->description)
                                <td colspan="4"><strong>Description:</strong> {{$invoice->description}}</td>
                            @endif
                        </tr>
                    </table>
                    <br>
                    <form action="{{route('invoice.approval.store', $invoice->id)}}" method="POST">
                        @csrf
                        <table class="table table-bordered table-hover">
                            <tr class="text-center">
                                <th>Sl no</th>
                                <th>Category name</th>
                                <th>Product name</th>
                                <th class="bg-light text-center">Current stock</th>
                                <th> Quantity</th>
                                <th>Unit Price</th>
                                <th>Total price</th>
                            </tr>
                            @php
                                $sub_total = 0;
                            @endphp
                            @foreach($invoice->invoice_details as $key=>$invoice_detail)
                                <input type="hidden" name="category_id[]" value="{{$invoice_detail->category_id}}">
                                <input type="hidden" name="product_id[]" value="{{$invoice_detail->product_id}}">
                                <input type="hidden" name="selling_qty[{{$invoice_detail->id}}]" value="{{$invoice_detail->selling_qty}}">
                                <tr class="text-center">
                                    <td>{{$key = $key+1}}</td>
                                    <td>{{$invoice_detail->category->name}}</td>
                                    <td>{{$invoice_detail->product->name}}</td>
                                    <td class="bg-light text-center">{{$invoice_detail->product->quantity}}</td>
                                    <td>{{$invoice_detail->selling_qty}}</td>
                                    <td>{{$invoice_detail->unit_price}}</td>
                                    <td>{{$invoice_detail->total_price}}</td>
                                </tr>
                                @php
                                    $sub_total += $invoice_detail->total_price;
                                @endphp
                            @endforeach
                            <tr>
                                <th colspan="6" class="text-right">Sub total</th>
                                <td colspan="1" class="text-center">{{$sub_total}}</td>
                            </tr>
                            <tr>
                                <th colspan="6" class="text-right">Discount</th>
                                <td colspan="1" class="text-center">{{$payment->discount_amount}}</td>
                            </tr>
                            <tr>
                                <th colspan="6" class="text-right">Grand total</th>
                                <td colspan="1" class="text-center">{{$payment->total_amount}}</td>
                            </tr>
                            <tr>
                                <th colspan="6" class="text-right">Paid amount</th>
                                <td colspan="1" class="text-center">{{$payment->paid_amount}}</td>
                            </tr>
                            <tr>
                                <th colspan="6" class="text-right">Due</th>
                                <td colspan="1" class="text-center">{{$payment->due_amount}}</td>
                            </tr>
                        </table>
                        <button class="btn btn-success">Approve now</button>
                    </form>
                </div>
            </div>
@endsection

