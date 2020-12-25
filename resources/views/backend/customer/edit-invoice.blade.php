@extends('backend.layouts.master')

@section('title')
    Credit customers
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Manage credit customer</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Credit customers</li>
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
                        Edit invoice (Invoice no # {{$payment->invoice->invoice_no}})
                        <a class="btn btn-info float-right" href="{{route('customers.credit')}}"><i class="fa fa-list"></i> Credit customer list</a>
                    </h3>
                    @include('_errors')
                </div>
                <div class="card-body table-responsive">
                    <form method="post" action="{{route('customers.invoice.update', ['id'=>$payment->invoice_id])}}">
                        @csrf
                        @method('PUT')
                        <table class="table  table-bordered table-hover">
                            <tr>
                                <td colspan="6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="pl-0 ml-0"><b>Customer name:</b> {{$payment->customer->name}}</td>
                                            <td><b>Customer mobile:</b> {{$payment->customer->mobile}}</td>
                                            <td><b>Customer email:</b> {{$payment->customer->email}}</td>
                                            <td><b>Customer address:</b> {{$payment->customer->address}}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <th>Sl no</th>
                                <th>Category</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th class="text-right">Unit price</th>
                                <th class="text-right">Total price</th>
                            </tr>
                            @php
                                $sub_total = 0;
                                $invoice_details = \App\Models\InvoiceDetail::where('invoice_id', $payment->invoice_id)->where('status', 1)->get();
                            @endphp
                            @foreach($invoice_details as $key=>$detail)
                                <tr>
                                    <td>{{$key = $key+1}}</td>
                                    <td>{{$detail->category->name}}</td>
                                    <td>{{$detail->product->name}}</td>
                                    <td>{{$detail->selling_qty}}</td>
                                    <td class="text-right">{{$detail->unit_price}} TK</td>
                                    <td class="text-right">{{$detail->total_price}} TK</td>
                                </tr>
                                @php
                                    $sub_total = $sub_total+$detail->total_price;
                                @endphp
                            @endforeach
                            <tr>
                                <td colspan="5" style="text-align: right"><b>Sub total</b></td>
                                <td class="text-right">{{number_format($sub_total, 2)}} TK</td>
                            </tr>

                            <tr>
                                <td colspan="5" style="text-align: right"><b>Discount</b></td>
                                <td class="text-right">{{number_format($payment->discount_amount, 2)}} TK</td>
                            </tr>

                            <tr>
                                <td colspan="5" style="text-align: right"><b>Grand total</b></td>
                                <td class="text-right">{{number_format($payment->total_amount, 2)}} TK</td>
                            </tr>

                            <tr>
                                <td colspan="5" style="text-align: right"><b>Paid amount</b></td>
                                <td class="text-right">{{number_format($payment->paid_amount, 2)}} TK</td>
                            </tr>

                            <tr>
                                <td colspan="5" style="text-align: right"><b>Due amount</b></td>
                                <td class="text-right">{{number_format($payment->due_amount, 2)}} TK</td>
                            </tr>
                        </table>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Paid status</label>
                                    <select name="paid_status" class="form-control" id="paid_status">
                                        <option value="">Select paid status</option>
                                        <option value="full_paid">Full paid</option>
                                        <option value="partial_paid">Partial paid</option>
                                    </select>
                                </div>

                                <div class="form-group" id="paid_amount" style="display: none">
                                    <label>Paid amount</label>
                                    <input type="number" name="paid_amount" id="" class="form-control" min="1" placeholder="Paid amount">
                                </div>
                            </div>
                            <input type="hidden" name="new_paid_amount" value="{{$payment->due_amount}}">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" name="date" class="form-control" required>
                                </div>
                            </div>
                            <button class="btn btn-info">Update invoice</button>
                        </div>
                    </form>
                </div>
            </div>
            <script type="text/javascript">
                $(document).on('change', '#paid_status', function () {
                    let paid_status = $(this).val();
                    if(paid_status==='partial_paid'){
                        $('#paid_amount').show();
                    }else{
                        $('#paid_amount').hide();
                    }
                });
            </script>
@endsection


