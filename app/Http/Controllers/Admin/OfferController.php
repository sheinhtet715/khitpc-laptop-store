<?php

namespace App\Http\Controllers\Admin;

use App\Models\Offers;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OfferController extends Controller
{
  
public function list()
{
    $perPage = 5;
    $search = trim(request('searchKey', ''));

    $offers = Offers::with('product')
        ->when($search !== '', function ($q) use ($search) {
            $q->where(function ($q2) use ($search) {
                // offer
                $q2->where('title', 'like', "%{$search}%")
                   ->orWhere('discount_percent', 'like', "%{$search}%")
                   ->orWhere('created_at', 'like', "%{$search}%");

                //  products
                $q2->orWhereHas('product', function ($qp) use ($search) {
                    $qp->where('product_name', 'like', "%{$search}%");
                });
            });
        })
        ->orderBy('created_at', 'desc')
        ->paginate($perPage)
        ->appends(request()->query());

    $products = Products::orderBy('product_name')->get();

    return view('admin.offer.list', compact('offers', 'products'));
}



public function create(Request $request)
{

    $this->validateData($request);
    Offers::create($request->only(['product_id','title','discount_percent']));
    return back()->with('success', 'Offer created.');
}

        public function delete($id){
        Offers::where('offer_id',$id)->delete();
        return back();
    }
 //edit brand
    public function edit($id){

	$offer = Offers::where('offer_id', $id)->first();
	$used = Offers::where('offer_id','!=',$id)->pluck('product_id')->toArray();
	$products = Products::whereNotIn('product_id', $used)->orderBy('product_name')->get();

        return view('admin.offer.edit', compact('offer', 'products'));
    }


   
public function update($id, Request $request)
{
   
    $this->validateData($request, $id);
    Offers::where('offer_id', $id)->update([
        'product_id' => $request->product_id,
        'title' => $request->title,
        'discount_percent' => $request->discount_percent,
    ]);

    return to_route('offer#list')->with('success', 'Offer updated.');
}



    //Validation Check
    public function validateData(Request $request, $ignoreOfferId = null)
    {
       
        $uniqueRule = 'unique:offers,product_id';
        if ($ignoreOfferId) {
            $uniqueRule = "unique:offers,product_id,{$ignoreOfferId},offer_id";
        }

        $request->validate([
            'product_id' => ['required','exists:products,product_id', $uniqueRule],
            'title' => 'required',
            'discount_percent' => 'required|numeric|min:0|max:100',
        ], [
            'product_id.required' => 'ထုတ်ကုန် ရွေးချယ်ရန် လိုအပ်ပါသည်။',
            'product_id.exists' => 'ရွေးချယ်ထားသော ထုတ်ကုန် မရှိပါ။',
            'product_id.unique' => 'ဒီထုတ်ကုန်အတွက် အကြောင်းအရာ (offer) ရှိပြီးသားဖြစ်သည်။ ပထမဦးစွာ ဖျက်ပြီးတင်ပါ။',
            'title.required' => 'ခေါင်းစဉ် လိုအပ်ပါသည်',
            'discount_percent.required' => 'လျှော့စျေးရာခိုင်နှုန်း လိုအပ်ပါသည်။',
            'discount_percent.min' => 'လျှော့စျေးရာခိုင်နှုန်းသည် 0 ထက်မနည်းရပါ။',
            'discount_percent.max' => 'လျှော့စျေးရာခိုင်နှုန်းသည် 100 ထက်မပိုရပါ။',
        ]);
    }


}
