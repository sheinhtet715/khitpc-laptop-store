@extends('user.layouts.master')

@section('content')

<style>
   
    .orders-container {
        min-height: 70vh; 
    }

    .orders-title {
        color: #1E3A5F; 
        letter-spacing: 0.5px;
    }

    .order-card {
        background-color: #ffffff;
        border: 1px solid rgba(30, 58, 95, 0.08);
        border-radius: 12px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .order-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(30, 58, 95, 0.06);
    }


    .order-id {
        color: #1F2937;
        font-size: 1.2rem;
    }

    .order-total {
        color: #D32F2F; 
        font-size: 1.3rem;
        font-weight: 700;
    }

    .order-meta-icon {
        color: #FFBF00; 
        width: 16px;
        text-align: center;
    }

    .status-badge {
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        padding: 6px 12px;
        border-radius: 6px;
    }

    .status-pending {
        background-color: rgba(255, 191, 0, 0.15);
        color: #b38600; /* Darker Gold */
        border: 1px solid rgba(255, 191, 0, 0.3);
    }

    .status-paid {
        background-color: rgba(16, 185, 129, 0.1);
        color: #10b981; /* Emerald Green */
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .status-rejected {
        background-color: rgba(211, 47, 47, 0.1);
        color: #D32F2F; /* Primary Red */
        border: 1px solid rgba(211, 47, 47, 0.3);
    }

    .status-default {
        background-color: rgba(108, 117, 125, 0.1);
        color: #6c757d;
        border: 1px solid rgba(108, 117, 125, 0.3);
    }


    .btn-view-order {
        background-color: #ffffff;
        color: #1E3A5F;
        border: 2px solid rgba(30, 58, 95, 0.15);
        border-radius: 8px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.2s ease;
    }

    .btn-view-order:hover {
        background-color: #1E3A5F;
        color: #ffffff;
        border-color: #1E3A5F;
    }

    /* --- Empty State --- */
    .orders-empty-state {
        background: #ffffff;
        border: 1px dashed rgba(30, 58, 95, 0.1);
        border-radius: 16px;
        padding: 4rem 2rem;
    }

    .orders-empty-icon {
        font-size: 4rem;
        color: #1E3A5F; /* Navy Accent */
        margin-bottom: 1rem;
        opacity: 0.3;
    }
</style>

<div class="container my-5 orders-container">
    <h3 class="mb-4 fw-bold text-uppercase orders-title">My Orders</h3>

    @if($orders->isEmpty())
        <div class="text-center shadow-sm orders-empty-state">
            <i class="fa-solid fa-box-open orders-empty-icon"></i>
            <h4 class="mb-2 text-navy fw-bold">No orders placed yet</h4>
            <p class="mb-4 text-muted">Looks like you haven't made your first purchase. Check out our latest tech!</p>
            <a href="{{ route('home') }}" class="px-5 py-3 text-white shadow-sm btn fw-bold text-uppercase rounded-3" style="background-color: #1E3A5F; letter-spacing: 1px;">
                Start Shopping
            </a>
        </div>
    @else
        <div class="row g-4">
            @foreach($orders as $order)
                @php
                    $itemsCount = $itemsCountMap[$order->order_id] ?? 0;
                    $receipt = $receiptsMap[$order->order_id] ?? null;
                @endphp

                <div class="col-12">
                    <div class="p-4 order-card d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">

                        <div class="mb-3 order-info mb-md-0">
                            <div class="flex-wrap gap-3 mb-3 d-flex align-items-center">
                                <h5 class="mb-0 fw-bold order-id">Order #{{ $order->order_id }}</h5>

                                <span class="status-badge
                                    @switch($order->payment_status)
                                        @case('pending_verification') status-pending @break
                                        @case('paid') status-paid @break
                                        @case('completed') status-paid @break
                                        @case('rejected') status-rejected @break
                                        @default status-default
                                    @endswitch
                                ">
                                    {{ ucwords(str_replace('_', ' ', $order->payment_status)) }}
                                </span>
                            </div>

                            <div class="gap-1 text-muted d-flex flex-column" style="font-size: 0.95rem;">
                                <span><i class="fa-regular fa-clock order-meta-icon me-2"></i> Placed: {{ $order->created_at->format('M j, Y - H:i') }}</span>
                                <span><i class="fa-solid fa-layer-group order-meta-icon me-2"></i> Items: {{ $itemsCount }}</span>

                                @if($receipt)
                                    <span class="mt-1 text-success fw-medium">
                                        <i class="fa-solid fa-file-invoice order-meta-icon text-success me-2"></i> Receipt Uploaded
                                    </span>
                                @else
                                    <span class="mt-1 text-warning fw-medium">
                                        <i class="fa-solid fa-file-circle-exclamation order-meta-icon text-warning me-2"></i> Awaiting Receipt
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="order-action text-md-end w-100" style="max-width: 300px;">
                            <div class="mb-1 text-muted small text-uppercase fw-bold" style="letter-spacing: 0.5px;">Order Total</div>
                            <div class="mb-3 order-total">K{{ number_format($order->total_amount) }}</div>
                            <a href="{{ route('user#orderDetails', $order->order_id) }}" class="py-2 btn btn-view-order w-100">
                                View Details
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-5 d-flex justify-content-end">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@endsection
