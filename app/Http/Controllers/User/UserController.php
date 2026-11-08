<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Brands;
use App\Models\Offers;
use App\Models\Orders;
use App\Models\Reviews;
use App\Models\Products;
use App\Models\Receipts;
use App\Models\Action_log;
use App\Models\Cart_items;
use App\Models\Categories;
use App\Models\Order_items;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PaymentImages;
use App\Models\Discount_codes;
use App\Models\Products_specs;
use App\Models\Restock_alerts;
use App\Models\Payment_methods;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    
    public function index(Request $request)
    {
        if (Auth::check()) {
            
            $role = Auth::user()->role;

            if ($role === 'admin' || $role === 'superadmin') {
           
                return redirect()->route('admin#home');
            }
        }

        $search = trim($request->get('searchKey', ''));

        
        $getFreshQuery = function () {
            return $this->productBaseQuery()
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->withCount(['actionLogs as views_count' => function ($q) {
                    $q->where('action', 'view');
                }]);
        };

       
        $newArrivals = $getFreshQuery()
            ->orderBy('products.created_at', 'desc')
            ->limit(4)
            ->get();

       
        $specialOffers = $getFreshQuery()
            ->where('offers.discount_percent', '>', 0)
            ->orderBy('offers.discount_percent', 'desc')
            ->limit(4)
            ->get();

      
      
        $featuredReviews = \App\Models\Reviews::with('user')
            ->where('is_featured', true)
            ->latest()
            ->get();

      
        $query = $getFreshQuery();

        if ($search !== '') {
            $this->applySearch($query, $search);
        }

        $this->applyRequestFilters($query, $request);
        $this->applySorting($query, $request->get('sort'));

        
        $products = $query->paginate(12)->appends($request->query());

       
        $viewData = array_merge(
            compact('products', 'newArrivals', 'specialOffers', 'featuredReviews'),
            $this->getDropdownData()
        );

        return view('user.home.list', $viewData);
    }
    public function productDetails(Request $request, $id)
    {
        Action_log::create([
            'user_id'    => Auth::id(), 
            'product_id' => $id,
            'action'     => 'view',
        ]);

        $product = $this->productBaseQuery()
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->withCount(['actionLogs as views_count' => function ($q) {
                $q->where('action', 'view');
            }])
            ->where('products.product_id', $id)
            ->firstOrFail();

        $reviews = Reviews::where('product_id', $id)->with('user')->orderBy('created_at', 'desc')->paginate(5);
        $myReview = Auth::check() ? Reviews::where('product_id', $id)->where('user_id', Auth::id())->first() : null;
        $inWishlist = Auth::check() ? DB::table('wishlist_items')->where('user_id', Auth::id())->where('product_id', $id)->exists() : false;
        $isSubscribed = Auth::check() ? Restock_alerts::where('user_id', Auth::id())->where('product_id', $id)->exists() : false;

        
        if ($request->filled('alert_id') && Auth::check()) {
            Restock_alerts::where('alert_id', intval($request->get('alert_id')))
                ->where('user_id', Auth::id())->where('product_id', $id)->where('notified', true)
                ->update(['is_read' => true]);
        }

        return view('user.detail', array_merge(
            compact('product', 'reviews', 'myReview', 'inWishlist', 'isSubscribed'),
            $this->getDropdownData()
        ));
    }

    public function newArrivals(Request $request)
    {
        $products = $this->productBaseQuery()
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->withCount(['actionLogs as views_count' => function ($q) {
                $q->where('action', 'view');
            }])
            ->orderBy('products.created_at', 'desc')
            ->paginate(12)->appends($request->query());

        return view('user.newarrivals', array_merge(compact('products'), $this->getDropdownData()));
    }

    public function specialOffers(Request $request)
    {
        
        $products = $this->productBaseQuery()
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->withCount(['actionLogs as views_count' => function ($q) {
                $q->where('action', 'view');
            }])
            ->where('offers.discount_percent', '>', 0)
            ->orderBy('products.created_at', 'desc')
            ->paginate(12)->appends($request->query());

        return view('user.special_offers', array_merge(compact('products'), $this->getDropdownData()));
    }

    public function mostPopular(Request $request)
    {
        $products = $this->productBaseQuery()
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->withCount(['actionLogs as views_count' => function ($q) {
                $q->where('action', 'view');
            }])
            
            ->whereHas('actionLogs', function ($q) {
                $q->where('action', 'view');
            }, '>', 10)
            ->orderByDesc('views_count')
            ->orderBy('products.created_at', 'desc')
            ->paginate(12)
            ->appends($request->query());

        return view('user.most_popular', array_merge(compact('products'), $this->getDropdownData()));
    }
    public function login()
    {
        return view('authentication.login');
    }


    

    public function review(Request $request)
    {
       
        $request->validate([
            'rating'      => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:500',
        ], [
            'review_text.max' => 'Your review cannot exceed 500 characters.',
            'rating.required' => 'Please select a star rating.'
        ]);

        
        if ($request->review_text) {
           
            $badWords = ['scam', 'idiot', 'stupid', 'fake', 'hate', 'bullshit', 'trash'];

            $commentText = strtolower($request->review_text);

            foreach ($badWords as $word) {
                if (str_contains($commentText, $word)) {
                    
                    Alert::error('Rejected', 'Your review contains inappropriate language and cannot be posted.');
                    return back();
                }
            }
        }

       
        Reviews::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $request->product_id],
            ['rating' => $request->rating, 'review_text' => $request->review_text]
        );

        Alert::success('Success', 'Review submitted successfully!');
        return back();
    }

    public function deleteReview($id)
    {
        $review = Reviews::where('review_id', $id)->firstOrFail();
        if ((int) Auth::id() !== (int) $review->user_id) return back()->with('error', 'Unauthorized access.');

        $review->delete();
        Alert::success('Deleted', 'Your review has been deleted.');
        return back();
    }

    public function addToCart(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer',
            'quantity'   => 'nullable|integer|min:1',
        ]);

        $product = \App\Models\Products::findOrFail($data['product_id']);

       
        if (($product->stock_quantity ?? 0) <= 0) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'out_of_stock' => true,
                    'message' => "This laptop is currently out of stock. You can register for a restock notification on the details page.",
                ], 422); 
            }
            return back()->with('error', "This product is currently out of stock.");
        }
  
        $maxCartLimit = 10;

       
        $actualLimit = min($maxCartLimit, $product->stock_quantity ?? 10);

        $cartItem = \App\Models\Cart_items::firstOrNew([
            'user_id' => Auth::id(),
            'product_id' => $data['product_id']
        ]);

      
        $requestedQuantity = $data['quantity'] ?? 1;
        $currentQuantity = $cartItem->quantity ?? 0;
        $newQuantity = $currentQuantity + $requestedQuantity;

       
        if ($newQuantity > $actualLimit) {
            
            if ($currentQuantity < $actualLimit) {
                $cartItem->quantity = $actualLimit;
                $cartItem->save();
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'limit_reached' => true,
                    'message' => "You can only add up to {$actualLimit} of this item to your cart.",
                ], 422); 
            }
            return back()->with('error', "Limit reached. You can only add up to {$actualLimit} of this item.");
        }

        
        $cartItem->quantity = $newQuantity;
        $cartItem->save();

        return $request->expectsJson() ? response()->json(['success' => true]) : back()->with('success', 'Added to cart.');
    }
    public function cart()
    {
        $cartData = $this->getCartData(Auth::id());
        return view('user.cart', [
            'cartItems' => $cartData['items'],
            'subtotal'  => $cartData['subtotal'],
            'discount'  => $cartData['discount'],
            'total'     => $cartData['total']
        ]);
    }

    public function updateCartQuantity(Request $request)
    {
        $data = $request->validate([
            'cart_item_id' => 'required|integer',
            'quantity'     => 'required|integer|min:1',
        ]);

        $cart = \App\Models\Cart_items::where('cart_item_id', $data['cart_item_id'])->where('user_id', Auth::id())->firstOrFail();
        $product = \App\Models\Products::find($cart->product_id);

        
        $maxLimit = min(10, $product->stock_quantity ?? 10);
        if ($data['quantity'] > $maxLimit) {
            return response()->json([
                'success' => false,
                'message' => "Only {$maxLimit} items available."
            ], 422);
        }

        $cart->update(['quantity' => $data['quantity']]);

        $cartData = $this->getCartData(Auth::id());
        $updatedItem = $cartData['items']->firstWhere('cart_item_id', $cart->cart_item_id);

        return response()->json([
            'success'        => true,
            'itemAmount'     => $updatedItem ? ($updatedItem->unit_price * $updatedItem->quantity) : 0,
            'subtotal'       => $cartData['subtotal'],
            'discount'       => $cartData['discount'],
            'total'          => $cartData['total'],
            'total_quantity' => $cartData['items']->sum('quantity') // Add this for live count
        ]);
    }

    public function removeCartItem(Request $request)
    {
        \App\Models\Cart_items::where('cart_item_id', $request->cart_item_id)->where('user_id', Auth::id())->delete();
        $cartData = $this->getCartData(Auth::id());

        return response()->json([
            'success'  => true,
            'subtotal' => $cartData['subtotal'],
            'discount' => $cartData['discount'],
            'total'    => $cartData['total'],
        ]);
    }
public function applyDiscount(Request $request)
    {
        $inputCode = trim($request->validate(['code' => 'required|string'])['code']);
        $cartData = $this->getCartData(Auth::id());

        try {
            
            $dc = Discount_codes::where('code', $inputCode)->first();

            if (!$dc) throw new \Exception('Invalid discount code.');
            if ($dc->usage_limit <= 0) throw new \Exception('This code has been used up.');

           
            $couponPercent = floatval($dc->discount_percent ?? 0);

            $couponAmount = (int) round($cartData['subtotal'] * ($couponPercent / 100));
            $combinedDiscount = $cartData['discount'] + $couponAmount;
            $finalTotal = max(0, $cartData['subtotal'] - $couponAmount);

            return response()->json([
                'success'        => true,
                'subtotal'       => $cartData['subtotal'],
                'discount'       => $combinedDiscount,
                'coupon'         => $couponAmount,
                'coupon_percent' => $couponPercent,
                'total'          => $finalTotal,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
    public function placeOrder(Request $request)
    {
        if (!Cart_items::where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'Your cart is empty.');
        }
        session(['checkout_discount_code' => trim($request->input('code', ''))]);
        return redirect()->route('user#paymentPage');
    }

    public function paymentPage()
    {
        $cartData = $this->getCartData(Auth::id());
        if ($cartData['items']->isEmpty()) return redirect()->route('user#cart')->with('error', 'Your cart is empty.');

        return view('user.payment', [
            'cartItems'      => $cartData['items'],
            'subtotal'       => $cartData['subtotal'],
            'discount'       => $cartData['discount'],
            'total'          => $cartData['total'],
            'paymentMethods' => Payment_methods::orderBy('account_name')->get(),
            'discountCode'   => session('checkout_discount_code', ''),
            'receipt'        => null,
            'paymentImages'  => collect()
        ]);
    }

public function submitPayment(Request $request)
    {
        $data = $request->validate([
            'amount'           => 'required|numeric|min:0',
            'payment_method'   => 'required|integer|exists:payment_methods,payment_method_id',
            'payment_images'   => 'required|array|min:1',
            'payment_images.*' => 'image|max:5120',
        ]);

        $cartData = $this->getCartData(Auth::id());
        if ($cartData['items']->isEmpty()) return back()->with('error', 'Your cart is empty.');

        DB::beginTransaction();
        try {
            $discountCodeId = null;

           
            if ($code = session('checkout_discount_code')) {
              
                $dc = Discount_codes::where('code', trim($code))->lockForUpdate()->first();

                
                if (!$dc || $dc->usage_limit <= 0) {
                    throw new \Exception("The discount code '{$code}' is no longer valid or has run out of uses.");
                }

                $discountCodeId = $dc->discount_code_id;

                
                $dc->decrement('usage_limit', 1);
            }
            

            $order = Orders::create([
                'user_id'          => Auth::id(),
                'discount_code_id' => $discountCodeId,
                'total_amount'     => $cartData['total'],
                'payment_status'   => 'pending_verification',
            ]);

            foreach ($cartData['items'] as $it) {
                Order_items::create([
                    'order_id'       => $order->order_id,
                    'product_id'     => $it->product_id,
                    'boughtquantity' => $it->quantity,
                ]);

         
                $product = Products::lockForUpdate()->find($it->product_id);
                if (!$product || $product->stock_quantity < $it->quantity) {
                    throw new \Exception("Insufficient stock for {$it->product_name}.");
                }
                $product->decrement('stock_quantity', $it->quantity);
            }

            $receipt = Receipts::create([
                'user_id'           => Auth::id(),
                'order_id'          => $order->order_id,
                'amount'            => $data['amount'],
                'payment_method_id' => $data['payment_method'],
                'discount_code_id'  => $discountCodeId,
            ]);

            $destPath = public_path('payment_images');
            if (!file_exists($destPath)) mkdir($destPath, 0755, true);

            foreach ($request->file('payment_images') as $file) {
                if (!$file->isValid()) continue;
                $filename = uniqid('pay_') . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move($destPath, $filename);
                PaymentImages::create(['receipt_id' => $receipt->receipt_id, 'payimages' => $filename]);
            }

            Cart_items::where('user_id', Auth::id())->delete();
            DB::commit();
            session()->forget('checkout_discount_code');

            return redirect()->route('user#orders')->with('success', 'Payment submitted successfully. Pending verification.');
        } catch (\Exception $e) {
            DB::rollBack();

           
            if (str_contains($e->getMessage(), 'discount code')) {
                 session()->forget('checkout_discount_code');
            }

            return back()->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }



    public function orders()
    {
        $orders = Orders::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);
        $orderIds = $orders->pluck('order_id')->toArray();

        $itemsCountMap = Order_items::select('order_id', DB::raw('COUNT(*) as items_count'))
            ->whereIn('order_id', $orderIds)->groupBy('order_id')->pluck('items_count', 'order_id')->toArray();
        $receiptsMap = Receipts::whereIn('order_id', $orderIds)->get()->keyBy('order_id')->toArray();

        return view('user.orders', compact('orders', 'itemsCountMap', 'receiptsMap'));
    }

    public function orderDetails($orderId)
    {
        $order = Orders::where('order_id', $orderId)->where('user_id', Auth::id())->firstOrFail();
        $orderItems = Order_items::select('order_items.*', 'products.product_name', 'products.product_price', 'products.product_image')
            ->leftJoin('products', 'order_items.product_id', '=', 'products.product_id')
            ->where('order_items.order_id', $order->order_id)->get();

        $receipt = Receipts::where('order_id', $order->order_id)->first();
        $paymentImages = $receipt ? PaymentImages::where('receipt_id', $receipt->receipt_id)->get() : collect();

        return view('user.order_details', compact('order', 'orderItems', 'receipt', 'paymentImages'));
    }

    public function wishlist()
    {
        $items = DB::table('wishlist_items')
            ->where('wishlist_items.user_id', Auth::id())
            ->join('products', 'wishlist_items.product_id', '=', 'products.product_id')
            ->select('wishlist_items.wishlist_id', 'products.*')
            ->orderBy('wishlist_items.created_at', 'desc')
            ->paginate(9);
        return view('user.wishlist', compact('items'));
    }

    public function addToWishlist(Request $request)
    {
        $pid = $request->validate(['product_id' => 'required|integer'])['product_id'];

        if (DB::table('wishlist_items')->where('user_id', Auth::id())->where('product_id', $pid)->exists()) {
            return back()->with('info', 'Already in wishlist.');
        }

        DB::table('wishlist_items')->insert(['user_id' => Auth::id(), 'product_id' => $pid, 'created_at' => now(), 'updated_at' => now()]);
        return back()->with('success', 'Added to wishlist.');
    }

    public function removeFromWishlist(Request $request)
    {
        DB::table('wishlist_items')->where('user_id', Auth::id())->where('product_id', $request->product_id)->delete();
        return back()->with('success', 'Removed from wishlist.');
    }



    public function alerts()
    {
        $alerts = Restock_alerts::where('user_id', Auth::id())->where('notified', true)->orderBy('created_at', 'desc')->get();
        return view('user.alerts', compact('alerts'));
    }

    public function markAlertRead(Request $request, $alertId)
    {
        Restock_alerts::where('alert_id', $alertId)->where('user_id', Auth::id())->where('notified', true)->update(['is_read' => true]);
        return $this->alertResponse($request);
    }

    public function markAllAlertsRead(Request $request)
    {
        Restock_alerts::where('user_id', Auth::id())->where('notified', true)->where('is_read', false)->update(['is_read' => true]);
        return $this->alertResponse($request);
    }

    private function alertResponse($request)
    {
        $unreadCount = Restock_alerts::where('user_id', Auth::id())->where('notified', true)->where('is_read', false)->count();
        return $request->expectsJson() ? response()->json(['success' => true, 'unreadCount' => $unreadCount]) : back();
    }

    public function registerRestockAlert(Request $request, $productId)
    {
        Restock_alerts::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $productId],
            ['notified' => false, 'notification_message' => null, 'is_read' => true, 'created_at' => Carbon::now()]
        );
        return redirect()->route('user#productDetails', $productId)->with('success', 'Subscribed to restock alerts.');
    }

    public function unregisterRestockAlert(Request $request, $productId)
    {
        Restock_alerts::where('user_id', Auth::id())->where('product_id', $productId)->delete();
        return redirect()->route('user#productDetails', $productId)->with('success', 'Subscription cancelled.');
    }

 

    private function getCartData($userId)
    {
        $cartItems = Cart_items::select(
            'cart_items.cart_item_id',
            'cart_items.product_id',
            'cart_items.quantity',
            'products.product_name',
            'products.product_price',
            'products.product_image',
            'offers.discount_percent'
        )
            ->leftJoin('products', 'cart_items.product_id', '=', 'products.product_id')
            ->leftJoin('offers', function ($join) {
                $join->on('offers.product_id', '=', 'products.product_id')
                    ->orOn('offers.offer_id', '=', 'products.offer_id');
            })
            ->where('cart_items.user_id', $userId)
            ->get();

        $subtotal = 0;
        $discountTotal = 0;
        foreach ($cartItems as $it) {
            $orig = floatval($it->product_price ?? 0);
            $disc = floatval($it->discount_percent ?? 0);
            $unitPrice = $disc > 0 ? round($orig * (1 - ($disc / 100))) : $orig;

            $it->unit_price = $unitPrice;
            $it->item_amount = $unitPrice * $it->quantity;

            $subtotal += $it->item_amount;
            $discountTotal += ($orig - $unitPrice) * $it->quantity;
        }

        return ['items' => $cartItems, 'subtotal' => $subtotal, 'discount' => round($discountTotal), 'total' => max(0, $subtotal)];
    }

    private function productBaseQuery()
    {
        return Products::select(
            'products.product_id as id',
            'products.category_id',
            'products.sku',
            'products.product_name',
            'products.product_description',
            'products.product_price',
            'products.product_image',
            'products.stock_quantity',
            'brands.brand_name',
            'categories.category_name',
            'products_specs.Model as model',
            'products_specs.Processor as processor',
            'products_specs.Ram as ram',
            'products_specs.Graphics_Card as graphics_card',
            'products_specs.System_type as system_type',
            'products_specs.Display as display',
            'products_specs.Storage as storage',
            'products_specs.Battery as battery',
            'products_specs.Pen_and_touch as pen_and_touch',
            'products_specs.Warranty as warranty',

            'offers.discount_percent as discount_percent'
        )
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.brand_id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.category_id')
            ->leftJoin('products_specs', 'products.spec_id', '=', 'products_specs.spec_id')
            ->leftJoin('offers', function ($join) {
                $join->on('offers.product_id', '=', 'products.product_id')
                    ->orOn('offers.offer_id', '=', 'products.offer_id');
            });
    }

    private function applySearch($query, string $search)
    {
        $query->where(function ($q2) use ($search) {
            $q2->where('products.product_name', 'like', "%{$search}%")
                ->orWhere('brands.brand_name', 'like', "%{$search}%")
                ->orWhere('categories.category_name', 'like', "%{$search}%");
        });
    }

    private function applyRequestFilters($query, Request $request)
    {
        if ($request->filled('brand')) $query->where('products.brand_id', $request->brand);
        if ($request->filled('category')) $query->where('products.category_id', $request->category);
    }

    private function applySorting($query, $sort)
    {
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('products.product_price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('products.product_price', 'desc');
                break;
            default:
                $query->orderBy('products.created_at', 'desc');
                break;
        }
    }

    private function getDropdownData()
    {
        return [
            'brands'     => Brands::orderBy('brand_name')->get(),
            'categories' => Categories::orderBy('category_name')->get(),
            'offers'     => Offers::orderBy('discount_percent')->get(),
            'specs'      => Products_specs::orderBy('spec_id', 'desc')->get(),
        ];
    }
}
