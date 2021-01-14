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

        $today = date('Y-m-d');

        $tomorrow = date("Y-m-d", strtotime('+1 day', strtotime($today)));

        if($starting_date > $ending_date){
            $this->set_message('danger', 'Start date must not be greater than end date');
            return redirect()->back();
        }
        if($tomorrow >= $ending_date){
            $data['invoices'] = Invoice::whereBetween('date', [$starting_date, $ending_date])->where('status', 1)->get();
            $data['starting_date'] = $starting_date;
            $data['ending_date']= $ending_date;

            $pdf = PDF::loadView('backend.pdf.daily-invoice-pdf', $data);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            return $pdf->stream('document.pdf');
        }else{
            $this->set_message('danger', 'End date is not correct');
            return redirect()->back();
        }

    }
}
