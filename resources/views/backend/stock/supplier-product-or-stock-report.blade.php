@extends('backend.layouts.master')

@section('title')
    Stock report Stock report supplier or product wise
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Stock report supplier or product wise</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Stock report</li>
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
                        Select criteria
                    </h3>
                    @include('_errors')
                </div>
                <div class="card-body table-responsive">
                    <div class="row">
                        <div class="col-12 text-center">
                            <input type="radio" id="male" name="gender" value="supplier_wise" class="search_value">
                            <label for="male">Supplier wise search</label>
                            <input type="radio" name="gender" value="product_wise" class="search_value">
                            <label >Product wise search</label><br>
                        </div>
                        <div class="col-6 offset-3 show_supplier" style="display: none">
                            <form method="POST" action="{{route('stock.report.supplierWisePdf')}}" id="supplierWiseForm" target="_blank">
                                @csrf
                                <div class="form-group">
                                    <label>Select a supplier</label>
                                    <select class="form-control" required name="suplier_id">
                                        <option value="">Select a supplier</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button class="btn btn-info">Search</button>
                            </form>
                        </div>

                        <div class="col-6 offset-3 show_product" style="display: none">
                            <form method="POST" action="{{route('stock.report.productWisePdf')}}" id="productWiseForm" target="_blank">
                                @csrf
                                <div class="form-group">
                                    <label>Category name</label>
                                    <select name="category_id" id="category_id" class="form-control" required>
                                        <option value="">Select a category name</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Product name</label>
                                    <select name="product_id" id="product_id" class="form-control" >
                                        <option value="">Select product name</option>
                                    </select>
                                </div>
                                <button class="btn btn-info">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                $(document).on('change', '.search_value', function () {
                    let search_value = $(this).val();
                    if(search_value === 'supplier_wise'){
                        $('.show_supplier').show();
                    }else{
                        $('.show_supplier').hide();
                    }
                });

                $(document).on('change', '.search_value', function () {
                    let search_value = $(this).val();
                    if(search_value === 'product_wise'){
                        $('.show_product').show();
                    }else{
                        $('.show_product').hide();
                    }
                });
            </script>

            <script type="text/javascript">
                $(function () {
                    $(document).on('change', '#category_id', function () {
                        let category_id = $(this).val();
                        $.ajax({
                            url: "{{route('get_product')}}",
                            type: "GET",
                            data: {category_id: category_id},
                            success: function (data) {
                                let html = '<option value="">Select product</option>';
                                $.each(data, function (key, v) {
                                    html += '<option value="' + v.id + '">' + v.name + '</option>';
                                });
                                $('#product_id').html(html);
                            }
                        });
                    });
                });
            </script>
@endsection

