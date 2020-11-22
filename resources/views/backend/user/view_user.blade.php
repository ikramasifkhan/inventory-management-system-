@extends('backend.layouts.master')

@section('title')
    Manage user
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Manage user</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Manage user</li>
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
                        USERS LIST
                        <a class="btn btn-info float-right" href="{{route('users.add')}}"><i class="fa fa-arrow-circle-up"></i> Add user</a>
                    </h3>
                    @include('_errors')
                </div>
                <div class="card-body table-responsive">
                    <table class="table  table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Sl no</th>
                            <th>Role</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $key=> $user)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td class="text-capitalize">{{$user->role}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    <a class="fa fa-edit btn btn-info btn-sm" title="Edit now" href="{{route('users.edit', ['id'=>$user->id])}}"></a>
                                    <a class="btn btn-danger btn-sm" title="Delete now" href="{{route('users.delete', ['id'=>$user->id])}}"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
@endsection

