@extends('backend.layouts.master')

@section('title')
    Manage products
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Manage products</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Manage products</li>
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
                        Product list
                        <a class="btn btn-info float-right" href="{{route('products.add')}}"><i
                                class="fa fa-arrow-circle-up"></i> Add product</a>
                    </h3>
                    @include('_errors')
                </div>
                <div class="card-body table-responsive">
                    <table class="table  table-bordered table-hover">
                        <tr>
                            <th>Sl no</th>
                            <th>Product name</th>
                            <th>Category name</th>
                            <th>Product current price</th>
                            <th>Unit</th>
                            <th>Supplier name</th>
                            <th>Action</th>
                        </tr>
                        @foreach($products as $key =>$product)
                            <tr>
                                <td>{{$key = $key+1}}</td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->category->name}}</td>
                                <td>{{$product->price}}</td>
                                <td>{{$product->unit->name}}</td>
                                <td>{{$product->supplier->name}}</td>
                                <td>
                                    <div class="float-left mr-1">
                                        <a class="fa fa-edit btn btn-info btn-sm" title="Edit now"
                                           href="{{route('products.edit', ['id'=>$product->id])}}"></a>
                                    </div>
                                    <div class="float-left mr-1">
                                        <form method="POST" action="{{route('products.delete', ['id'=>$product->id])}}">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete now"><i
                                                    class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
@endsection
