@extends('backend.layouts.master')

@section('title')
    view profile
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Manage your profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Manage profile</li>
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
                        Profile
                        <a class="btn btn-info float-right" href="{{route('profiles.edit')}}"><i class="fa fa-backward"></i> Edit your profile</a>
                    </h3>
                    @include('_errors')
                </div>
                <div class="row">
                    <div class="col-md-6 offset-md-3">

                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                         src="{{(!empty($user->image))?url('public/uploads/user_image/'.$user->image):url('public/uploads/no_image.jpg')}}"
                                         alt="User profile picture" style="width: 125px">
                                </div>

                                <h3 class="profile-username text-center">{{$user->name}}</h3>
                                <p class="text-muted text-center">{{$user->address}}</p>
                                <table class="table table-bordered table-hover text-center mb-3">
                                    <tr>
                                        <td>Email</td>
                                        <td>{{$user->email}}</td>
                                    </tr>
                                    <tr>
                                        <td>Mobile</td>
                                        <td>{{$user->mobile}}</td>
                                    </tr>
                                    <tr>
                                        <td>Basic info</td>
                                        <td class="text-capitalize">{{$user->gender}}</td>
                                    </tr>
                                </table>
                                <a href="{{route('profiles.edit')}}" class="btn btn-primary btn-block"><b>Edit your profile</b></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
@endsection
