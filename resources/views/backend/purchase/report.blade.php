

@extends('backend.layouts.master')

@section('title')
    Daily purchase report
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Daily purchase report</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Daily purchase report</li>
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
                        Please select the criteria
                        <a class="btn btn-info float-right" href="{{route('invoice.add')}}"><i
                                class="fa fa-arrow-circle-up"></i> Add invoice</a>
                    </h3>
                    @include('_errors')
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('purchases.report.pdf')}}" target="_blank">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Starting date</label>
                                <input type="date" name="starting_date" class="form-control" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Ending date</label>
                                <input type="date" name="ending_date" class="form-control" required>
                            </div>
                        </div>
                        <button class="btn btn-success">Search</button>
                    </form>
                </div>
            </div>
@endsection

