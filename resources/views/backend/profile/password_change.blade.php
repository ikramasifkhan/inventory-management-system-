@extends('backend.layouts.master')

@section('title')
    Change password
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
                        <li class="breadcrumb-item active">Change password</li>
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
                        Change your password
                        <a class="btn btn-info float-right" href="{{route('profiles.view')}}"><i class="fa fa-backward"></i> Back to your profile</a>
                    </h3>

                </div>
                <div class="card-body">
                    @include('_errors')
                    <form role="form" id="quickForm" method="POST" action="{{route('profiles.password.change')}}">
                        @csrf

                        <div class="form-group">
                            <label for="name">Current password</label>
                            <input type="password" name="current_password" class="form-control" id="name" placeholder="Enter current password"  required>
                        </div>
                        <div class="form-group">
                            <label for="name">New password</label>
                            <input type="password" name="new_pasword" class="form-control" id="name" placeholder="Enter a new password"  required>
                        </div>
                        <div class="form-group">
                            <label for="name">Confirm new password</label>
                            <input type="password" name="new_pasword_confirmation" class="form-control" id="name" placeholder="Confirm new password"  required>
                        </div>


                        <div class="form-group">
                            <input type="submit" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
@endsection


