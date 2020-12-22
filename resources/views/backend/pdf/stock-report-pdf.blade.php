<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daily invoice report</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 30px;
            line-height: 45px;
            color: #333;
            text-align: center;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td{
            border: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .rtl table {
            text-align: right;
        }

        .rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body>
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="8">
                <table>
                    <tr>
                        <td class="title" colspan="2">{{config('app.name')}}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 16px">
                            Product stock report
                        </td>
                        <td>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading">
            <td width="5%" style="text-align: left">
                SL no
            </td>

            <td width="25%" style="text-align: center">
                Product name
            </td>

            <td width="15%" style="text-align: center">
                Category name
            </td>

            <td width="15%" style="text-align: center">
                Supplier name
            </td>

            <td width="10%" style="text-align: center">
                In qty
            </td>

            <td width="10%" style="text-align: center">
                Out qty
            </td>

            <td width="10%" style="text-align: center">
                Stock
            </td>

            <td width="10%" style="text-align: center">
                Unit
            </td>
        </tr>

        @foreach($products as $key=>$product)
                @php
                    $buying_total = \App\Models\Purchase::where('category_id', $product->category_id)
                        ->where('product_id', $product->id)
                        ->where('status', 1)
                        ->sum('quantity');
                    $selling_total = \App\Models\InvoiceDetail::where('category_id', $product->category_id)
                            ->where('product_id', $product->id)
                            ->where('status', 1)
                            ->sum('selling_qty');
                @endphp
            <tr class="item">
                <td width="5%" style="text-align: left">
                    {{$key = $key+1}}
                </td>

                <td width="25%" style="text-align: center">
                    {{$product->name}}
                </td>
                <td width="15%" style="text-align: center">
                    {{$product->category->name}}
                </td>
                <td width="15%" style="text-align: center">
                    {{$product->supplier->name}}
                </td>

                <td width="10%" style="text-align: center">
                    {{$buying_total}}
                </td>

                <td width="10%" style="text-align: center">
                    {{$selling_total}}
                </td>
                <td width="10%" style="text-align: center">
                    {{$product->quantity}}
                </td>

                <td width="10%" style="text-align: center">
                    {{$product->unit->name}}
                </td>
            </tr>
        @endforeach

        @php
            $date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        @endphp
        <tr class="total">
            <td colspan="4"><i style="font-size: 9px">Printing time: {{$date->format("F j, Y, g:i a")}}</i></td>
        </tr>
    </table>
    <hr style="padding-top: 10px">
    <table>
        <tr>
            <td></td>
            <td>Owner signature</td>
        </tr>
    </table>

</div>
</body>
</html>

