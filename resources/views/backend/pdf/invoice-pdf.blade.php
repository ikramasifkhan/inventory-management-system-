<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>

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
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td{
            border-bottom: 1px solid #eee;
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
            <td colspan="4">
                <table>
                    <tr>
                        <td class="title" colspan="2">{{config('app.name')}}</td>
                    </tr>
                    <tr>
                        <td>
                            Invoice #: {{$invoice->invoice_no}}<br>
                            Created: {{date('D M Y', strtotime($invoice->date))}}<br>
                        </td>
                        <td>
                            {{$invoice->payment->customer->name}}<br>
                            {{$invoice->payment->customer->mobile}}<br>
                            {{$invoice->payment->customer->email}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading">
            <td width="40%" style="text-align: left">
                Item
            </td>

            <td width="20%" style="text-align: center">
                Quantity
            </td>

            <td width="20%" style="text-align: center">
                Unit price
            </td>

            <td width="20%" style="text-align: center">
                Total price
            </td>
        </tr>
        @php
        $sub_total = 0;
        @endphp
        @foreach($invoice->invoice_details as $detail)
            <tr class="item">
                <td width="40%" style="text-align: left">
                    {{$detail->product->name}}
                </td>

                <td width="15%" style="text-align: center">
                    {{$detail->selling_qty}}
                </td>
                <td width="25%" style="text-align: center">
                    {{$detail->unit_price}}
                </td>
                <td width="25%" style="text-align: center">
                    {{$detail->total_price}}
                </td>
            </tr>
            @php
            $sub_total += $detail->total_price;
            @endphp
        @endforeach
        @php
            $payment = \App\Models\Payment::where('invoice_id', $invoice->id)->first();
        @endphp
        <tr class="item">
            <td colspan="3" style="text-align: right"><strong>Total:</strong></td>

            <td style="text-align: center">
                {{number_format((float)$sub_total, 2, '.', '')}}
            </td>
        </tr>

        <tr class="item">
            <td colspan="3" style="text-align: right"><strong>Discount:</strong></td>

            <td style="text-align: center">
                {{$payment->discount_amount}}
            </td>
        </tr>

        <tr class="item">
            <td colspan="3" style="text-align: right"><strong>Grand total:</strong></td>

            <td style="text-align: center">
                {{$payment->total_amount}}
            </td>
        </tr>
        <tr class="item">
            <td colspan="3" style="text-align: right"><strong>Paid:</strong></td>

            <td style="text-align: center">
                {{$payment->paid_amount}}
            </td>
        </tr>
        <tr class="item">
            <td colspan="3" style="text-align: right"><strong>Due:</strong></td>

            <td style="text-align: center">
                {{$payment->due_amount}}
            </td>
        </tr>
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
            <td>Seller signature</td>
        </tr>
    </table>

</div>
</body>
</html>
