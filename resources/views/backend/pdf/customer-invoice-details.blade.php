<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Customer credit report</title>

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
            <td colspan="6">
                <table>
                    <tr>
                        <td class="title" colspan="2">{{config('app.name')}}</td>
                    </tr>
                    <tr>
                        <td>
                            <b>Inovice no #</b> {{$payment->invoice->invoice_no}}
                        </td>

                        <td>
                            {{$payment->customer->name}}<br>
                            {{$payment->customer->mobile}}<br>
                            {{$payment->customer->address}}<br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading">
            <td >
                Category name
            </td>

            <td  style="text-align: center">
                Product name
            </td>

            <td  style="text-align: center">
                Quantity
            </td>

            <td style="text-align: center">
                Unit price
            </td>
            <td style="text-align: center">
                Total price
            </td>
        </tr>
        @php
            $sub_total = 0;
            $details = \App\Models\InvoiceDetail::where('invoice_id', $payment->invoice_id)->where('status',1)->get();
        @endphp
        @foreach($details as $detail)
            <tr class="item">
                <td style="text-align: left">
                    {{$detail->category->name}}
                </td>

                <td  style="text-align: center">
                    {{$detail->product->name}}
                </td>
                <td  style="text-align: center">
                    {{$detail->selling_qty}}
                </td>
                <td style="text-align: center">
                    {{$detail->unit_price}} TK
                </td>

                <td style="text-align: center">
                    {{$detail->total_price}} TK
                </td>
            </tr>
            @php
                $sub_total = $sub_total+$detail->total_price;
            @endphp
        @endforeach
        <tr class="item">
            <td colspan="4" style="text-align: right"><b>Sub total</b></td>
            <td>{{number_format($sub_total, 2)}} TK</td>
        </tr>

        <tr class="item">
            <td colspan="4" style="text-align: right"><b>Discount</b></td>
            <td>{{number_format($payment->discount_amount, 2)}} TK</td>
        </tr>

        <tr class="item">
            <td colspan="4" style="text-align: right"><b>Grand total</b></td>
            <td>{{number_format($payment->total_amount, 2)}} TK</td>
        </tr>

        <tr class="item">
            <td colspan="4" style="text-align: right"><b>Paid amount</b></td>
            <td>{{number_format($payment->paid_amount, 2)}} TK</td>
        </tr>

        <tr class="item">
            <td colspan="4" style="text-align: right"><b>Due amount</b></td>
            <td>{{number_format($payment->due_amount, 2)}} TK</td>
        </tr>

        <tr>
            <td colspan="5" style="text-align: center"><b>Payment history</b></td>
        </tr>

        <tr class="item">
            <td colspan="2" style="text-align: center">Date</td>
            <td colspan="3" style="text-align: center">Amount</td>
        </tr>
        @php
            $details = \App\Models\PaymentDetail::where('invoice_id', $payment->invoice_id)->get();
        @endphp
        @foreach($details as $detail)
        <tr class="item">
            <td colspan="2" style="text-align: center">{{date('d-M-Y', strtotime($detail->date))}}</td>
            <td colspan="3" style="text-align: center">{{number_format($detail->current_paid_amount, 2)}}</td>
        </tr>
        @endforeach

        @php
            $date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        @endphp
        <tr class="total">
            <td colspan="4"><i style="font-size: 9px">Printing time: {{$date->format("F j, Y, g:i a")}}</i></td>
        </tr>
    </table>
    <hr>
    <table>
        <tr>
            <td>Customer signature</td>
            <td>Owner signature</td>
        </tr>
    </table>

</div>
</body>
</html>


