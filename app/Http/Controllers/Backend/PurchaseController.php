<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PDF;

class PurchaseController extends Controller
{
    public function index(){
        $data['purchases']=Purchase::orderBy('date', 'desc')->orderBy('id', 'desc')->get();
        return view('backend.purchase.view', $data);
    }

    public function add(){
        $data['suppliers'] = Supplier::all();
        $data['units'] = Unit::all();
        $data['categories'] = Category::all();
        $data['date'] = date('Y-m-d');
        return view('backend.purchase.add', $data);
    }

    public function store(Request $request){
        if($request->category_id == null){
            $this->set_message('danger', 'Sorry you do not have select any category');
            return redirect()->back();
        }

        if($request->product_id == null){
            $this->set_message('danger', 'Sorry you do not have select any product');
            return redirect()->back();
        }
        $count_category = count($request->category_id);
        for ($i = 0; $i<$count_category; $i++){
            $purchase = new Purchase();
            $purchase->date = date('Y-m-d', strtotime($request->date[$i]));
            $purchase->purchase_no = strtoupper(Str::random(16).$purchase->id);
            $purchase->suplier_id = $request->suplier_id[$i];
            $purchase->category_id = $request->category_id[$i];
            $purchase->product_id = $request->product_id[$i];
            $purchase->description = $request->description[$i];
            $purchase->quantity = $request->buying_qty[$i];
            $purchase->unit_price = $request->unit_price[$i];
            $purchase->total_price = $request->buying_price[$i];
            $purchase->description = $request->description[$i];
            $purchase->status = '0';
            $purchase->create_by = auth()->user()->id;

            $purchase->save();
        }
        $this->set_message('success', 'Purchases added successfully ');
        return redirect()->route('purchases.pending.list');
    }

    public function details($id){
        $data['purchase'] = Purchase::find($id);
        return view('backend.purchase.details', $data);
    }
    public function pendingList(){
        $data['purchases']=Purchase::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', 0)->get();
        return view('backend.purchase.pendingList', $data);
    }

    public function approve($id){
        $purchase = Purchase::findOrfail($id);
        $product = Product::where('id', $purchase->product_id)->first();
        $quantity = ((float)($purchase->quantity)) + ((float)($product->quantity));
        $product->quantity = $quantity;
        if($product->save()){
            $purchase->status =1;
            $purchase->save();
        }
        $this->set_message('success', 'Purchase approved successfully');
        return redirect()->route('purchases.pending.list');
    }
    public function destroy($id){
        $purchase = Purchase::find($id);

        $purchase->delete();
        $this->set_message('success', 'Data deleted successfully ');
        return redirect()->route('purchases.view');
    }

    public function purchaseReport(){
        return view('backend.purchase.report');
    }

    public function purchaseReportPdf(Request $request){
        $start_date = date('Y-m-d', strtotime($request->input('starting_date')));
        $end_date = date('Y-m-d', strtotime($request->input('ending_date')));
        $today = date('Y-m-d');

        $tomorrow = date("Y-m-d", strtotime('+1 day', strtotime($today)));

        if($start_date > $end_date){
            $this->set_message('danger', 'Start date must not be greater than end date');
            return redirect()->back();
        }
        if($tomorrow >= $end_date){
            $data['purchases'] = Purchase::whereBetween('date', [$start_date, $end_date])
                ->where('status', 1)->get();
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $pdf = PDF::loadView('backend.pdf.purchases-report-pdf', $data);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            return $pdf->stream('document.pdf');

        }else{
            $this->set_message('danger', 'End date is not correct');
            return redirect()->back();
        }

    }
}
