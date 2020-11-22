<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
    public function index(){
        $data['units'] = Unit::all();
        return view('backend.unit.view', $data);
    }

    public function add(){
        return view('backend.unit.add');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:64|unique:units,name',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $unit = new Unit();
        $unit->name = $request->name;
        $unit->save();

        $this->set_message('success', 'A new unit added');
        return redirect()->route('units.view');
    }

    public function edit($id){
        $data['unit'] = Unit::find($id);
        return view('backend.unit.edit', $data);
    }

    public function update($id, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => "required|max:64|unique:units,name,$id",

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $unit = Unit::findOrFail($id);
        $unit->name = $request->name;
        $unit->save();

        $this->set_message('success', 'Category updated successfully');
        return redirect()->route('units.view');
    }

    public function destroy($id){
        $unit = Unit::findOrFail($id);
        $unit->delete();
        $this->set_message('success', 'Category deleted successfully');
        return redirect()->route('units.view');
    }
}
