<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Discount_codes;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DiscountController extends Controller
{
    //view discount codes
    public function list(){
        $discounts = Discount_codes::select('discount_code_id', 'code', 'discount_percent', 'usage_limit', 'created_at')
        ->when(request('searchKey'), function ($query) {
            $query->whereAny(['code', 'discount_percent', 'usage_limit'], 'like', '%' . request('searchKey') . '%');
        })
        ->orderBy('created_at', 'desc')->paginate(5);
        return view('admin.discount.list', compact('discounts'));
    }

    //create discount codes
    public function create(Request $request){

        $this->validateData($request);
        Discount_codes::create([
            'code' =>$request->code,
            'discount_percent' =>$request->discount_percent,
            'usage_limit' =>$request->usage_limit,
            ]);


        return back();
    }

    //delete DC
        public function delete($id){
        Discount_codes::where('discount_code_id',$id)->delete();
        return back();
    }
    //edit DC
    public function edit($id){
        $discount=Discount_codes::where('discount_code_id',$id)->first();
        return view('admin.discount.edit', compact('discount'));
    }


    //update DC
    public function update($id,Request $request){
        $request['discount_code_id'] = $id;

       
        $this->validateData($request, $id);

        Discount_codes::where('discount_code_id', $id)->update([
            'code' => $request->code,
            'discount_percent' => $request->discount_percent,
            'usage_limit' => $request->usage_limit,
        ]);

        return to_route('discount#list');
    }

    //validation check
     public function validateData($request, $id = null){

        $codeRule = $id
            ? 'required|unique:discount_codes,code,' . $id . ',discount_code_id'
            : 'required|unique:discount_codes,code';

        $request->validate([
            'code' => $codeRule,
            'discount_percent' => 'required|numeric|min:0|max:100',
            'usage_limit' => 'required|numeric|min:1',
        ], [
            'code.required' => 'ကုဒ် လိုအပ်ပါသည်။',
            'code.unique' => 'ဤကုဒ်ကို အသုံးပြုထားပြီးပါပြီ။ (This code already exists.)',
            'discount_percent.required' => 'လျှော့စျေးရာခိုင်နှုန်း လိုအပ်ပါသည်။',
            'discount_percent.min' => 'လျှော့စျေးရာခိုင်နှုန်းသည် 0 ထက်မနည်းရပါ။',
            'discount_percent.max' => 'လျှော့စျေးရာခိုင်နှုန်းသည် 100 ထက်မပိုရပါ။',
            'usage_limit.required' => 'အသုံးပြုမှုကန့်သတ်ချက် လိုအပ်ပါသည်။',
            'usage_limit.min' => 'အသုံးပြုမှုကန့်သတ်ချက်သည် အနည်းဆုံး 1 ဖြစ်ရမည်။',
        ]);
    }



}
