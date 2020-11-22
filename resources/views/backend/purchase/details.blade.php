@extends('backend.layouts.master')

@section('title')
    Purchase details
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Purchase details</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Purchase details</li>
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
                        purchases list
                        <a class="btn btn-info float-right" href="{{route('purchases.view')}}"><i class="fa fa-list"></i> Back to purchases list</a>
                    </h3>
                    @include('_errors')
                </div>
                <div class="card-body table-responsive offset-md-3 col-md-6">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>Fields</th>
                            <th>Specification</th>
                        </tr>

                        <tr>
                            <td>Purchase no</td>
                            <td>{{$purchase->purchase_no}}</td>
                        </tr>
                        <tr>
                            <td>Date</td>
                            <td>{{date('d-m-Y', strtotime($purchase->date))}}</td>
                        </tr>
                        <tr>
                            <td>Supplier name</td>
                            <td>{{$purchase->supplier->name}}</td>
                        </tr>
                        <tr>
                            <td>Category</td>
                            <td>{{$purchase->category->name}}</td>
                        </tr>
                        <tr>
                            <td>Product name</td>
                            <td>{{$purchase->product->name}}</td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>{{$purchase->description}}</td>
                        </tr>
                        <tr>
                            <td>Quantity</td>
                            <td>{{$purchase->quantity}}</td>
                        </tr>
                        <tr>
                            <td>Unit price</td>
                            <td>{{$purchase->unit_price}} {{$purchase->product->unit->name}}</td>
                        </tr>
                        <tr>
                            <td>Buying price</td>
                            <td>{{$purchase->total_price}}</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                @if($purchase->status == 0)
                                    <a class="btn btn-block btn-warning" href="{{route('purchases.approve', ['id'=>$purchase->id])}}">Approve now</a>
                                @else
                                    <a class="btn btn-block btn-success" href="">Pending now</a>
                                @endif
                            </td>
                        </tr>
                        @if($purchase->status ==0)
                        <tr>
                            <td colspan="2">
                                <form method="POST"
                                      action="{{route('purchases.delete', ['id'=>$purchase->id])}}">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-block" title="Delete now">
                                        Delete now
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
@endsection

