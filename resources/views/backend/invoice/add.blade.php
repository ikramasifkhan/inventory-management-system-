@extends('backend.layouts.master')

@section('title')
    Add invoice
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Create a new invoice</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Create invoice</li>
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
                        Create purchase
                        <a class="btn btn-info float-right" href="{{route('invoice.view')}}"><i class="fa fa-list"></i>
                            Invoices list</a>
                    </h3>

                </div>
                <div class="card-body">
                    @include('_errors')
                    <div class="form-group">
                        <label>Invoice no</label>
                        <input type="Text" name="invoice_no" class="form-control" id="invoice_no" value="{{$invoice_no}}" readonly>
                    </div>

                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" name="date" class="form-control" id="date" placeholder="Enter date"
                               value="{{$date}}" readonly required>
                    </div>

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
                        <select name="product_id" id="product_id" class="form-control" required>
                            <option value="">Select product name</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Stock (KJ/PICS)</label>
                        <input type="text" name="current_stock" id="current_stock" readonly class="form-control">
                    </div>

                    <div class="form-group">
                        <button class="btn btn-info btn-block addeventmore">Add item</button>
                    </div>
                </div>
            </div>
            <div class="col-12 card">
                <div class="card-header">
                    <h3 class="text-center text-info">Invoice info</h3>
                </div>

                <div class="card-body table-responsive">
                    <form action="{{route('invoice.store')}}" method="POST" id="myForm">
                        @csrf
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Category</th>
                                <th>Product name</th>
                                <th>PICS/KG</th>
                                <th>Unit price</th>
                                <th>Total price</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="addRow" class="addRow"></tbody>
                            <tbody>
                            <tr>
                                <th colspan="4" class="text-right">Discount</th>
                                <td colspan="2">
                                    <input type="number" min="0" name="discount_amount" placeholder="Enter discount amount" id="discount_amount" class="form-control text-right">
                                </td>
                            </tr>

                            <tr>
                                <th colspan="4" class="text-right">Grand total</th>
                                <td colspan="2">
                                    <input type="text" name="estimated_amount" value="0" id="estimated_amount" class="form-control text-right estimated_amount" readonly>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <div class="form-group">
                            <textarea type="text" name="description"  class="form-control" placeholder="Description"></textarea>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Paid status</label>
                                    <select name="paid_status" class="form-control" id="paid_status">
                                        <option value="">Select paid status</option>
                                        <option value="full_paid">Full paid</option>
                                        <option value="full_due">Full due</option>
                                        <option value="partial_paid">Partial paid</option>
                                    </select>
                                </div>

                                <div class="form-group" id="paid_amount" style="display: none">
                                    <label>Paid amount</label>
                                    <input type="number" name="paid_amount" id="" class="form-control" min="1" placeholder="Paid amount">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Customer name</label>
                                    <select name="customer_id" class="form-control" id="customer_id">
                                        <option value="">Select customer name</option>
                                        <option value="0">New customer</option>
                                        @foreach($customers as $customer)
                                        <option value="{{$customer->id}}">{{$customer->name}} ({{$customer->mobile}} - {{$customer->address}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12" id="new_customer" style="display: none">
                                <h4 class="text-info text-center">New customer register form</h4>
                                <div class="form-group">
                                    <label>Customer name</label>
                                    <input type="Text" name="name" class="form-control" id="name" placeholder="Customer name">
                                </div>

                                <div class="form-group">
                                    <label>Mobile number</label>
                                    <input type="Text" name="mobile" class="form-control" id="mobile" placeholder="Mobile number">
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Customer email">
                                </div>

                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="Text" name="address" class="form-control" id="address" placeholder="Customer address">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-info">Invoice store</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script id="document-template" type="text/x-handlebars-template">
        <tr class="delete_add_more_item" id="delete_add_more_item">
            <input type="hidden" name="date" value="@{{ date }}">
            <input type="hidden" name="invoice_no" value="@{{ invoice_no }}">
            <td>
                <input type="hidden" name="category_id[]" value="@{{ category_id }}">
                @{{ category_name }}
            </td>
            <td>
                <input type="hidden" name="product_id[]" value="@{{ product_id }}">
                @{{ product_name }}
            </td>

            <td>
                <input type="number" min="1"  value="1" class="form-control text-right selling_qty" name="selling_qty[]">
            </td>

            <td>
                <input type="number" min="1" class="form-control text-right unit_price" name="unit_price[]" value="@{{ 1 }}">
            </td>

            <td>
                <input type="text"  class="form-control text-right total_price" name="total_price[]" value="0" readonly>
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
                let invoice_no = $('#invoice_no').val();
                let category_id = $('#category_id').val();
                let category_name = $('#category_id').find('option:selected').text();
                let product_id = $('#product_id').val();
                let product_name = $('#product_id').find('option:selected').text();

                let source = $("#document-template").html();
                let template = Handlebars.compile(source);

                let data ={
                    date:date,
                    invoice_no:invoice_no,
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

            $(document).on("keyup click", ".unit_price, .selling_qty", function () {
                let unit_pirce = $(this).closest("tr").find("input.unit_price").val();
                let qty = $(this).closest("tr").find("input.selling_qty").val();
                let total = unit_pirce*qty;
                $(this).closest("tr").find("input.total_price").val(total);

                $('#discount_amount').trigger('keyup');
            });

            $(document).on('keyup', '#discount_amount', function () {
                totalAmountPrice();
            });
            function totalAmountPrice() {
                let sum =0;
                $(".total_price").each(function () {
                    let value =  $(this).val();
                    if(!isNaN(value)&& value.length !=0){
                        sum += parseFloat(value);
                    }
                });

                let discount_amount = parseFloat($('#discount_amount').val());
                if(!isNaN(discount_amount) && discount_amount.length !=0){
                    sum -= discount_amount
                }

                $('#estimated_amount').val(sum);
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

    <script type="text/javascript">
        $(function () {
            $(document).on('change', '#product_id', function () {
                let product_id = $(this).val();
                $.ajax({
                    url:"{{route('check_product_stock')}}",
                    type: 'get',
                    data:{product_id:product_id},
                    success:function (data) {
                        $('#current_stock').val(data);
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(function () {
            $(document).on('change', '#product_id', function () {
                let product_id = $(this).val();
                $.ajax({
                    url:"{{route('check_product_price')}}",
                    type: 'get',
                    data:{product_id:product_id},
                    success:function (data) {
                        $('#price').val(data);
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(document).on('change', '#paid_status', function () {
            let paid_status = $(this).val();
            if(paid_status == 'partial_paid'){
                $('#paid_amount').show()
            }else{
                $('#paid_amount').hide()
            }
        });

        $(document).on('change', '#customer_id', function () {
            let customer_id = $(this).val();

            if(customer_id == 0){
               $('#new_customer').show();
            }else {
                $('#new_customer').hide();
            }
        });
    </script>


@endsection
