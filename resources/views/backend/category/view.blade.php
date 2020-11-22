@extends('backend.layouts.master')

@section('title')
    Manage category
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Manage category</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Manage category</li>
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
                        Categories list
                        <a class="btn btn-info float-right" href="{{route('categories.add')}}"><i class="fa fa-arrow-circle-up"></i> Add category</a>
                    </h3>
                    @include('_errors')
                </div>
                <div class="card-body table-responsive">
                    <table class="table  table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Sl no</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $key =>$category)
                            <tr>
                                <td>{{$key = $key+1}}</td>
                                <td>{{$category->name}}</td>
                                <td>
                                    <div style="float: left; margin-right: 3px">
                                        <a class="fa fa-edit btn btn-info btn-sm" title="Edit now" href="{{route('categories.edit', ['id'=>$category->id])}}"></a>
                                    </div>
                                    <div style="float:left; margin-right: 3px">
                                        <form method="POST" action="{{route('categories.delete', ['id'=>$category->id])}}">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete now"><i class="fa fa-trash"></i></button>
                                            @csrf
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

