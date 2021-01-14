@extends('supplier.master')
@section('content')
    <div class="row p-3">
        <div class="col-12">
            @include('_errors');
            <h3>Update your company info</h3>
            <hr>
        </div>
        <div class="col-12 ">
            <form action="{{route('supplier.panel.update', ['id'=>$supplier->id])}}" method="POST">
                @csrf
                <div class="form-group row">
                    <label class="col-2">Company name</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="name" value="{{$supplier->name}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2">Company contact number</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="mobile" value="{{$supplier->mobile}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2">Company email address</label>
                    <div class="col-10">
                        <input type="email" class="form-control" name="email" value="{{$supplier->email}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2">Company address</label>
                    <div class="col-10">
                        <textarea class="form-control" name="address">{{$supplier->address}}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Update now</button>
            </form>
        </div>

    </div>
@endsection

