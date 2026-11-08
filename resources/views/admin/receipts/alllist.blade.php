@extends('admin.layouts.master')

@section('page-title', 'All Orders')
@section('page-subtitle', 'Complete Order History')

@section('content')

<style>
 
    .admin-table th {
        background-color: #1E3A5F !important;
        color: #ffffff !important;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        font-size: 0.85rem;
        border-bottom: none;
    }
    .admin-table td {
        vertical-align: middle;
        color: #1F2937;
        font-weight: 500;
        border-bottom: 1px solid rgba(30, 58, 95, 0.05);
    }
    .admin-table tbody tr:hover {
    background-color: rgba(30, 58, 95, 0.02);
}
	
	.btn-admin-primary {
	    background-color: #1E3A5F;
	    color: white;
	    transition: all 0.2s ease;
	}
	
	.btn-admin-primary:hover {
	    background-color: #FFBF00;
	    color: #1E3A5F;
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
	
	.badge-default {
	    background-color: rgba(108, 117, 125, 0.1);
	    color: #6c757d;
	    border: 1px solid rgba(108, 117, 125, 0.3);
	}
</style>

<div class="py-4 container-fluid">

    <div class="gap-3 mb-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
        <div class="d-flex align-items-center fw-bold text-muted text-uppercase small" style="letter-spacing: 0.5px;">
            Total Orders:
            <span class="px-2 py-1 text-white shadow-sm ms-2 rounded-2" style="background-color: #1E3A5F; font-size: 0.85rem; line-height: 1;">
                {{ $orders->total() ?? 0 }}
            </span>
        </div>

        <div>
            <a href="{{ route('receipts#list') }}" class="border shadow-sm btn btn-light fw-bold text-navy">
                <i class="fa-solid fa-file-invoice-dollar me-2 text-gold"></i> View Pending Receipts
            </a>
        </div>
    </div>

    <div class="admin-card">
        <div class="p-0 card-body">
            @if($orders->isEmpty())
                <div class="py-5 text-center text-muted">
                    <i class="mb-3 opacity-50 fa-solid fa-box-open fa-3x"></i>
                    <h5 class="fw-bold text-navy">No orders found</h5>
                    <p>When customers place orders, they will appear here.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table mb-0 align-middle admin-table table-hover">
                        <thead>
                            <tr>
                                <th class="px-4 py-3">Order ID</th>
                                <th class="py-3">Customer</th>
                                <th class="py-3">Total Amount</th>
                                <th class="py-3">Status</th>
                                <th class="py-3">Receipt</th>
                                <th class="py-3">Placed On</th>
                                <th class="px-4 py-3 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $o)
                                <tr>
                                    <td class="px-4 py-3 fw-bold text-navy font-monospace">#{{ $o->order_id }}</td>

                                    <td class="py-3">
                                        <div class="fw-bold text-dark">{{ optional($o->user)->name ?? optional($o->user)->nickname ?? 'Unknown User' }}</div>
                                        <div class="small text-muted">{{ optional($o->user)->email ?? '-' }}</div>
                                        <div class="small text-muted" style="font-size: 0.7rem;">UID: {{ $o->user_id ?? '-' }}</div>
                                    </td>

                                   <td class="py-3">
                                        <div class="fw-bolder text-danger">K{{ number_format($o->total_amount) }}</div>

                                        @if($o->discount_code || optional($o->discountCode)->code)
                                            <span class="mt-1 border border-opacity-25 badge bg-success bg-opacity-10 text-success border-success" style="font-size: 0.65rem;">
                                                <i class="fa-solid fa-tag me-1"></i> {{ $o->discount_code ?? optional($o->discountCode)->code }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="py-3">
                                        <span class="status-badge
                                            @switch($o->payment_status)
                                                @case('pending_verification') badge-pending @break
                                                @case('paid') badge-paid @break
                                                @case('rejected') badge-rejected @break
                                                @default badge-default
                                            @endswitch
                                        ">
                                            {{ ucwords(str_replace('_',' ',$o->payment_status)) }}
                                        </span>
                                    </td>

                                    <td class="py-3">
                                        @if(isset($receipts[$o->order_id]) && $receipts[$o->order_id]->paymentImages->isNotEmpty())
                                            @php
                                                $firstImg = $receipts[$o->order_id]->paymentImages->first();
                                                $count = $receipts[$o->order_id]->paymentImages->count();
                                            @endphp
                                            <a href="{{ asset('payment_images/'.$firstImg->payimages) }}" target="_blank" class="position-relative d-inline-block transition-hover">
                                                <img src="{{ asset('payment_images/'.$firstImg->payimages) }}" alt="Receipt" class="border shadow-sm rounded-2" style="width:60px;height:45px;object-fit:cover;">
                                                @if($count > 1)
                                                    <span class="top-0 border border-white position-absolute start-100 translate-middle badge rounded-pill bg-danger">
                                                        +{{ $count - 1 }}
                                                    </span>
                                                @endif
                                            </a>
                                        @else
                                            <span class="px-2 py-1 border rounded text-muted small fw-medium bg-light"><i class="fa-solid fa-minus"></i></span>
                                        @endif
                                    </td>

                                    <td class="py-3 text-muted small">
                                        <i class="fa-regular fa-calendar me-1 text-gold"></i> {{ optional($o->created_at)->format('j M Y, H:i') }}
                                    </td>

                                    <td class="px-4 py-3 text-end">
                                        <a href="{{ route('orders#show', $o->order_id) }}" class="border shadow-sm btn btn-sm btn-light fw-bold text-navy">
                                            View <i class="fa-solid fa-chevron-right ms-1 small"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($orders->hasPages())
                    <div class="p-4 d-flex justify-content-end border-top">
                        {{ $orders->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

@endsection
