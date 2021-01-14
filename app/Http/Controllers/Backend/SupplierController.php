<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index(){
        $data['suppliers'] = Supplier::all()->where('status', 1);
        return view('backend.supplier.view', $data);
    }

    public function add(){
        return view('backend.supplier.add');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:124',
            'mobile' => 'required|unique:suppliers',
            'email' => 'max:124|unique:suppliers',
            'address' => 'max:255|required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $supplier = new Supplier();

        $supplier->name = $request->name;
        $supplier->mobile = $request->mobile;
        $supplier->email = $request->email;
        $supplier->address = $request->address;

        $supplier->save();

        $this->set_message('success','New supplier added');
        return redirect()->route('suppliers.view');
    }

    public function edit($id){
        $data['supplier']= Supplier::find($id);
        return view('backend.supplier.edit', $data);
    }

    public function update($id, Request $request){
        $supplier = Supplier::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:124',
            'mobile' => "required|min:11|max:14|unique:suppliers,mobile,$id",
            'email' => "max:124|unique:suppliers,email,$id",
            'address' => 'max:255|required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $supplier->name = $request->name;
        $supplier->mobile = $request->mobile;
        $supplier->email = $request->email;
        $supplier->address = $request->address;

        $supplier->save();

        $this->set_message('success','Info updated successfully');
        return redirect()->route('suppliers.view');
    }

    public function destroy($id){
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        $this->set_message('success','Info deleted successfully');
        return redirect()->route('suppliers.view');
    }

    public function supplierDashboard(){

        $supplier = Supplier::where('user_id', Auth::user()->id)->first();
        $purchases = Purchase::where('suplier_id', $supplier->id)->where('status', 1)->get();
        $products = Product::where('suplier_id', $supplier->id)->get();
        return view('supplier.dashboard.dashboard', ['supplier'=>$supplier, 'products'=>$products, 'purchases'=>$purchases]);
    }

    public function supplierPanelEdit($id){
        $data['supplier'] = Supplier::where('id', $id)->first();
        return view('supplier.dashboard.edit', $data);
    }

    public function supplierPanelUpdate($id, Request $request){
        $supplier = Supplier::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:124',
            'mobile' => "required|min:11|max:14|unique:suppliers,mobile,$id",
            'email' => "max:124|unique:suppliers,email,$id",
            'address' => 'max:255|required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $supplier->name = $request->name;
        $supplier->mobile = $request->mobile;
        $supplier->email = $request->email;
        $supplier->address = $request->address;

        $supplier->save();

        $this->set_message('success','Company info updated successfully');
        return redirect()->route('supplier.dashboard');
    }
}
