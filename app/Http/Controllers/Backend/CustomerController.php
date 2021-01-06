<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PDF;
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

    public function credit(){
        $data['payments'] = Payment::whereIn('paid_status', ['full_due', 'partial_paid'])->get();
        return view('backend.customer.credit', $data);
    }

    public function creditPdf(){
        $data['payments'] = Payment::whereIn('paid_status', ['full_due', 'partial_paid'])->get();
        $pdf = PDF::loadView('backend.pdf.customer-credit-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }

    public function editInvoice($id){
        $data['payment'] = Payment::where('invoice_id', $id)->first();

        return view('backend.customer.edit-invoice', $data);
    }

    public function updateInvoice($id, Request $request){

        if($request->new_paid_amount < $request->paid_amount){
            $this->set_message('danger', 'Sorry you insert maximum value');
            return redirect()->back();
        }

        $payment = Payment::where('invoice_id', $id)->first();
        $payment_details = new PaymentDetail();

        $exiting_paid_amount = $payment->paid_amount;
        $exiting_due_amount = $payment->due_amount;
        $payment->paid_status = $request->paid_status;

        if($request->paid_status == 'full_paid'){
            $request->validate([
                'new_paid_amount' => 'required|numeric',
                'date'=>'required|date'
            ]);
            $new_paid_amount = $request->new_paid_amount;
            $payment->paid_amount = $exiting_paid_amount + $new_paid_amount;
            $payment->due_amount = '0';
            $payment_details->current_paid_amount = $new_paid_amount;
        }
        if($request->paid_status == 'partial_paid'){
            $request->validate([
                'paid_amount' => 'required|numeric',
                'date'=>'required|date'
            ]);
            $new_paid_amount = $request->paid_amount;
            $payment->paid_amount = $exiting_paid_amount + $new_paid_amount;
            $payment->due_amount = $exiting_due_amount - $new_paid_amount;
            $payment_details->current_paid_amount = $new_paid_amount;
        }
        $payment->save();
        $payment_details->invoice_id = $id;
        $payment_details->date = date('Y-m-d',strtotime($request->date));
        $payment_details->updated_by = Auth::user()->id;

        $payment_details->save();

        $this->set_message('success', 'Invoice updated successfully');

        return redirect()->route('customers.credit');
    }

    public function invoiceDetailsPdf($id){
        $data['payment'] = Payment::where('invoice_id', $id)->first();
        $pdf = PDF::loadView('backend.pdf.customer-invoice-details', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }

    public function paidCustomer(){
        $data['payments'] = Payment::where('paid_status', '!=', 'full_due)')->get();
        return view('backend.customer.paid', $data);
    }

    public function paidCustomerPdf(){
        $data['payments'] = Payment::where('paid_status', '!=', 'full_due)')->get();
        $pdf = PDF::loadView('backend.pdf.customer-paid-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('customer-paid.pdf');
    }
}
