<?php

namespace App\Http\Controllers\User;

use App\Models\Products;
use App\Models\Reviews;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    

      public function store(Request $request, Products $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:2000',
        ]);

        $user = Auth::user();

     
        $existing = Reviews::where('user_id', $user->id)
                          ->where('product_id', $product->product_id)
                          ->first();
        if ($existing) {
            
            $existing->update([
                'rating' => (int)$request->rating,
                'review_text' => $request->review_text,
            ]);
            return redirect()->back()->with('success', 'Review updated.');
        }

       
        Reviews::create([
            'user_id' => $user->id,
            'product_id' => $product->product_id,
            'rating' => (int)$request->rating,
            'review_text' => $request->review_text,
        ]);

        return redirect()->back()->with('success', 'Thanks — your review was submitted.');
    }
}
