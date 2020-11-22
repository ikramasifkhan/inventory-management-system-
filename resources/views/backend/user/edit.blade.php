@extends('backend.layouts.master')

@section('title')
    Edit user
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0 text-dark">Edit user </h3>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Add user</li>
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
                        Edit {{$user->name}}
                        <a class="btn btn-info float-right" href="{{route('users.view')}}"><i class="fa fa-list"></i>
                            User list</a>
                    </h3>

                </div>
                <div class="card-body">
                    @include('_errors')
                    <form role="form" id="quickForm" method="POST" action="{{route('users.update', $user->id)}}">
                        @csrf
                        <div class="form-group">
                            <label for="user_role">User role</label>
                            <select class="form-control" name="role" id="user_role" required>
                                <option value="">Select a role</option>
                                <option value="user" {{$user->role == 'user'?'selected':''}}>User</option>
                                <option value="admin" {{$user->role == 'admin'?'selected':''}}>Admin</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter name" value="{{$user->name}}" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" value="{{$user->email}}" required>
                        </div>

                        <div class="form-group">
                            <input type="Submit" class="btn btn-primary" value="Update">
                        </div>
                    </form>
                </div>
            </div>
@endsection


