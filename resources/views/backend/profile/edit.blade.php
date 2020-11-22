@extends('backend.layouts.master')

@section('title')
    Edit profile
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Edit profile</li>
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
                        Edit your profile
                        <a class="btn btn-info float-right" href="{{route('profiles.view')}}"><i class="fa fa-backward"></i> Back to your profile</a>
                    </h3>

                </div>
                <div class="card-body">
                    @include('_errors')
                    <form role="form" id="quickForm" method="POST" action="{{route('profiles.update')}}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter name" value="{{$user->name}}" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" value="{{$user->email}}" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Contact number</label>
                            <input type="text" name="mobile" class="form-control" id="exampleInputEmail1" placeholder="Your mobile number" value="{{$user->mobile}}" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Address</label>
                            <input type="text" name="address" class="form-control" id="exampleInputEmail1" placeholder="Your address" value="{{$user->address}}" required>
                        </div>

                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select class="form-control" name="gender" id="gender" required>
                                <option value="">Select a gender</option>
                                <option value="male" {{$user->gender =='male'?'selected':''}}>Male</option>
                                <option value="female" {{$user->gender =='female'?'selected':''}}>Female</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <img src="{{(!empty($user->image))?url('public/uploads/user_image/'.$user->image):url('public/uploads/no_image.jpg')}}" id="show_image" width="150px" height="150px">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Update your profile photo</label>
                            <input type="file" name="image" id="image" class="form-control" id="exampleInputEmail1" accept="image/*">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
@endsection


