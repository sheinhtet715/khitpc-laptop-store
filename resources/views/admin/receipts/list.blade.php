@extends('admin.layouts.master')

@section('page-title', 'Pending Receipts')
@section('page-subtitle', 'Awaiting Verification')

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
</style>

<div class="py-4 container-fluid">

    <div class="gap-3 mb-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
        <div class="d-flex align-items-center fw-bold text-muted text-uppercase small" style="letter-spacing: 0.5px;">
            Action Required:
            <span class="px-2 py-1 text-white shadow-sm ms-2 rounded-2" style="background-color: #D32F2F; font-size: 0.85rem; line-height: 1;">
                {{ $receipts->total() ?? 0 }}
            </span>
        </div>

        <div>
            <a href="{{ route('orders#list') }}" class="border shadow-sm btn btn-light fw-bold text-navy">
                <i class="fa-solid fa-list me-2 text-gold"></i> Back to All Orders
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 border-0 shadow-sm alert alert-success fw-medium rounded-3">
            <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="admin-card">
        <div class="p-0 card-body">
            @if($receipts->isEmpty())
                <div class="py-5 text-center text-muted">
                    <i class="mb-3 opacity-50 fa-solid fa-check-double fa-3x text-success"></i>
                    <h5 class="fw-bold text-navy">All caught up!</h5>
                    <p>There are no receipts currently waiting for verification.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table mb-0 align-middle admin-table table-hover">
                        <thead>
                            <tr>
                                <th class="px-4 py-3">Receipt</th>
                                <th class="py-3">Order Info</th>
                                <th class="py-3">Amount</th>
                                <th class="py-3">Payment Method</th>
                                <th class="py-3">Discount</th>
                                <th class="py-3">Preview</th>
                                <th class="px-4 py-3 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($receipts as $r)
                                <tr>
                                    <td class="px-4 py-3 fw-bold text-navy font-monospace">#{{ $r->receipt_id }}<br>
                                        <span class="text-muted small fw-normal"><i class="fa-regular fa-clock me-1"></i>{{ $r->created_at ? $r->created_at->format('j M, H:i') : '—' }}</span>
                                    </td>

                                    <td class="py-3">
                                        <div class="fw-bold text-dark">Order #{{ $r->order_id }}</div>
                                        <div class="small text-muted">{{ optional($r->order->user)->name ?? '—' }}</div>
                                        <div class="small text-muted" style="font-size: 0.7rem;">{{ optional($r->order->user)->email ?? '—' }}</div>
                                    </td>

                                    <td class="py-3 fw-bolder text-danger">K{{ number_format($r->amount) }}</td>

                                    <td class="py-3">
                                        @if(optional($r->paymentMethod)->account_name)
                                            <div class="fw-bold">{{ $r->paymentMethod->account_name }}</div>
                                            <span class="px-2 py-1 mt-1 border badge bg-light text-navy" style="background-color: #f8fafc; color: #1E3A5F; font-size: 0.85rem;">{{ $r->paymentMethod->account_type }}</span>
                                        @else
                                            <span class="px-2 py-1 border badge bg-light text-muted" style="background-color: #f8fafc; color: #1E3A5F; font-size: 0.85rem;">{{ $r->payment_method ?? 'Unknown' }}</span>
                                        @endif
                                    </td>

                                    <td class="py-3">
                                        @if(optional($r->discountCode)->code || $r->discount_code)
                                            <span class="px-2 py-1 border border-opacity-25 badge bg-success bg-opacity-10 text-success border-success">
                                                <i class="fa-solid fa-tag me-1"></i> {{ optional($r->discountCode)->code ?? $r->discount_code }}
                                            </span>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>

                                    <td class="py-3">
                                        @if($r->paymentImages && $r->paymentImages->isNotEmpty())
                                            @php $firstImg = $r->paymentImages->first(); @endphp
                                            <a href="{{ asset('payment_images/'.$firstImg->payimages) }}" target="_blank" class="position-relative d-inline-block transition-hover">
                                                <img src="{{ asset('payment_images/'.$firstImg->payimages) }}" alt="Preview" class="border shadow-sm rounded-2" style="width:60px;height:45px;object-fit:cover;">
                                                @if($r->paymentImages->count() > 1)
                                                    <span class="top-0 border border-white position-absolute start-100 translate-middle badge rounded-pill bg-dark">
                                                        +{{ $r->paymentImages->count() - 1 }}
                                                    </span>
                                                @endif
                                            </a>
                                        @else
                                            <span class="px-2 py-1 border rounded text-muted small bg-light"><i class="fa-solid fa-image-slash"></i></span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 text-end">
                                        <a href="{{ route('receipts#show', $r->receipt_id) }}" class="shadow-sm btn btn-sm btn-admin-primary fw-bold">
                                            Verify <i class="fa-solid fa-arrow-right ms-1 small"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($receipts->hasPages())
                    <div class="p-4 d-flex justify-content-end border-top">
                        {{ $receipts->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
