@extends('backend.layouts.master')

@section('title')
    Manage supplier
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Manage supplier</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Manage supplier</li>
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
                        Supplier list
                        <a class="btn btn-info float-right" href="{{route('suppliers.add')}}"><i
                                class="fa fa-arrow-circle-up"></i> Add supplier</a>
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
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($suppliers as $key =>$supplier)
                            <tr>
                                <td>{{$key = $key+1}}</td>
                                <td>{{$supplier->name}}</td>
                                <td>{{$supplier->mobile}}</td>
                                <td>{{$supplier->email}}</td>
                                <td>{{$supplier->address}}</td>
                                <td>
                                    <div class="float-left mr-2">
                                        <a class="fa fa-edit btn btn-info btn-sm" title="Edit now"
                                           href="{{route('suppliers.edit', ['id'=>$supplier->id])}}"></a>
                                    </div>
                                    @php
                                        $count_suplier = \App\Models\Product::where('suplier_id', $supplier->id)->count();
                                    @endphp
                                    @if($count_suplier<=0)
                                        <div class="float-left mr-2">
                                            <form method="POST"
                                                  action="{{route('suppliers.delete', ['id'=>$supplier->id])}}">
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete now"><i
                                                        class="fa fa-trash"></i></button>
                                                @csrf
                                            </form>
                                        </div>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
