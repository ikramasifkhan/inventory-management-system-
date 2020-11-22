@extends('backend.layouts.master')

@section('title')
    Add purchase
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Add a new purchase</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Add purchase</li>
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
                        Add purchase
                        <a class="btn btn-info float-right" href="{{route('products.view')}}"><i class="fa fa-list"></i>
                            purchases list</a>
                    </h3>

                </div>
                <div class="card-body">
                    @include('_errors')
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" name="date" class="form-control" id="date" placeholder="Enter date"
                               value="{{old('date')}}" required>
                    </div>

                    <div class="form-group">
                        <label>Supplier name</label>
                        <select name="suplier_id" id="suplier_id" class="form-control" required>
                            <option value="">Select your supplier name</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Category name</label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            <option value="">Select a supplier to choose a category name</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Product name</label>
                        <select name="product_id" id="product_id" class="form-control" required>
                            <option value="">Select product name</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-info btn-block addeventmore">Add item</button>
                    </div>
                </div>
            </div>
            <div class="col-12 card">
                <div class="card-header">
                    <h3 class="text-center text-info">Show your purchases info</h3>
                </div>

                <div class="card-body table-responsive">
                    <form action="{{route('purchases.store')}}" method="POST" id="myForm">
                        @csrf
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Category</th>
                                <th>Product name</th>
                                <th>PICS/KG</th>
                                <th>Unit price</th>
                                <th>Description</th>
                                <th>Total price</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="addRow" class="addRow"></tbody>
                            <tbody>
                                <tr>
                                    <td colspan="5"></td>
                                    <td colspan="2">
                                        <input type="text" name="estimated_amount" value="0" id="estimated_amount" class="form-control text-right estimated_amount" readonly>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-info">Purchase store</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script id="document-template" type="text/x-handlebars-template">
        <tr class="delete_add_more_item" id="delete_add_more_item">
            <input type="hidden" name="date[]" value="@{{ date }}">
            <input type="hidden" name="suplier_id[]" value="@{{ suplier_id }}">
            <td>
                <input type="hidden" name="category_id[]" value="@{{ category_id }}">
                @{{ category_name }}
            </td>
            <td>
                <input type="hidden" name="product_id[]" value="@{{ product_id }}">
                @{{ product_name }}
            </td>

            <td>
                <input type="number" min="1" value="1" class="form-control text-right buying_qty" name="buying_qty[]">
            </td>

            <td>
                <input type="number" min="1" value="" class="form-control text-right unit_price" name="unit_price[]">
            </td>

            <td>
                <input type="text"  class="form-control " name="description[]">
            </td>

            <td>
                <input type="text"  class="form-control text-right buying_price" name="buying_price[]" value="0" readonly>
            </td>

            <td>
                <button class="btn btn-danger btn-sm removeeventmore" title="Delete now"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on("click", ".addeventmore", function () {
                let date = $('#date').val();
                let purchase_no = $('#purchase_no').val();
                let suplier_id = $('#suplier_id').val();
                let category_id = $('#category_id').val();
                let category_name = $('#category_id').find('option:selected').text();
                let product_id = $('#product_id').val();
                let product_name = $('#product_id').find('option:selected').text();

                let source = $("#document-template").html();
                let template = Handlebars.compile(source);

                let data ={
                    date:date,
                    suplier_id:suplier_id,
                    category_id:category_id,
                    category_name:category_name,
                    product_id:product_id,
                    product_name:product_name,
                };

                let html = template(data);
                $('#addRow').append(html);
            });

            $(document).on("click", ".removeeventmore", function (event) {
                $(this).closest(".delete_add_more_item").remove();
                totalAmountPrice();
            })

            $(document).on("keyup click", ".unit_price, .buying_qty", function () {
                let unit_pirce = $(this).closest("tr").find("input.unit_price").val();
                let qty = $(this).closest("tr").find("input.buying_qty").val();
                let total = unit_pirce*qty;
                $(this).closest("tr").find("input.buying_price").val(total);

                totalAmountPrice();
            });
            function totalAmountPrice() {
                let sum =0;
                $(".buying_price").each(function () {
                    let value =  $(this).val();
                    if(!isNaN(value)&& value.length !=0){
                        sum += parseFloat(value);
                    }
                });

                $('#estimated_amount').val(sum);
            }
        });
    </script>

    <script type="text/javascript">
        $(function () {
            $(document).on('change', '#suplier_id', function () {
                let suplier_id = $(this).val();
                $.ajax({
                    url: "{{route('get_category')}}",
                    type: "GET",
                    data: {suplier_id: suplier_id},
                    success: function (data) {
                        let html = '<option value="">Select category</option>';
                        $.each(data, function (key, v) {
                            html += '<option value="' + v.category_id + '">' + v.category.name + '</option>';
                        });
                        $('#category_id').html(html);
                    }
                });
            });
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



