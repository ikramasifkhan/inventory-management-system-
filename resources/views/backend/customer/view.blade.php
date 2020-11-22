@extends('backend.layouts.master')

@section('title')
    Manage customer
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
                        <li class="breadcrumb-item active">Manage customer</li>
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
                        <a class="btn btn-info float-right" href="{{route('customers.add')}}"><i class="fa fa-arrow-circle-up"></i> Add customer</a>
                    </h3>
                    @include('_errors')
                </div>
                <div class="card-body table-responsive">
                    <table class="table  table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Sl no</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Edit</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customers as $key =>$customer)
                            <tr>
                                <td>{{$key = $key+1}}</td>
                                <td>{{$customer->name}}</td>
                                <td>{{$customer->mobile}}</td>
                                <td>{{$customer->email}}</td>
                                <td>{{$customer->address}}</td>
                                <td>
                                    <a class="fa fa-edit btn btn-info btn-sm" title="Edit now" href="{{route('customers.edit', ['id'=>$customer->id])}}"></a>
                                    <form method="POST" action="{{route('customers.delete', ['id'=>$customer->id])}}">
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete now"><i class="fa fa-trash"></i></button>
                                        @csrf
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
@endsection

