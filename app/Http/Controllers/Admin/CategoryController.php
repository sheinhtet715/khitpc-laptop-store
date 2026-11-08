<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog; 

class CategoryController extends Controller
{
    //view category list
    public function list()
    {
        $categories = Categories::select('category_id', 'category_name', 'created_at')
            ->when(request('searchKey'), function ($query) {
                $query->where('category_name', 'like', '%' . request('searchKey') . '%');
            })
            ->orderBy('created_at', 'desc')->paginate(5);
        return view('admin.category.list', compact('categories'));
    }

    public function create(Request $request)
    {

        $this->validateData($request);
        Categories::create([
            'category_name' => $request->categoryName,
        ]);

      
        ActivityLog::log(
            'Category Created',
            Auth::user()->name . " created a new category: '{$request->categoryName}'."
        );

        return back()->with('success', 'Category created successfully!');
    }

    public function delete($id)
    {
        // check
        $attachedProducts = \App\Models\Products::where('category_id', $id)->count();

        if ($attachedProducts > 0) {
            return back()->with('error', "Cannot delete! There are currently {$attachedProducts} product(s) in this category.");
        }

        $category = Categories::where('category_id', $id)->first();

        if ($category) {
            $categoryName = $category->category_name;
            $category->delete();

            ActivityLog::log(
                'Category Deleted',
                Auth::user()->name . " deleted the category: '{$categoryName}'."
            );
        }

        return back()->with('success', 'Category deleted successfully!');
    }

    //edit category
    public function edit($id)
    {
        $category = Categories::where('category_id', $id)->first();
        return view('admin.category.edit', compact('category'));
    }


    //update category
    public function update($id, Request $request)
    {
        $request['category_id'] = $id;
        $this->validateData($request);

        Categories::where('category_id', $id)->update([
            'category_name' => $request->categoryName,
            'updated_by' => Auth::id(),
        ]);

        ActivityLog::log(
            'Category Updated',
            Auth::user()->name . " updated the category: '{$request->categoryName}'."
        );

        return to_route('category#list')->with('success', 'Category updated successfully!');
    }

    //Validation Check
    public function validateData($request)
    {
        $request->validate([
            'categoryName' => 'required|min:2|max:30|unique:categories,category_name,'
                . $request->category_id . ',category_id'
        ], [
            'categoryName.required' => 'ကျေးဇူးပြု၍ အမျိုးအစားအမည်တစ်ခု ထည့်ပါ။',
            'categoryName.unique' => 'အမျိုးအစားအမည်သည် ရှိပြီးသားဖြစ်သည်။'
        ]);
    }
}
