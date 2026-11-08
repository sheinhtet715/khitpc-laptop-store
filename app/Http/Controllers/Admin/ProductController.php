<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Brands;
use App\Models\Products;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\Products_specs;
use App\Models\Restock_alerts;
use App\Models\ActivityLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function list()
    {
        $products = Products::select(
            'products.product_id',
            'products.sku',
            'products.product_name',
            'products.product_description',
            'products.product_price',
            'products.product_image',
            'brands.brand_name',
            'categories.category_name',
            'products_specs.Processor',
            'products_specs.Model',
            'products_specs.Display',
            'products_specs.Battery',
            'products_specs.Warranty',
            'products_specs.Ram',
            'products_specs.Graphics_Card',
            'products_specs.System_type',
            'products_specs.Pen_and_touch',
            'products_specs.Storage',
            'products.stock_quantity'
        )
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.brand_id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.category_id')
            ->leftJoin('products_specs', 'products.spec_id', '=', 'products_specs.spec_id')

            // Search with keyword
            ->when(request('searchKey'), function ($query) {
                $query->whereAny(
                    [
                        'products.sku',
                        'products.product_name',
                        'products.product_description',
                        'brands.brand_name',
                        'categories.category_name',
                        'products_specs.Processor',
                        'products_specs.Model',
                        'products_specs.Display',
                        'products_specs.Battery',
                        'products_specs.Warranty',
                        'products_specs.Ram',
                        'products_specs.Graphics_Card',
                        'products_specs.System_type',
                        'products_specs.Pen_and_touch',
                        'products_specs.Storage'
                    ],
                    'like',
                    '%' . request('searchKey') . '%'
                );
            })
            // Brand Filter
            ->when(request('filterBrand'), function ($query) {
                $query->where('products.brand_id', request('filterBrand'));
            })
            // Category Filter
            ->when(request('filterCategory'), function ($query) {
                $query->where('products.category_id', request('filterCategory'));
            })

            ->orderBy('products.created_at', 'desc')
            ->paginate(8);

        $brands     = Brands::orderBy('brand_name')->get();
        $categories = Categories::orderBy('category_name')->get();
        $specs      = Products_specs::orderBy('spec_id', 'desc')->get();

        return view('admin.products.list', compact('products', 'brands', 'categories', 'specs'));
    }

    public function create(Request $request)
    {
        $this->checkValidation($request, "create");
        $data = $this->getData($request);

        if ($request->hasFile("product_image")) {
            $fileName = uniqid() . $request->file("product_image")->getClientOriginalName();
            $request->file("product_image")->move(public_path() . "/productImage/", $fileName);
            $data['product_image'] = $fileName;
        }

        Products::create($data);

        ActivityLog::log(
            'Product Created',
            Auth::user()->name . " added a new laptop: '{$request->productName}' (SKU: {$request->sku})."
        );

        return back()->with('success', 'Product successfully created!');
    }


    public function edit($id)
    {
        $brands     = Brands::orderBy('brand_name')->get();
        $categories = Categories::orderBy('category_name')->get();
        $specs      = Products_specs::orderBy('spec_id', 'desc')->get();
        $product    = Products::where('product_id', $id)->first();
        return view('admin.products.edit', compact('product', 'brands', 'categories', 'specs'));
    }

    public function update(Request $request)
    {
        $this->checkValidation($request, 'update', $request->productId);
        $data = $this->getData($request);
        $product = Products::where('product_id', $request->productId)->firstOrFail();
        $oldStock = intval($product->stock_quantity ?? 0);

        if ($request->hasFile('product_image')) {
            $oldImageName = $request->productImage;

            if (!empty($oldImageName) && file_exists(public_path('productImage/' . $oldImageName))) {
                unlink(public_path('productImage/' . $oldImageName));
            }

            $fileName = uniqid() . $request->file("product_image")->getClientOriginalName();
            $request->file("product_image")->move(public_path() . '/productImage/', $fileName);
            $data['product_image'] = $fileName;
        } else {
            $data['product_image'] = $request->productImage;
        }

        Products::where('product_id', $request->productId)->update($data);

        $product = Products::where('product_id', $request->productId)->first();
        $newStock = intval($product->stock_quantity ?? 0);

        if ($oldStock > 0 && $newStock <= 0) {
            Restock_alerts::where('product_id', $product->product_id)
                ->update([
                    'notified' => false,
                    'notification_message' => null,
                    'is_read' => true 
                ]);
        }

        if ($oldStock <= 0 && $newStock > 0) {
            $alerts = Restock_alerts::where('product_id', $product->product_id)
                ->where('notified', false)
                ->get();

            if ($alerts->isNotEmpty()) {
                foreach ($alerts as $alert) {
                    $alert->notified = true;
                    $alert->is_read = false; 
                    $alert->notification_message = "Good news — '{$product->product_name}' is back in stock. Visit the store to purchase.";
                    $alert->save();
                }
            }
        }

        ActivityLog::log(
            'Product Updated',
            Auth::user()->name . " updated the laptop: '{$request->productName}' (SKU: {$request->sku})."
        );

        return to_route('product#list')->with('success', 'Product updated successfully!');
    }

    public function delete($id)
    {
        $product = Products::where('product_id', $id)->first();

        if ($product) {
            $productName = $product->product_name;
            $sku = $product->sku;
            $product->delete();

            ActivityLog::log(
                'Product Deleted',
                Auth::user()->name . " deleted the laptop: '{$productName}' (SKU: {$sku})."
            );
        }

        return back()->with('success', 'Product deleted successfully!');
    }

    public function getData($request)
    {
        return [
            'sku'                 => $request->sku,
            'product_name'        => $request->productName,
            'product_description' => $request->productDescription,
            'product_price'       => $request->productPrice,
            'brand_id'            => $request->brandId,
            'category_id'         => $request->categoryId,
            'spec_id'             => $request->specId,
            'stock_quantity'      => $request->stockQuantity,
        ];
    }

   private function checkValidation($request, $action, $productId = null)
    {

        $skuRule = 'required|min:2|max:255|unique:products,sku';
        $nameRule = 'required|max:255|unique:products,product_name';

        if ($action === 'update' && $productId) {
            $skuRule .= ',' . $productId . ',product_id';
            $nameRule .= ',' . $productId . ',product_id';
        }

        $rules = [
            'sku'                => $skuRule,
            'productName'        => $nameRule,
            'productDescription' => 'required|max:2000',
            'productPrice'       => 'required|numeric|min:0',
            'brandId'            => 'required',
            'categoryId'         => 'required',
            'stockQuantity'      => 'required|numeric|min:0|max:50',
        ];

        $rules['product_image'] = $action == 'create'
            ? 'required|image|mimes:jpg,jpeg,png,gif,webp,bmp,svg|max:2048'
            : 'image|mimes:jpg,jpeg,png,gif,webp,bmp,svg|max:2048';

        $messages = [
            'sku.unique'         => 'ဤ SKU ကို အခြားလက်တော့ပ်တစ်ခုသို့ (assigned)သတ်မှတ်ပြီးဖြစ်သည်။',
            'productName.unique' => 'အမည်တူ ထုတ်ကုန်တစ်ခုသည် ကတ်တလောက်တွင် ရှိနှင့်ပြီးဖြစ်သည်။',
            'stockQuantity.max'  => 'စတော့ ပစ္စည်း ၅၀ ထက် မပိုရ။',
            'product_image.max'  => 'ထုတ်ကုန်ပုံသည် 2MB ထက် မကြီးရပါ။',
        ];

        $request->validate($rules, $messages);
    }
}

