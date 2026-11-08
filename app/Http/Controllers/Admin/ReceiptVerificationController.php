<?php

namespace App\Http\Controllers\Admin;

use App\Models\Orders;
use App\Models\Receipts;
use App\Models\Order_items;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\OrderApprovedMail;
use App\Mail\OrderRejectedMail;

class ReceiptVerificationController extends Controller
{
    public function ordersList()
    {
        $orders = Orders::with('user')->orderBy('created_at', 'desc')->paginate(20);
        $orderIds = $orders->pluck('order_id')->toArray();

        $receipts = Receipts::with('paymentImages')
                    ->whereIn('order_id', $orderIds)
                    ->get()
                    ->keyBy('order_id');

        return view('admin.receipts.alllist', compact('orders', 'receipts'));
    }

    public function orderShow($orderId)
    {
        $order = Orders::where('order_id', $orderId)->firstOrFail();

        $items = Order_items::select('order_items.*','products.product_name','products.product_price','products.product_image')
            ->leftJoin('products','order_items.product_id','=','products.product_id')
            ->where('order_items.order_id',$order->order_id)
            ->get();

        $receipt = Receipts::with('paymentImages')->where('order_id', $order->order_id)->first();

        return view('admin.receipts.show', compact('order','items','receipt'));
    }

    public function list()
    {
        $receipts = Receipts::with([
                'paymentImages',
                'paymentMethod',
                'discountCode',
                'order.user'
            ])
            ->whereHas('order', function ($q) {
                $q->where('payment_status', 'pending_verification');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.receipts.list', compact('receipts'));
    }

    public function show($receiptId)
    {
        $receipt = Receipts::with('paymentImages')
            ->select('receipts.*', 'orders.user_id', 'orders.total_amount', 'orders.payment_status')
            ->leftJoin('orders', 'receipts.order_id', '=', 'orders.order_id')
            ->where('receipts.receipt_id', $receiptId)
            ->firstOrFail();

        $order = Orders::with(['orderItems.product', 'user']) 
            ->where('order_id', $receipt->order_id)
            ->first();

        return view('admin.receipts.show', compact('receipt', 'order'));
    }

    public function approve(Request $request, $receiptId)
    {
        $receipt = Receipts::where('receipt_id', $receiptId)->firstOrFail();
        $order = Orders::with('user')->where('order_id', $receipt->order_id)->firstOrFail(); // Added user relation

        DB::transaction(function () use ($order) {
            $order->update(['payment_status' => 'paid']);
        });

        // send approve email
        Mail::to($order->user->email)->send(new OrderApprovedMail($order));
        ActivityLog::log(
            'Payment Approved',
            Auth::user()->name . " approved the payment receipt for Order #" . $order->order_id . "."
        );

        return redirect()->route('receipts#show', $receiptId)
            ->with('success', 'Receipt approved and customer emailed!');
    }

    public function reject(Request $request, $receiptId)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500'
        ]);

        $receipt = Receipts::where('receipt_id', $receiptId)->firstOrFail();
        $order = Orders::with('user')->where('order_id', $receipt->order_id)->firstOrFail(); // Added user relation

        DB::transaction(function () use ($order) {
            $order->update(['payment_status' => 'rejected']);
        });

        // send reject email
        Mail::to($order->user->email)->send(new OrderRejectedMail($order, $request->reason));
        $reasonText = $request->reason ? " Reason given: '{$request->reason}'" : "";
        ActivityLog::log(
            'Payment Rejected',
            Auth::user()->name . " rejected the payment receipt for Order #" . $order->order_id . "." . $reasonText
        );

        return redirect()->route('receipts#show', $receiptId)
            ->with('success', 'Receipt rejected and customer emailed!');
    }
}
