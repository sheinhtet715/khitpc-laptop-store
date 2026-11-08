<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\ActivityLog; 

class BrandController extends Controller
{
    //
    public function list()
    {
        $brands = Brands::select('brand_id', 'brand_name', 'brand_description', 'created_at')
            ->when(request('searchKey'), function ($query) {
                $query->whereAny(['brand_name', 'brand_description'], 'like', '%' . request('searchKey') . '%');
            })
            ->orderBy('created_at', 'desc')->paginate(5);
        return view('admin.brand.list', compact('brands'));
    }

    public function create(Request $request)
    {

        $this->validateData($request);
        Brands::create([
            'brand_name'        => $request->brandName,
            'brand_description' => $request->brandDescription,
        ]);

       
        ActivityLog::log(
            'Brand Created',
            Auth::user()->name . " created a new brand: '{$request->brandName}'."
        );

        return back()->with('success', 'Brand created successfully!');
    }

    public function delete($id)
    {
        
        $attachedProducts = \App\Models\Products::where('brand_id', $id)->count();

        if ($attachedProducts > 0) {
            return back()->with('error', "Cannot delete! There are currently {$attachedProducts} product(s) assigned to this brand.");
        }

        $brand = Brands::where('brand_id', $id)->first();

        if ($brand) {
            $brandName = $brand->brand_name;
            $brand->delete();

            ActivityLog::log(
                'Brand Deleted',
                Auth::user()->name . " deleted the brand: '{$brandName}'."
            );
        }

        return back()->with('success', 'Brand deleted successfully!');
    }

    //edit brand
    public function edit($id)
    {
        $brand = Brands::where('brand_id', $id)->first();
        return view('admin.brand.edit', compact('brand'));
    }

    //update brand
    public function update($id, Request $request)
    {
        $request['brand_id'] = $id;
        $this->validateData($request);

        Brands::where('brand_id', $id)->update([
            'brand_name'        => $request->brandName,
            'brand_description' => $request->brandDescription,
        ]);

        ActivityLog::log(
            'Brand Updated',
            Auth::user()->name . " updated the brand: '{$request->brandName}'."
        );

        return to_route('brand#list')->with('success', 'Brand updated successfully!');
    }

    //Validation Check
    public function validateData($request)
    {
        $request->validate([
            'brandName' => 'required|min:2|max:30|unique:brands,brand_name,'
                . $request->brand_id . ',brand_id',
        ], [
            'brandName.required' => 'ကျေးဇူးပြု၍ အမျိုးအစားအမည်တစ်ခု ထည့်ပါ။',
            'brandName.unique'   => 'အမျိုးအစားအမည်သည် ရှိပြီးသားဖြစ်သည်။',
        ]);
    }
}
