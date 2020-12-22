<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    public function stockReport(){
        $data['products'] = Product::orderBy('suplier_id', 'asc')->orderBy('category_id', 'asc')->get();

        return view('backend.stock.stock-report', $data);
    }

    public function stockReportPdf(){
        $data['products'] = Product::orderBy('suplier_id', 'asc')->orderBy('category_id', 'asc')->get();
        $pdf = PDF::loadView('backend.pdf.stock-report-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }

    public function stockReportSupplierOrProductWise(){
        $data['suppliers'] = Supplier::all();
        $data['categories'] = Category::all();
        return view('backend.stock.supplier-product-or-stock-report', $data);
    }

    public function stockReportSupplierWisePdf(Request $request){
        $validator = Validator::make($request->all(), [
            'suplier_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data['products'] = Product::orderBy('suplier_id', 'asc')->orderBy('category_id', 'asc')->where('suplier_id', $request->suplier_id)->get();
        $pdf = PDF::loadView('backend.pdf.supplier-stock-report-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('Supplier-report.pdf');
    }

    public function stockReportProductWisePdf(Request $request){
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data['product'] = Product::where('id', $request->product_id)->first();
        $pdf = PDF::loadView('backend.pdf.product-stock-report-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('Supplier-report.pdf');
    }
}
