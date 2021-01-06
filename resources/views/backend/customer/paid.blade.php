@extends('backend.layouts.master')

@section('title')
    Padi customers
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Paid customer</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Paid customers</li>
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
                        Paid customers List
                        <a class="btn btn-info float-right" href="{{route('customers.paid.pdf')}}" target="_blank"><i class="fa fa-download"></i> Download pdf</a>
                    </h3>
                    @include('_errors')
                </div>
                <div class="card-body table-responsive">
                    <table class="table  table-bordered table-hover">
                        <tr>
                            <th>Sl no</th>
                            <th>Name</th>
                            <th>Invoice no</th>
                            <th>Date</th>
                            <th class="text-right">Paid amount</th>
                            <th>Action</th>
                        </tr>
                        @php
                            $due_total = 0;
                        @endphp
                        @foreach($payments as $key=>$payment)
                            <tr>
                                <td>{{$key = $key+1}}</td>
                                <td>{{$payment->customer->name}} ({{$payment->customer->mobile}})</td>
                                <td>Invoice no# {{$payment->invoice->invoice_no}}</td>
                                <td>{{date('d -M -Y', strtotime($payment->invoice->invoice_no))}}</td>
                                <td class="text-right">{{$payment->paid_amount}} TK</td>
                                <td>
                                    <a class="fa fa-eye btn btn-info btn-sm" title="View details" href="{{route('customers.invoice.details.pdf', ['id'=>$payment->invoice_id])}}" target="_blank"></a>
                                </td>
                            </tr>
                            @php
                                $due_total = $due_total+$payment->paid_amount;
                            @endphp
                        @endforeach
                        <tr>
                            <td colspan="4" style="text-align: right"><b>Total paid</b></td>
                            <td class="text-right">{{number_format($due_total, 2)}} TK</td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
@endsection


