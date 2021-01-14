<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function index()
    {
        $data['invoices'] = Invoice::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', 1)->get();
        return view('backend.invoice.view', $data);
    }

    public function pendingList(){
        $data['invoices']= Invoice::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', 0)->get();
        return view('backend.invoice.pendingList', $data);
    }
    public function add()
    {
        $data['categories'] = Category::all();
        $data['customers'] = Customer::select('id', 'name', 'mobile', 'address')->get();
        $invoice_data = Invoice::orderBy('id', 'desc')->first();
        if ($invoice_data == null) {
            $first_reg = 0;
            $data['invoice_no'] = $first_reg + 1;
        } else {
            $invoice_data = Invoice::orderBy('date', 'desc')->orderBy('id', 'desc')->first()->invoice_no;
            $data['invoice_no'] = $invoice_data + 1;
        }
        $data['date'] = date('Y-m-d');
        return view('backend.invoice.add', $data);
    }

    protected function invoice_details_basic_info($request, $invoice_id)
    {
        $count_category = count($request->category_id);
        for ($i = 0; $i < $count_category; $i++) {
            $invoice_details = new InvoiceDetail();
            $invoice_details->date = $request->date;
            $invoice_details->invoice_id = $invoice_id;
            $invoice_details->category_id = $request->category_id[$i];
            $invoice_details->product_id = $request->product_id[$i];
            $invoice_details->selling_qty = $request->selling_qty[$i];
            $invoice_details->unit_price = $request->unit_price[$i];
            $invoice_details->total_price = $request->total_price[$i];
            $invoice_details->status = '0';
            $invoice_details->save();
        }
    }

    protected function customer_basic_info()
    {
        if (request()->customer_id == '0') {
            $customer = new Customer();
            $customer->name = request()->name;
            $customer->mobile = request()->mobile;
            $customer->email = request()->email;
            $customer->address = request()->address;
            $customer->save();
            $customer_id = $customer->id;
        } else {
            $customer_id = request()->customer_id;
        }
        return $customer_id;
    }

    protected function invoice_basic_info($request)
    {
        $invoice = new Invoice();
        $invoice->invoice_no = $request->invoice_no;
        $invoice->date = date('Y-m-d', strtotime($request->date));
        $invoice->description = $request->description;
        $invoice->created_by = Auth::user()->id;
        $invoice->status = '0';

        DB::transaction(function () use ($request, $invoice) {
            if ($invoice->save()) {
                $invoice_id = $invoice->id;
                $this->invoice_details_basic_info($request, $invoice_id);
                $customer_id = $this->customer_basic_info();
                $this->payment_general_info($invoice_id, $customer_id);
            }
        });

    }

    protected function payment_general_info($invoice_id, $customer_id)
    {
        $payment = new Payment();
        $payment_details = new PaymentDetail();
        $payment->invoice_id = $invoice_id;
        $payment->customer_id = $customer_id;
        $payment->paid_status = request()->paid_status;
        $payment->discount_amount = request()->discount_amount;
        $payment->total_amount = request()->estimated_amount;

        if (request()->paid_status == 'full_paid') {
            $payment->paid_amount = request()->estimated_amount;
            $payment->due_amount = '0';
            $payment_details->current_paid_amount = request()->estimated_amount;
        }

        if (request()->paid_status == 'full_due') {
            $payment->paid_amount = '0';
            $payment->due_amount = request()->estimated_amount;
            $payment_details->current_paid_amount = '0';
        }

        if (request()->paid_status == 'partial_paid') {
            $payment->paid_amount = request()->paid_amount;
            $payment->due_amount = request()->estimated_amount - request()->paid_amount;
            $payment_details->current_paid_amount = request()->paid_amount;
        }
        $payment->save();

        $payment_details->invoice_id = $invoice_id;
        $payment_details->date = date('Y-m-d', strtotime(request()->date));
        $payment_details->invoice_id = $invoice_id;

        $payment_details->save();
    }

    public function store(Request $request)
    {
        if($request->customer_id == '0'){
            $validator = Validator::make($request->all(), [
                'mobile' => "required|min:11|unique:customers,mobile",
                'email' => "required|email|unique:customers,email",
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }
        if ($request->category_id == null) {
            $this->set_message('danger', 'Please select a category');
            return redirect()->back();
        }
        if ($request->paid_amount > $request->estimated_amount || $request->discount_amount > $request->estimated_amount) {
            $this->set_message('danger', 'You entered a more than grad total');
            return redirect()->back();
        }

        $this->invoice_basic_info($request);

        $this->set_message('success', 'Invoice created successfully');
        return redirect()->route('invoice.pending.list');
    }

    public function destroy($id){
        $invoice = Invoice::find($id);
        $invoice->delete();

        $this->set_message('success', 'Invoice created successfully');
        return redirect()->route('invoice.pending.list');
    }

    public function approve($id){
        $data['invoice'] = Invoice::with(['invoice_details'])->find($id);
       return view('backend.invoice.approve', $data);
    }

    public function approvalStore(Request $request, $id){

        foreach ($request->selling_qty as $key=>$val){
            $invoice_details = InvoiceDetail::where('id', $key)->first();
            $product = Product::where('id', $invoice_details->product_id)->first();
            if($product->quantity < $invoice_details->selling_qty){
                $this->set_message('danger', 'Sorry! These amount is currently unavailable. You have to purchase the same product to approve this invoice');
                return redirect()->back();
            }
        }
        $invoice = Invoice::find($id);
        $invoice->approved_by = Auth::user()->id;
        $invoice->status = '1';

        DB::transaction(function () use($request, $invoice, $id){
            foreach ($request->selling_qty as $key=>$val){
                $invoice_details = InvoiceDetail::where('id', $key)->first();
                $invoice_details->status = '1';
                $invoice_details->save();
                $product = Product::where('id', $invoice_details->product_id)->first();
                $product->quantity = ((float)$product->quantity) - ((float)$invoice_details->selling_qty);
                $product->save();
            }
         $invoice->save();
        });

        $this->set_message('success', 'Invoice approved successfully');
        return redirect()->route('invoice.pending.list');
    }

}
