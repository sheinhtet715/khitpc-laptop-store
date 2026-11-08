@extends('admin.layouts.master')

@section('page-title', 'Overview')
@section('page-subtitle', 'Welcome to your Khit PC Command Center')

@section('content')

<style>

    .dash-card {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .dash-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.02);
    }

    .icon-box {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .icon-box-red {
		background-color: #fee2e2;
		color: #ef4444;
	}
    .icon-box-blue { 
		background-color: #e0e7ff; 
		color: #3b82f6;
	}
    .icon-box-amber { 
		background-color: #fef3c7; 
		color: #f59e0b; 
	}


    .dash-table th {
        background-color: #f8fafc !important;
        color: #64748b !important;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        font-size: 0.7rem;
        border-bottom: 2px solid #e2e8f0;
        padding: 0.6rem 1rem; 
    }
    .dash-table td {
        vertical-align: middle;
        color: #334155;
        font-weight: 500;
        border-bottom: 1px solid #f1f5f9;
        padding: 0.6rem 1rem; 
        font-size: 0.85rem; 
    }
    .dash-table tbody tr:hover {
		background-color: #f8fafc; 
	}

    .status-badge {
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.6rem;
        text-transform: uppercase;
    }
    .badge-pending {
		background-color: #fffbeb;
		color: #b45309;
		border: 1px solid #fde68a;
	}
    .badge-paid { 
		background-color: #ecfdf5;
		color: #047857;
		border: 1px solid #a7f3d0;
	}
    .badge-rejected {
		background-color: #fef2f2; 
		color: #be123c; 
		border: 1px solid #fecaca;
	}


    .quick-action-btn {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        color: #1E3A5F;
        border-radius: 10px;
        transition: all 0.2s;
    }
    .quick-action-btn:hover {
        border-color: #cbd5e1;
        background-color: #f8fafc;
        color: #FFBF00;
        transform: translateY(-1px);
    }
</style>

<main class="py-2 container-fluid">

    <div class="mb-4 row g-4">

        <div class="col-12 col-md-6 col-xl-4">
            <div class="p-4 dash-card h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="mb-2 text-muted fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Pending Orders</div>
                        <div class="text-dark fw-bolder" style="font-size: 2.2rem; line-height: 1;">
                            {{ number_format($ordersCount ?? 0) }}
                        </div>
                    </div>
                    <div class="icon-box icon-box-red">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <div class="p-4 dash-card h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="mb-2 text-muted fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Total Products</div>
                        <div class="text-dark fw-bolder" style="font-size: 2.2rem; line-height: 1;">
                            {{ number_format($productsCount ?? 0) }}
                        </div>
                    </div>
                    <div class="icon-box icon-box-blue">
                        <i class="fa-solid fa-laptop"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <div class="p-4 dash-card h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="mb-2 text-muted fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Customers</div>
                        <div class="text-dark fw-bolder" style="font-size: 2.2rem; line-height: 1;">
                            {{ number_format($customersCount ?? 0) }}
                        </div>
                    </div>
                    <div class="icon-box icon-box-amber">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-4 align-items-start"> <div class="col-xl-8 col-lg-7">
            <div class="overflow-hidden dash-card d-flex flex-column">
                <div class="p-4 bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bolder text-dark" style="font-size: 1rem;">
                        Recent Orders
                    </h6>
                    </div>

                <div class="p-0 card-body flex-grow-1">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle dash-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($recentOrders) && $recentOrders->isNotEmpty())
                                    @foreach($recentOrders as $order)
                                        <tr>
                                            <td class="fw-bold text-dark font-monospace">#{{ $order->order_id }}</td>
                                            <td>{{ optional($order->user)->name ?? 'Unknown User' }}</td>
                                            <td class="fw-bold text-dark">K{{ number_format($order->total_amount) }}</td>
                                            <td>
                                                <span class="status-badge
                                                    @if($order->payment_status == 'paid') badge-paid
                                                    @elseif($order->payment_status == 'rejected') badge-rejected
                                                    @else badge-pending @endif">
                                                    {{ ucwords(str_replace('_',' ',$order->payment_status)) }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('orders#show', $order->order_id) }}" class="border shadow-sm btn btn-sm btn-white text-muted fw-bold rounded-2">Review</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="py-5 text-center text-muted">
                                            <i class="mb-2 opacity-25 fa-solid fa-inbox fs-3 d-block"></i>
                                            No recent orders found
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="p-3 text-center bg-light border-top w-100">
                    <a href="{{ route('receipts#list') }}" class="text-muted text-decoration-none small fw-bold hover-text-primary transition-hover">
                        View all complete order history <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">

            <div class="mb-4 overflow-hidden dash-card">
                <div class="p-4 bg-white border-bottom">
                    <h6 class="m-0 fw-bolder text-dark" style="font-size: 1rem;">Quick Actions</h6>
                </div>
                <div class="p-3 bg-white card-body">
                    <div class="gap-2 d-grid">
                        <a href="{{ route('product#list') }}" class="p-3 shadow-sm text-start fw-bold quick-action-btn text-decoration-none d-flex align-items-center">
                            <div class="icon-box-blue rounded-2 d-flex justify-content-center align-items-center me-3" style="width: 36px; height: 36px;">
                                <i class="fa-solid fa-laptop fs-6"></i>
                            </div>
                            Manage Inventory
                        </a>
                        <a href="{{ route('discount#list') }}" class="p-3 shadow-sm text-start fw-bold quick-action-btn text-decoration-none d-flex align-items-center">
                            <div class="icon-box-amber rounded-2 d-flex justify-content-center align-items-center me-3" style="width: 36px; height: 36px;">
                                <i class="fa-solid fa-ticket fs-6"></i>
                            </div>
                            Create Promo Code
                        </a>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden dash-card">
                <div class="p-4 bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bolder text-dark d-flex align-items-center" style="font-size: 1rem;">
                        <span class="d-inline-block bg-danger rounded-circle me-2" style="width: 8px; height: 8px;"></span>
                        Low Stock Alert
                    </h6>
                    <span class="border badge bg-danger bg-opacity-10 text-danger border-danger rounded-pill fw-bold">{{ isset($lowStockProducts) ? $lowStockProducts->count() : 0 }}</span>
                </div>
                <div class="p-0 bg-white card-body" style="max-height: 280px; overflow-y: auto;">
                    @if(isset($lowStockProducts) && $lowStockProducts->isNotEmpty())
                        @foreach($lowStockProducts as $lowStock)
                            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold text-dark text-truncate" style="max-width: 190px; font-size: 0.9rem;">{{ $lowStock->product_name }}</div>
                                    <div class="mt-1 text-muted font-monospace" style="font-size: 0.75rem;">{{ $lowStock->sku }}</div>
                                </div>
                                <div>
                                    <span class="px-2 py-1 text-white badge bg-danger rounded-2" style="font-size: 0.75rem;">Qty: {{ $lowStock->stock_quantity }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="p-5 text-center text-muted small">
                            <i class="mb-2 opacity-50 fa-solid fa-check-circle text-success fs-3 d-block"></i>
                            All inventory levels look healthy.
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

</main>

@endsection
