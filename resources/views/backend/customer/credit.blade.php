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
                    <h1 class="m-0 text-dark">Manage customer</h1>
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
                        Customers List
                        <a class="btn btn-info float-right" href="{{route('customers.credit.pdf')}}" target="_blank"><i class="fa fa-download"></i> Download pdf</a>
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
                            <th class="text-right">Due amount</th>
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
                                <td class="text-right">{{$payment->due_amount}} TK</td>
                                <td>
                                    <a class="fa fa-edit btn btn-info btn-sm" title="Edit now" href="{{route('customers.invoice.edit', ['id'=>$payment->invoice_id])}}"></a>
{{--                                    <form method="POST" action="{{route('customers.delete', ['id'=>$customer->id])}}">--}}
{{--                                        @method('DELETE')--}}
{{--                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete now"><i class="fa fa-trash"></i></button>--}}
{{--                                        @csrf--}}
{{--                                    </form>--}}

                                </td>
                            </tr>
                            @php
                                $due_total = $due_total+$payment->due_amount;
                            @endphp
                        @endforeach
                        <tr>
                            <td colspan="4" style="text-align: right"><b>Total due</b></td>
                            <td class="text-right">{{number_format($due_total, 2)}} TK</td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
@endsection

