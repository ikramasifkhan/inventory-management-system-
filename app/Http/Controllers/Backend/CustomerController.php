<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index(){
        $data['customers'] = Customer::all();
        return view('backend.customer.view', $data);
    }

    public function add(){
        return view('backend.customer.add');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:124',
            'mobile' => 'required|min:11|max:13|unique:customers',
            'email' => 'max:124|unique:customers',
            'address' => 'max:255|required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $customer = new Customer();

        $customer->name = $request->name;
        $customer->mobile = $request->mobile;
        $customer->email = $request->email;
        $customer->address = $request->address;

        $customer->save();

        $this->set_message('success','New customer added');
        return redirect()->route('customers.view');
    }

    public function edit($id){
        $data['customer']= Customer::findOrFail($id);
        return view('backend.customer.edit', $data);
    }

    public function update($id, Request $request){
        $customer = Customer::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:124',
            'mobile' => "required|min:11|max:14|unique:customers,mobile,$id",
            'email' => "max:124|unique:customers,email,$id",
            'address' => 'max:255|required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $customer->name = $request->name;
        $customer->mobile = $request->mobile;
        $customer->email = $request->email;
        $customer->address = $request->address;

        $customer->save();

        $this->set_message('success','Info updated successfully');
        return redirect()->route('customers.view');
    }

    public function destroy($id){
        $customer = Customer::find($id);
        $customer->delete();
        $this->set_message('success','Info deleted successfully');
        return redirect()->route('customers.view');
    }
}
