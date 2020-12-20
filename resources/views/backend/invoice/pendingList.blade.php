@extends('backend.layouts.master')

@section('title')
    Pending invoice
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Pending invoice</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Pending invoice</li>
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
                        Invoices list
                        <a class="btn btn-info float-right" href="{{route('invoice.add')}}"><i
                                class="fa fa-arrow-circle-up"></i> Add invoice</a>
                    </h3>
                    @include('_errors')
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Sl no</th>
                            <th>Customer name</th>
                            <th>Invoice no</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Total amount</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoices as $key =>$invoice)
                            <tr>
                                <td>{{$key = $key+1}}</td>
                                <td>{{$invoice->payment->customer->name}} ({{$invoice->payment->customer->mobile}})</td>
                                <td>Invoice no# {{$invoice->invoice_no}}</td>
                                <td>{{date('d-m-Y', strtotime($invoice->date))}}</td>
                                <td>{{$invoice->description}}</td>
                                <td>{{$invoice->payment->total_amount}}</td>
                                <td>
                                    <div class="float-left mr-1">
                                        @if($invoice->status == 0)
                                            <a class="btn btn-warning btn-xs" href="{{route('invoice.approve', $invoice->id)}}" title="Approve now"><i class="fa fa-check-circle text-white"></i></a>
                                        @endif
                                    </div>
                                    <div class="float-left">
                                        <form action="{{route('invoice.delete', $invoice->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-xs"><i class="fa fa-trash text-white"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
@endsection

