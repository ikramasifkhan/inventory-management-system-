<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(){
        $data['products'] = Product::all();
        return view('backend.product.view', $data);
    }

    public function add(){
        $data['suppliers'] = Supplier::select('id', 'name')->where('status', 1)->get();
        $data['categories'] = Category::select('id', 'name')->where('status', 1)->get();
        $data['units'] = Unit::select('id', 'name')->where('status', 1)->get();
        return view('backend.product.add', $data);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'suplier_id'=>'numeric|required',
            'unit_id'=>'numeric|required',
            'category_id'=>'numeric|required',
            'name' => 'required|max:64|unique:products,name',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $product = new Product();
        $product->suplier_id = $request->suplier_id;
        $product->unit_id = $request->unit_id;
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->quantity = '0';
        $product->create_by = auth()->user()->id;
        $product->save();

        $this->set_message('success', 'Product added successfully');
        return redirect()->route('products.view');
    }

    public function edit($id){
        $data['product'] = Product::find($id);
        $data['suppliers'] = Supplier::select('id', 'name')->where('status', 1)->get();
        $data['categories'] = Category::select('id', 'name')->where('status', 1)->get();
        $data['units'] = Unit::select('id', 'name')->where('status', 1)->get();
        return view('backend.product.edit', $data);
    }

    public function update($id, Request $request){
        $validator = Validator::make($request->all(), [
            'suplier_id'=>'numeric|required',
            'unit_id'=>'numeric|required',
            'category_id'=>'numeric|required',
            'name' => "required|max:64|unique:products,name,$id",

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $product = Product::findOrFail($id);
        $product->suplier_id = $request->suplier_id;
        $product->unit_id = $request->unit_id;
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->quantity = '0';
        $product->updated_by = auth()->user()->id;
        $product->save();

        $this->set_message('success', 'Product updated successfully');
        return redirect()->route('products.view');
    }

    public function destroy($id){
        $product = Product::findOrFail($id);
        $product->delete();

        $this->set_message('success', 'Product deleted successfully');
        return redirect()->route('products.view');
    }
}
