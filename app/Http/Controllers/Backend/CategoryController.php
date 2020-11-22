<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(){
        $data['categories'] = Category::all();
        return view('backend.category.view', $data);
    }

    public function add(){
        return view('backend.category.add');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:64|unique:categories,name',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $category = new Category();
        $category->name = $request->name;
        $category->save();

        $this->set_message('success', 'A new category added');
        return redirect()->route('categories.view');
    }

    public function edit($id){
        $data['category'] = Category::findOrFail($id);
        return view('backend.category.edit', $data);
    }

    public function update($id, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => "required|max:64|unique:categories,name,$id",

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();

        $this->set_message('success', 'Unit updated successfully');
        return redirect()->route('categories.view');
    }

    public function destroy($id){
        $unit = Category::findOrFail($id);
        $unit->delete();
        $this->set_message('success', 'Unit deleted successfully');
        return redirect()->route('categories.view');
    }
}
