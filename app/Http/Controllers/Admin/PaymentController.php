<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Payment_methods;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{

    public function list(){
        $paymentMethods = Payment_methods::select('payment_method_id', 'account_number', 'account_name', 'account_type')
        ->when(request('searchKey'), function ($query) {
                $query->whereAny(['account_number', 'account_name', 'account_type'], 'like', '%' . request('searchKey') . '%');
            })
        ->orderBy('account_type', 'asc')->paginate(5);
        return view('admin.payment.list', compact('paymentMethods'));
    }
    //create payment
    public function create(Request $request){
        $this->checkValidation($request);

        Payment_methods::create([
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'account_type' => $request->account_type,
        ]);

        return back();

    }

    //delete payment
        public function delete($id){
        Payment_methods::where('payment_method_id',$id)->delete();
        return back();
    }


    //edit payment
    public function edit($id){
        $paymentMethod=Payment_methods::where('payment_method_id',$id)->first();
        return view('admin.payment.edit', compact('paymentMethod'));
    }


    //update payment
    public function update($id,Request $request){
        $request['payment_method_id'] = $id;
        $this->checkValidation($request);

       Payment_methods::where('payment_method_id', $id)->update([
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'account_type' => $request->account_type,
        ]);


        return to_route('payment#list');
    }

    private function checkValidation($request){
        $request->validate([
            'account_number' => 'required|min:5|max:20',
            'account_name' => 'required|min:3|max:50',
            'account_type' => 'required|min:3|max:20',
        ], [
            'account_number.required' => 'အကောင့်နံပါတ် လိုအပ်ပါသည်။',
            'account_name.required' => 'အကောင့်အမည် လိုအပ်ပါသည်။',
            'account_type.required' => 'အကောင့်အမျိုးအစား လိုအပ်ပါသည်။',
        ]);
    }
}


