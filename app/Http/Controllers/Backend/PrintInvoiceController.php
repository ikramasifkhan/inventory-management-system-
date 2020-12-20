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
}
