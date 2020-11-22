@extends('backend.layouts.master')

@section('title')
    Edit products
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit product</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Edit product</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="container-fluid">
        <div class="row">
            <div class="card col-12">
                <div class="card-header">
                    <h3 class="text-info">
                        Edit product
                        <a class="btn btn-info float-right" href="{{route('products.view')}}"><i class="fa fa-list"></i>
                            Product list</a>
                    </h3>

                </div>
                <div class="card-body">
                    @include('_errors')
                    <form role="form" id="quickForm" method="POST" action="{{route('products.update', ['id'=>$product->id])}}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Supplier name</label>
                            <select name="suplier_id" id="cars" class="form-control" required>
                                <option value="">Select your supplier name</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{$supplier->id}}" {{($product->suplier_id == $supplier->id)? 'selected':''}}>{{$supplier->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name">Unit name</label>
                            <select name="unit_id" id="cars" class="form-control" required>
                                <option value="">Select unit</option>
                                @foreach($units as $unit)
                                    <option value="{{$unit->id}}" {{($product->unit_id == $unit->id)?'selected':''}}>{{$unit->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name">Supplier name</label>
                            <select name="category_id" id="cars" class="form-control" required>
                                <option value="">Select category name</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{($product->category_id == $category->id)?'selected':''}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter name" value="{{$product->name}}" required>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
@endsection


