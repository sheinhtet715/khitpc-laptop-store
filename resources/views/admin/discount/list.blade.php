@extends('admin.layouts.master')

@section('page-title', 'Discount Codes')
@section('page-subtitle', 'Manage Promotions & Offers')

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

 
    .admin-input:focus {
        border-color: #FFBF00;
        box-shadow: 0 0 0 3px rgba(255, 191, 0, 0.15);
    }
    .btn-admin-primary {
        background-color: #1E3A5F;
        color: white;
        transition: all 0.2s ease;
    }
    .btn-admin-primary:hover {
		background-color: #FFBF00;
		color: #1E3A5F; }


    .sticky-form-col {
        position: -webkit-sticky;
        position: sticky;
        top: 90px;
        z-index: 10;
    }
</style>

<div class="container-fluid">

    <div class="mb-4 d-sm-flex align-items-center justify-content-between d-lg-none">
        <h3 class="mb-0 fw-bold text-navy text-uppercase" style="letter-spacing: 0.5px;">Discount Codes</h3>
        <button class="btn btn-admin-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#createDiscountOffcanvas">
            <i class="fa-solid fa-plus me-2"></i> Add Code
        </button>
    </div>

    <div class="row g-4 align-items-start">

        <div class="col-lg-4 d-none d-lg-block sticky-form-col">
            <div class="admin-card">
                <div class="p-4 card-body">

                    <h5 class="pb-3 mb-4 fw-bold text-navy border-bottom" style="border-color: rgba(30,58,95,0.1) !important;">
                        <i class="fa-solid fa-ticket me-2 text-gold"></i> Create Discount
                    </h5>

                    <form action="{{ route('discount#create') }}" method="post">
                        @csrf

                        <div class="mb-3">
                            <label for="code" class="form-label fw-bold text-muted small text-uppercase">Discount Code</label>
                            <input id="code" type="text" name="code" value="{{ old('code') }}"
                                class="form-control admin-input font-monospace text-uppercase @error('code') is-invalid @enderror"
                                placeholder="e.g. SUMMER2024" autocomplete="off" required>
                            @error('code')
                                <div class="mt-1 invalid-feedback fw-medium">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="discount_percent" class="form-label fw-bold text-muted small text-uppercase">Discount Percent (%)</label>
                            <input id="discount_percent" type="number" name="discount_percent" value="{{ old('discount_percent') }}"
                                class="form-control admin-input @error('discount_percent') is-invalid @enderror"
                                placeholder="e.g. 15" autocomplete="off" min="0" max="100" required
                                oninput="if(this.value < 0) this.value = Math.abs(this.value)">
                            @error('discount_percent')
                                <div class="mt-1 invalid-feedback fw-medium">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="usage_limit" class="form-label fw-bold text-muted small text-uppercase">Usage Limit</label>
                            <input id="usage_limit" type="number" name="usage_limit" value="{{ old('usage_limit') }}"
                                class="form-control admin-input @error('usage_limit') is-invalid @enderror"
                                placeholder="e.g. 100" autocomplete="off" min="1" required
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            @error('usage_limit')
                                <div class="mt-1 invalid-feedback fw-medium">{{ $message }}</div>
                            @enderror
                            <div class="mt-1 form-text text-muted small">Total number of times this code can be used.</div>
                        </div>

                        <button type="submit" class="py-2 btn btn-admin-primary w-100 fw-bold text-uppercase" style="letter-spacing: 1px;">
                            Create Code
                        </button>
                    </form>

                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="admin-card">
                <div class="p-4 card-body">

                    <div class="gap-3 mb-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                        <div class="d-flex align-items-center fw-bold text-muted text-uppercase small" style="letter-spacing: 0.5px;">
                            Total Codes:
                            <span class="px-2 py-1 text-white shadow-sm ms-2 rounded-2" style="background-color: #1E3A5F; font-size: 0.85rem; line-height: 1;">
                                {{ $discounts->total() ?? 0 }}
                            </span>
                        </div>

                        <form method="get" action="{{ route('discount#list') }}" class="d-flex">
                            <div class="input-group">
                                <input name="searchKey" class="form-control admin-input" value="{{ request('searchKey') }}" type="search" placeholder="Search codes...">
                                <button class="px-3 btn btn-admin-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table mb-0 align-middle admin-table table-hover">
                            <thead>
                                <tr>
                                    <th class="py-3 rounded-start">Code</th>
                                    <th class="py-3">Discount</th>
                                    <th class="py-3">Limit</th>
                                    <th class="py-3">Created Date</th>
                                    <th class="py-3 text-end rounded-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($discounts as $item)
                                    <tr>
                                        <td class="py-3 fw-bold text-navy font-monospace">{{ $item->code }}</td>
                                        <td class="py-3 fw-bold text-danger">{{ $item->discount_percent }}%</td>
                                        <td class="py-3">
                                            <span class="px-2 py-1 border badge bg-light text-dark">{{ $item->usage_limit }} Uses</span>
                                        </td>
                                        <td class="py-3 text-muted small"><i class="fa-regular fa-calendar me-2 text-gold"></i>{{ $item->created_at?->format('j M Y') }}</td>
                                        <td class="py-3 text-end text-nowrap">
                                            <a href="{{ route('discount#edit', $item->discount_code_id) }}" class="border btn btn-sm btn-light me-1 text-navy" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <button type="button" onclick="deleteProcess({{ $item->discount_code_id }})" class="border btn btn-sm btn-light text-danger" title="Delete">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-5 text-center text-muted">
                                            <i class="mb-3 opacity-50 fa-solid fa-ticket-simple fs-2"></i>
                                            <div class="fw-medium">No discount codes found. Create your first promotion!</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($discounts->hasPages())
                        <div class="mt-4 d-flex justify-content-end">
                            {{ $discounts->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>

    </div>
</div>

<div class="offcanvas offcanvas-bottom" tabindex="-1" id="createDiscountOffcanvas" style="height: auto; border-radius: 20px 20px 0 0;">
    <div class="border-bottom offcanvas-header">
        <h5 class="offcanvas-title fw-bold text-navy"><i class="fa-solid fa-ticket me-2 text-gold"></i> Create Discount</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="p-4 offcanvas-body">
        <form action="{{ route('discount#create') }}" method="post">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold text-muted small text-uppercase">Discount Code</label>
                <input type="text" name="code" value="{{ old('code') }}" class="form-control admin-input font-monospace text-uppercase" placeholder="SUMMER2024" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold text-muted small text-uppercase">Discount Percent (%)</label>
                <input type="number" name="discount_percent" value="{{ old('discount_percent') }}" class="form-control admin-input" placeholder="15" min="0" max="100" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold text-muted small text-uppercase">Usage Limit</label>
                <input type="number" name="usage_limit" value="{{ old('usage_limit') }}" class="form-control admin-input" placeholder="100" min="1" required>
            </div>

            <button type="submit" class="py-3 btn btn-admin-primary w-100 fw-bold text-uppercase" style="letter-spacing: 1px;">
                Create Code
            </button>
        </form>
    </div>
</div>

@endsection
@section('js-script')
<script>
    function deleteProcess(id){
        Swal.fire({
            title: "Delete Discount Code?",
            text: "Customers will no longer be able to use this code at checkout.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#D32F2F", 
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/admin/discount/delete/' + id;
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        var createOffcanvasEl = document.getElementById('createDiscountOffcanvas');

        if (createOffcanvasEl) {
            createOffcanvasEl.addEventListener('shown.bs.offcanvas', function () {
                var el = createOffcanvasEl.querySelector('input[name="code"]');
                if (el) el.focus();
            });
        }

        @if($errors->any())
            if (window.innerWidth < 992 && createOffcanvasEl) {
                var bsOffcanvas = new bootstrap.Offcanvas(createOffcanvasEl);
                bsOffcanvas.show();
            }
        @endif
    });
</script>
@endsection
