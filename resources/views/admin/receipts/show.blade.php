@extends('admin.layouts.master')

@section('page-title', 'Verify Payment')
@section('page-subtitle', 'Review Receipt Details')

@section('content')

<style>
	 .btn-admin-primary {
	    background-color: #1E3A5F;
	    color: white;
	    transition: all 0.2s ease;
	}
	
	.btn-admin-primary:hover {
	    background-color: #152842;
	    color: white;
	}
	
	.receipt-gallery img {
	    transition: transform 0.3s ease, box-shadow 0.3s ease;
	}
	
	.receipt-gallery img:hover {
	    transform: scale(1.02);
	    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
	    cursor: pointer;
	}
	
	.admin-input:focus {
	    border-color: #FFBF00;
	    box-shadow: 0 0 0 3px rgba(255, 191, 0, 0.15);
	}
	
	.status-badge {
	    font-weight: 700;
	    letter-spacing: 0.5px;
	    padding: 6px 12px;
	    border-radius: 6px;
	    font-size: 0.75rem;
	    text-transform: uppercase;
	}
	
	.badge-pending {
	    background-color: rgba(255, 191, 0, 0.15);
	    color: #b38600;
	    border: 1px solid rgba(255, 191, 0, 0.3);
	}
	
	.badge-paid {
	    background-color: rgba(16, 185, 129, 0.1);
	    color: #10b981;
	    border: 1px solid rgba(16, 185, 129, 0.3);
	}
	
	.badge-rejected {
	    background-color: rgba(211, 47, 47, 0.1);
	    color: #D32F2F;
	    border: 1px solid rgba(211, 47, 47, 0.3);
	}
</style>

<div class="py-4 container-fluid">

    <div class="mb-3">
        <a href="{{ route('receipts#list') }}" class="px-3 border shadow-sm btn btn-light text-navy fw-bold btn-sm transition-hover">
            <i class="fa-solid fa-arrow-left me-2"></i> Back to Pending List
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 border-0 shadow-sm alert alert-success fw-medium rounded-3">
            <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row g-4 align-items-start">

        <div class="col-lg-8">
            <div class="admin-card">
                <div class="p-4 border-bottom d-flex justify-content-between align-items-center bg-light rounded-top-3">
                    <div>
                        <h5 class="mb-1 fw-bold text-navy">Customer Uploads</h5>
                        <div class="small text-muted fw-medium text-uppercase" style="letter-spacing: 0.5px;">Receipt ID: #{{ $receipt->receipt_id }}</div>
                    </div>
                    <div class="text-muted small"><i class="fa-regular fa-clock me-1 text-gold"></i> {{ $receipt->created_at->format('j M Y, H:i') }}</div>
                </div>

                <div class="p-4 card-body receipt-gallery">
                    <div class="flex-wrap gap-4 p-4 bg-white border border-dashed d-flex justify-content-center rounded-3">
                        @forelse($receipt->paymentImages as $img)
                            <div class="text-center position-relative">
                                <a href="{{ asset('payment_images/'.$img->payimages) }}" target="_blank">
                                    <img src="{{ asset('payment_images/'.$img->payimages) }}"
                                         alt="Receipt Image"
                                         class="border shadow-sm rounded-3"
                                         style="max-width: 100%; max-height: 500px; object-fit: contain;">
                                </a>
                                <div class="mt-2 small text-muted fw-bold text-uppercase"><i class="fa-solid fa-magnifying-glass-plus me-1"></i> Click to enlarge</div>
                            </div>
                        @empty
                            <div class="py-5 text-center text-muted">
                                <i class="mb-3 opacity-25 fa-regular fa-image fa-3x"></i>
                                <h6 class="fw-bold">No images attached</h6>
                                <p class="small">The customer did not upload a screenshot.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">

            <div class="mb-4 shadow-sm admin-card">
                <div class="p-3 border-bottom bg-light rounded-top-3">
                    <h6 class="mb-0 fw-bold text-navy text-uppercase small" style="letter-spacing: 0.5px;">
                        <i class="fa-solid fa-user me-2 text-gold"></i> Customer Details
                    </h6>
                </div>
                <div class="p-4 card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 text-white shadow-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background-color: #1E3A5F;">
                            <i class="fa-solid fa-user fs-5 text-gold"></i>
                        </div>
                        <div class="overflow-hidden ms-3">
                            <h6 class="mb-0 fw-bold text-dark text-truncate">{{ $order->user->name ?? 'Unknown Customer' }}</h6>
                            <div class="small text-muted text-truncate">{{ $order->user->email ?? 'No email available' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4 admin-card">
                <div class="p-4 text-white bg-navy rounded-top-3" style="background-color: #1E3A5F;">
                    <h6 class="mb-1 fw-bold text-gold text-uppercase" style="letter-spacing: 1px;">Transaction Details</h6>
                    <div class="fs-4 fw-bold">Order #{{ $receipt->order_id }}</div>
                </div>

                <div class="p-4 card-body">
                    <div class="pb-3 mb-3 d-flex justify-content-between border-bottom">
                        <span class="text-muted fw-bold text-uppercase small">Claimed Amount:</span>
                        <span class="fw-bold text-success fs-5">K{{ number_format($receipt->amount) }}</span>
                    </div>
                    <div class="pb-3 mb-3 d-flex justify-content-between border-bottom">
                        <span class="text-muted fw-bold text-uppercase small">Order Total:</span>
                        <span class="fw-bold text-danger fs-5">K{{ number_format($order->total_amount ?? 0) }}</span>
                    </div>

                    <div class="pb-3 mb-3 d-flex justify-content-between border-bottom align-items-center">
                        <span class="text-muted fw-bold text-uppercase small">Discount Code:</span>
                        @if(optional($receipt->discountCode)->code || $receipt->discount_code)
                            <span class="px-2 py-1 border border-opacity-25 badge bg-success bg-opacity-10 text-success border-success fs-6">
                                <i class="fa-solid fa-tag me-1"></i> {{ optional($receipt->discountCode)->code ?? $receipt->discount_code }}
                            </span>
                        @else
                            <span class="text-muted small fw-medium">— None Used —</span>
                        @endif
                    </div>

                    <div class="pb-3 mb-3 d-flex justify-content-between border-bottom align-items-center">
                        <span class="text-muted fw-bold text-uppercase small">Order Status:</span>
                        <span class="status-badge
                            @switch($order->payment_status)
                                @case('pending_verification') badge-pending @break
                                @case('paid') badge-paid @break
                                @case('rejected') badge-rejected @break
                                @default badge-default
                            @endswitch
                        ">
                            {{ ucwords(str_replace('_',' ',$order->payment_status)) }}
                        </span>
                    </div>

                    @if($receipt->amount !== ($order->total_amount ?? 0))
                        <div class="mt-3 border-opacity-50 alert alert-warning border-warning bg-warning bg-opacity-10 small fw-medium">
                            <i class="fa-solid fa-triangle-exclamation me-1"></i> Warning: Claimed amount does not match the order total. (Did they use a code?)
                        </div>
                    @endif

                    <div class="pt-3 mt-4 border-top">

                        <form id="approveForm" action="{{ route('receipts#approve', $receipt->receipt_id) }}" method="POST" class="mb-4">
                            @csrf
                            <button type="button" onclick="confirmApprove()" class="py-3 shadow-sm btn btn-success w-100 fw-bold text-uppercase" style="letter-spacing: 1px;" @if($order->payment_status !== 'pending_verification') disabled @endif>
                                <i class="fa-solid fa-check-double me-2"></i> Approve Payment
                            </button>
                        </form>

                        <form id="rejectForm" action="{{ route('receipts#reject', $receipt->receipt_id) }}" method="POST" class="p-3 border border-opacity-25 rounded bg-light border-danger">
                            @csrf
                            <div class="mb-3">
                                <label for="reason" class="form-label text-danger small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Rejection Reason (Emailed to Customer)</label>
                                <textarea name="reason" id="reason" rows="2" class="border-opacity-50 form-control admin-input border-danger" placeholder="e.g., Transaction ID is not visible..." @if($order->payment_status !== 'pending_verification') disabled @endif></textarea>
                            </div>
                            <button type="button" onclick="confirmReject()" class="py-2 shadow-sm btn btn-outline-danger w-100 fw-bold text-uppercase" style="letter-spacing: 0.5px;" @if($order->payment_status !== 'pending_verification') disabled @endif>
                                <i class="fa-solid fa-xmark me-2"></i> Reject & Request Re-upload
                            </button>
                        </form>

                    </div>
                </div>
            </div>

            <div class="admin-card">
                <div class="p-3 border-bottom bg-light rounded-top-3">
                    <h6 class="mb-0 fw-bold text-navy text-uppercase small" style="letter-spacing: 0.5px;">
                        <i class="fa-solid fa-box-open me-2 text-gold"></i> Purchased Items
                    </h6>
                </div>
                <div class="p-0 card-body">
                    <table class="table mb-0 align-middle table-sm table-hover">
                        <thead class="table-light">
                            <tr>
                                <th class="px-3 py-2 text-muted small">Product</th>
                                <th class="px-3 py-2 text-end text-muted small">Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($order) && $order->orderItems->isNotEmpty())
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td class="px-3 py-3 fw-medium text-dark small">
                                            {{ optional($item->product)->product_name ?? 'Product #'.$item->product_id }}

                                            @if(optional($item->product)->offer)
                                                <div class="mt-1">
                                                    <span class="px-2 text-white badge bg-danger" style="font-size: 0.65rem;">
                                                        <i class="fa-solid fa-fire me-1"></i> {{ $item->product->offer->discount_percent }}% OFF Offer
                                                    </span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-3 py-3 text-end fw-bold">
                                            <span class="border badge bg-light text-dark">{{ number_format($item->boughtquantity) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="2" class="px-3 py-4 text-center text-muted small">No items found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('js-script')
<script>

    function confirmApprove() {
        Swal.fire({
            title: "Approve Payment?",
            text: "Are you sure? An official approval email will be sent to the customer, and this action cannot be undone.",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#10b981", // Green to match success button
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, Approve & Send Email"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('approveForm').submit();
            }
        });
    }

  
    function confirmReject() {
        Swal.fire({
            title: "Reject Payment?",
            text: "Are you sure? A rejection email will be sent to the customer immediately, and this action cannot be undone.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#D32F2F",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, Reject & Send Email"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('rejectForm').submit();
            }
        });
    }
</script>
@endsection
