<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use PDF;
class PrintInvoiceController extends Controller
{
    public function index(){
        $data['invoices'] = Invoice::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', 1)->get();
        return view('backend.invoice.pos-invoice-list', $data);
    }

    function printInvoice($id) {
        $data['invoice'] = Invoice::with(['invoice_details'])->find($id);
        $pdf = PDF::loadView('backend.pdf.invoice-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }

    public function dailyReport(){
        return view('backend.invoice.daily-invoice-report');
    }

    public function dailyReportPdf(Request $request){
        $starting_date =  date('Y-m-d', strtotime($request->input('starting_date')));
        $ending_date=  date('Y-m-d', strtotime($request->input('ending_date')));

        $data['invoices'] = Invoice::whereBetween('date', [$starting_date, $ending_date])->where('status', 1)->get();
        $data['starting_date'] = $starting_date;
        $data['ending_date']= $ending_date;

        $pdf = PDF::loadView('backend.pdf.daily-invoice-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }
}
