@extends('user.layouts.master')

@section('content')

<style>

    .order-detail-container {
        min-height: 70vh; 
    }

    .detail-card {
        background-color: #ffffff;
        border: 1px solid rgba(30, 58, 95, 0.08);
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(30, 58, 95, 0.02);
        padding: 2rem;
    }

    .text-navy { color: #1E3A5F !important; }
    .text-red { color: #D32F2F !important; }

    .back-btn {
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: color 0.2s ease;
    }
    .back-btn:hover { color: #1E3A5F; }


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
		color: #b38600; 
		border: 1px solid rgba(255, 191, 0, 0.3); 
	}
    .status-paid { 
		background-color: rgba(16, 185, 129, 0.1); 
		color: #10b981; 
		border: 1px solid rgba(16, 185, 129, 0.3);
	}
    .status-rejected { 
		background-color: rgba(211, 47, 47, 0.1); 
		color: #D32F2F; 
		border: 1px solid rgba(211, 47, 47, 0.3); 
	}
    .status-default { 
		background-color: rgba(108, 117, 125, 0.1); 
		color: #6c757d;
		border: 1px solid rgba(108, 117, 125, 0.3); 
	}

    .item-row {
        padding-bottom: 1.5rem;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid rgba(30, 58, 95, 0.05);
    }
    .item-row:last-child {
        padding-bottom: 0;
        margin-bottom: 0;
        border-bottom: none;
    }

    .item-img-wrapper {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid rgba(30, 58, 95, 0.05);
        border-radius: 10px;
        padding: 0.5rem;
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .item-img-wrapper img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }

    .sticky-summary {
        position: -webkit-sticky;
        position: sticky;
        top: 120px;
        z-index: 10;
    }

    .receipt-img {
        border-radius: 8px;
        border: 1px solid rgba(30, 58, 95, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .receipt-img:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 20px rgba(30, 58, 95, 0.1);
    }

    .receipt-scroll-container {
        max-height: 400px;
        overflow-y: auto;
        padding-right: 8px;
        margin-bottom: 10px;
    }
    
    .receipt-scroll-container::-webkit-scrollbar {
        width: 6px;
    }
    .receipt-scroll-container::-webkit-scrollbar-track {
        background: rgba(30, 58, 95, 0.03);
        border-radius: 10px;
    }
    .receipt-scroll-container::-webkit-scrollbar-thumb {
        background: rgba(30, 58, 95, 0.15);
        border-radius: 10px;
    }
    .receipt-scroll-container::-webkit-scrollbar-thumb:hover {
        background: #1E3A5F;
    }
</style>

<div class="container my-5 order-detail-container">

    <a href="{{ route('user#orders') }}" class="p-0 mb-4 btn btn-link text-decoration-none back-btn">
        <i class="fa-solid fa-arrow-left me-2"></i> Back to Orders
    </a>

    <div class="row g-5 align-items-start">

        <div class="col-lg-8">
            <div class="detail-card">

                <div class="pb-4 mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center border-bottom" style="border-color: rgba(30,58,95,0.08) !important;">
                    <div>
                        <h4 class="mb-1 fw-bold text-navy">Order #{{ $order->order_id }}</h4>
                        <div class="text-muted small fw-medium">
                            <i class="fa-regular fa-clock me-1 text-gold"></i> Placed: {{ $order->created_at->format('M j, Y - H:i') }}
                        </div>
                    </div>

                    <div class="mt-3 mt-md-0">
                        <span class="status-badge
                            @switch($order->payment_status)
                                @case('pending_verification') status-pending @break
                                @case('paid') status-paid @break
                                @case('completed') status-paid @break
                                @case('rejected') status-rejected @break
                                @default status-default
                            @endswitch
                        ">
                            {{ ucwords(str_replace('_',' ',$order->payment_status)) }}
                        </span>
                    </div>
                </div>

                <h6 class="mb-4 fw-bold text-uppercase text-muted" style="letter-spacing: 1px;">Purchased Items</h6>

                @forelse($orderItems as $it)
                    <div class="item-row d-flex align-items-center">
                        <div class="flex-shrink-0 item-img-wrapper me-4">
                            <img src="{{ $it->product_image ? asset('productImage/'.$it->product_image) : asset('default/default_image.webp') }}" alt="{{ $it->product_name }}">
                        </div>

                        <div class="flex-grow-1">
                            <a href="{{ route('user#productDetails', $it->product_id) }}" class="text-decoration-none">
                                <h6 class="mb-1 fw-bold text-navy">{{ $it->product_name }}</h6>
                            </a>
                            <div class="flex-wrap gap-3 mt-2 d-flex align-items-center">
                                <div class="text-muted small">
                                    <span class="text-uppercase fw-bold" style="font-size: 0.7rem;">Unit Price:</span>
                                    K{{ number_format($it->product_price) }}
                                </div>
                                <div class="text-muted small">
                                    <span class="text-uppercase fw-bold" style="font-size: 0.7rem;">Qty:</span>
                                    <span class="px-2 py-1 border badge bg-light text-dark">{{ intval($it->boughtquantity ?? $it->quantity ?? 1) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="text-end ms-3">
                            <div class="fw-bold text-dark">
                                K{{ number_format($it->product_price * intval($it->boughtquantity ?? $it->quantity ?? 1)) }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-5 text-center">
                        <i class="mb-3 opacity-25 fa-solid fa-box-open fs-1 text-muted"></i>
                        <div class="text-muted fw-medium">No items found for this order.</div>
                    </div>
                @endforelse

            </div>
        </div>

        <div class="col-lg-4">
            <div class="sticky-summary">

                <div class="mb-4 detail-card">
                    <h6 class="mb-4 fw-bold text-uppercase text-muted" style="letter-spacing: 1px;">Order Summary</h6>

                    <div class="mb-3 d-flex justify-content-between text-muted fw-medium">
                        <div>Subtotal</div>
                        <div>K{{ number_format($order->total_amount) }}</div>
                    </div>

                    <hr style="border-color: rgba(30,58,95,0.1);">

                    <div class="mt-3 d-flex justify-content-between align-items-end">
                        <div class="fw-bold text-navy text-uppercase" style="letter-spacing: 0.5px;">Total</div>
                        <div class="fs-4 fw-bold text-red">K{{ number_format($order->total_amount) }}</div>
                    </div>
                </div>

             <div class="p-4 detail-card">
                    <h6 class="mb-3 fw-bold text-uppercase text-muted" style="letter-spacing: 1px;">Payment Receipt</h6>

                    @if($paymentImages && $paymentImages->isNotEmpty())
                        <div class="receipt-scroll-container">
                            <div class="gap-3 d-flex flex-column">
                                @foreach($paymentImages as $img)
                                    <a href="{{ asset('payment_images/' . $img->payimages) }}" target="_blank" rel="noopener" class="text-center d-block">
                                        <img src="{{ asset('payment_images/' . $img->payimages) }}" alt="Receipt" class="receipt-img img-fluid w-100">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        @if($receipt)
                            <div class="p-2 mt-2 text-center border bg-light rounded-2">
                                <span class="text-muted small text-uppercase fw-bold">Verified Amount:</span><br>
                                <span class="fw-bold text-success">K{{ number_format($receipt->amount) }}</span>
                            </div>
                        @endif

                    @elseif($receipt && isset($receipt->payment_image) && $receipt->payment_image)
                        {{-- Backward compatibility --}}
                        <div class="receipt-scroll-container">
                            <a href="{{ asset('payment_images/' . $receipt->payment_image) }}" target="_blank" rel="noopener" class="text-center d-block">
                                <img src="{{ asset('payment_images/' . $receipt->payment_image) }}" alt="Receipt" class="receipt-img img-fluid w-100">
                            </a>
                        </div>
                        <div class="p-2 mt-2 text-center border bg-light rounded-2">
                            <span class="text-muted small text-uppercase fw-bold">Verified Amount:</span><br>
                            <span class="fw-bold text-success">K{{ number_format($receipt->amount) }}</span>
                        </div>
                    @else
                        <div class="py-4 text-center border border-dashed bg-light rounded-3">
                            <i class="mb-2 opacity-25 fa-solid fa-file-invoice fs-2 text-muted"></i>
                            <div class="text-muted small fw-medium">No receipt uploaded</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
