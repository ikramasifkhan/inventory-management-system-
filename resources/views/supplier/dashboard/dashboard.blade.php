@extends('supplier.master')
@section('content')
    <div class="row p-3">
        <div class="col-12 ">
            <h3>Company information</h3>
        </div>

        <div class="col-12 ">
            <table class="table table-bordered table-hover">
                <thead class="table-info">
                <th>Company name</th>
                <th>Company email</th>
                <th>Company phone number</th>
                <th>Company address</th>
                </thead>
                <tbody>
                <tr>
                    <td>{{$supplier->name}}</td>
                    <td>{{$supplier->email}}</td>
                    <td>{{$supplier->mobile}}</td>
                    <td>{{$supplier->address}}</td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>


    <div class="row p-3">
        <div class="col-12 ">
            <h3>Your history</h3>
        </div>

                <div class="col-12 ">
                    <table class="table table-bordered table-hover">
                        <thead class="table-info">
                        <th>Sl no</th>
                        <th>Date</th>
                        <th>Product name</th>
                        <th>Category name</th>
                        <th>Description</th>
                        <th>Unit price</th>
                        <th>Quantity</th>
                        <th>Total price</th>
                        </thead>
                        <tbody>
                        @php
                            $quantity = 0;
                            $total_price = 0;
                        @endphp
                        @foreach($purchases as $key=>$purchase)
                            <tr>
                                <td>{{$key = $key+1}}</td>
                                <td>{{date('d-M-Y', strtotime($purchase->date))}}</td>
                                <td>{{$purchase->product->name}}</td>
                                <td>{{$purchase->category->name}}</td>
                                <td>{{$purchase->description}}</td>
                                <td>{{$purchase->unit_price}}</td>
                                <td>{{$purchase->quantity}}</td>
                                <td>{{$purchase->total_price}}</td>
                            </tr>
                            @php
                                $quantity = $quantity + $purchase->quantity;
                                $total_price = $total_price + $purchase->total_price;
                            @endphp
                        @endforeach
                        <tr>
                            <th colspan="6" class="text-right">In total</th>
                            <th>{{$quantity}}</th>
                            <th>{{$total_price}}</th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        <div class="row p-3">
            <div class="col-12 ">
                <h3>Current stock information</h3>
            </div>

            <div class="col-12 ">
                <table class="table table-bordered table-hover">
                    <thead class="table-info">
                    <th>Sl no</th>
                    <th>Product name</th>
                    <th>Category name</th>
                    <th>Current stock</th>
                    </thead>
                    <tbody>
                    @php
                    $products = \App\Models\Product::where('suplier_id', $supplier->id)->get();
                    @endphp
                    @foreach($products as $key=>$product)
                        <tr>
                            <td>{{$key = $key+1}}</td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->category->name}}</td>
                            <td>{{$product->quantity}}</td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
