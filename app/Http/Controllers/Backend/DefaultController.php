<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class DefaultController extends Controller
{
    public function getCategory(Request $request){
        $suplier_id = $request->suplier_id;
        $suppliers = Product::with(['category'])->select('category_id')->where('suplier_id', $suplier_id)->groupBy('category_id')->get();
        return response()->json($suppliers);
    }

    public function getProduct(Request $request){
        $category_id = $request->category_id;
        $categories = Product::where('category_id', $category_id)->get();
        return response()->json($categories);
    }
}
