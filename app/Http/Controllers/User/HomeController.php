<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    
    public function newArrivals(Request $request)
    {
       
        $perPage = 12;


        $products = DB::table('products')
            ->leftJoin('brands', 'brands.brand_id', '=', 'products.brand_id')
            ->leftJoin('categories', 'categories.category_id', '=', 'products.category_id')
            ->leftJoin('offers', 'offers.product_id', '=', 'products.product_id')
            
            ->leftJoin(DB::raw('(
                SELECT product_id, AVG(rating) AS avg_rating, COUNT(*) AS reviews_count
                FROM reviews
                GROUP BY product_id
            ) r'), 'r.product_id', '=', 'products.product_id')
            ->select(
                'products.*',
                'brands.brand_name',
                'categories.category_name',
                'offers.discount_percent',
                DB::raw('COALESCE(r.avg_rating, 0) as reviews_avg_rating'),
                DB::raw('COALESCE(r.reviews_count, 0) as reviews_count')
            )
            ->orderBy('products.created_at', 'desc') 
            ->paginate($perPage);

        
        $brands = DB::table('brands')->orderBy('brand_name')->get();
        $categories = DB::table('categories')->orderBy('category_name')->get();

        return view('user.newarrivals', [
            'products'   => $products,
            
            'brands'     => $brands,
            'categories' => $categories,
        ]);
    }
    public function about()
    {
        return view('user.about');
    }

    public function contact()
    {
        return view('user.contact');
    }
}
