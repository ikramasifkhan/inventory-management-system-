@extends('backend.layouts.master')

@section('title')
    Pending purchase
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Pending purchase list</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Pending purchase</li>
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
                        <a class="btn btn-info float-right" href="{{route('purchases.add')}}"><i
                                class="fa fa-arrow-circle-up"></i> Add purchase</a>
                    </h3>
                    @include('_errors')
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Sl no</th>
                            <th>Product name</th>
                            <th>Quantity</th>
                            <th>Unit price</th>
                            <th>Total price</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($purchases as $key =>$purchase)
                            <tr>
                                <td>{{$key = $key+1}}</td>
                                <td>{{$purchase->product->name}}</td>
                                <td>
                                    {{$purchase->quantity}}
                                    {{$purchase->product->unit->name}}
                                </td>
                                <td>{{$purchase->unit_price}}</td>
                                <td>{{$purchase->total_price}}</td>
                                <td>
                                    <a class="btn btn-warning btn-xs" href="{{route('purchases.approve', ['id'=>$purchase->id])}}" title="Approve now"><i class="fa fa-check-circle text-white"></i></a>
                                    <a class="btn btn-info btn-xs fa fa-eye" title="View details"href="{{route('purchases.details', ['id'=>$purchase->id])}}"></a>
                                </td>

{{--                                <td>--}}
{{--                                    <div class="float-left mr-1">--}}
{{--                                        <a class="btn btn-info btn-xs fa fa-eye" title="View details"--}}
{{--                                           href="{{route('purchases.details', ['id'=>$purchase->id])}}"></a>--}}
{{--                                    </div>--}}
{{--                                    @if($purchase->status ==0)--}}
{{--                                        <div class="float-left mr-1">--}}
{{--                                            <form method="POST"--}}
{{--                                                  action="{{route('purchases.delete', ['id'=>$purchase->id])}}">--}}
{{--                                                @method('DELETE')--}}
{{--                                                @csrf--}}
{{--                                                <button type="submit" class="btn btn-danger btn-xs" title="Delete now">--}}
{{--                                                    <i class="fa fa-trash"></i></button>--}}
{{--                                            </form>--}}
{{--                                        </div>--}}
{{--                                    @endif--}}
{{--                                </td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
@endsection
