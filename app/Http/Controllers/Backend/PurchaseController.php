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


}
