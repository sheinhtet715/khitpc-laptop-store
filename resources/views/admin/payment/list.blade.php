@extends('admin.layouts.master')

@section('page-title', 'Payment Methods')
@section('page-subtitle', 'Manage Platform Accounts')

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
            color: #1E3A5F;
        }
    </style>

    <div class="container-fluid">

        <div class="mb-4 d-sm-flex align-items-center justify-content-between">
            <h3 class="mb-0 fw-bold text-navy text-uppercase" style="letter-spacing: 0.5px;">Linked Accounts</h3>

            <div class="d-lg-none">
                <button class="btn btn-admin-primary" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#createPaymentOffcanvas">
                    <i class="fa-solid fa-plus me-2"></i> Add Account
                </button>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-4 border-0 shadow-sm alert alert-success fw-medium rounded-3">
                <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="row g-4 align-items-start">

            <div class="col-lg-4 d-none d-lg-block">
                <div class="admin-card h-100">
                    <div class="p-4 card-body">

                        <h5 class="pb-3 mb-4 fw-bold text-navy border-bottom"
                            style="border-color: rgba(30,58,95,0.1) !important;">
                            <i class="fa-solid fa-building-columns me-2 text-gold"></i> Add Payment Method
                        </h5>

                        <form action="{{ route('payment#create') }}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label for="account_number"
                                    class="form-label fw-bold text-muted small text-uppercase">Account Number</label>
                                <input id="account_number" type="text" name="account_number"
                                    value="{{ old('account_number') }}"
                                    class="form-control admin-input @error('account_number') is-invalid @enderror"
                                    placeholder="e.g. 09123456789" autocomplete="off" required>
                                @error('account_number')
                                    <div class="mt-1 invalid-feedback fw-medium">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="account_name" class="form-label fw-bold text-muted small text-uppercase">Account
                                    Holder Name</label>
                                <input id="account_name" type="text" name="account_name"
                                    value="{{ old('account_name') }}"
                                    class="form-control admin-input @error('account_name') is-invalid @enderror"
                                    placeholder="e.g. Mg Mg" autocomplete="off" required>
                                @error('account_name')
                                    <div class="mt-1 invalid-feedback fw-medium">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="account_type" class="form-label fw-bold text-muted small text-uppercase">Account
                                    Type</label>
                                <input id="account_type" type="text" name="account_type"
                                    value="{{ old('account_type') }}"
                                    class="form-control admin-input @error('account_type') is-invalid @enderror"
                                    placeholder="e.g. KPay, WavePay, KBZ Bank" autocomplete="off" required>
                                @error('account_type')
                                    <div class="mt-1 invalid-feedback fw-medium">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="py-2 btn btn-admin-primary w-100 fw-bold text-uppercase"
                                style="letter-spacing: 1px;">
                                Create Account
                            </button>
                        </form>

                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-8">
                <div class="admin-card">
                    <div class="p-4 card-body">

                        <div
                            class="gap-3 mb-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                            <div class="d-flex align-items-center fw-bold text-muted text-uppercase small"
                                style="letter-spacing: 0.5px;">
                                Active Methods:
                                <span class="px-2 py-1 text-white shadow-sm ms-2 rounded-2"
                                    style="background-color: #1E3A5F; font-size: 0.85rem; line-height: 1;">
                                    {{ $paymentMethods->total() ?? 0 }}
                                </span>
                            </div>

                            <form method="get" action="{{ route('payment#list') }}" class="d-flex">
                                <div class="input-group">
                                    <input name="searchKey" class="form-control admin-input"
                                        value="{{ request('searchKey') }}" type="search" placeholder="Search accounts...">
                                    <button class="px-3 btn btn-admin-primary" type="submit"><i
                                            class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table class="table mb-0 align-middle admin-table table-hover">
                                <thead>
                                    <tr>
                                        <th class="py-3 rounded-start">ID</th>
                                        <th class="py-3">Account Number</th>
                                        <th class="py-3">Account Name</th>
                                        <th class="py-3">Platform</th>
                                        <th class="py-3 text-end rounded-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($paymentMethods as $item)
                                        <tr>
                                            <td class="py-3 text-muted">#{{ $item->payment_method_id }}</td>
                                            <td class="py-3 fw-bold text-navy font-monospace">{{ $item->account_number }}
                                            </td>
                                            <td class="py-3">{{ $item->account_name }}</td>
                                            <td class="py-3">
                                                <span class="px-2 py-1 border shadow-sm rounded-2 fw-bold"
                                                    style="background-color: #f8fafc; color: #1E3A5F; font-size: 0.85rem;">
                                                    {{ $item->account_type }}
                                                </span>
                                            </td>
                                            <td class="py-3 text-end text-nowrap">
                                                <a href="{{ route('payment#edit', $item->payment_method_id) }}"
                                                    class="border btn btn-sm btn-light me-1 text-navy" title="Edit">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <button type="button"
                                                    onclick="deleteProcess({{ $item->payment_method_id }})"
                                                    class="border btn btn-sm btn-light text-danger" title="Delete">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-5 text-center text-muted">
                                                <i class="mb-3 opacity-50 fa-solid fa-wallet fs-2"></i>
                                                <div class="fw-medium">No payment methods found. Add your first account!
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($paymentMethods->hasPages())
                            <div class="mt-4 d-flex justify-content-end">
                                {{ $paymentMethods->appends(request()->query())->links('pagination::bootstrap-5') }}
                            </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="createPaymentOffcanvas"
        style="height: auto; border-radius: 20px 20px 0 0;">
        <div class="border-bottom offcanvas-header">
            <h5 class="offcanvas-title fw-bold text-navy"><i class="fa-solid fa-building-columns me-2 text-gold"></i> Add
                Account</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="p-4 offcanvas-body">
            <form action="{{ route('payment#create') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold text-muted small text-uppercase">Account Number</label>
                    <input type="text" name="account_number" value="{{ old('account_number') }}"
                        class="form-control admin-input" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-muted small text-uppercase">Account Name</label>
                    <input type="text" name="account_name" value="{{ old('account_name') }}"
                        class="form-control admin-input" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold text-muted small text-uppercase">Account Type</label>
                    <input type="text" name="account_type" value="{{ old('account_type') }}"
                        class="form-control admin-input" required>
                </div>

                <button type="submit" class="py-3 btn btn-admin-primary w-100 fw-bold text-uppercase"
                    style="letter-spacing: 1px;">
                    Create Account
                </button>
            </form>
        </div>
    </div>

@endsection

@section('js-script')
    <script>
        function deleteProcess(id) {
            Swal.fire({
                title: "Delete Payment Method?",
                text: "This account will be removed from checkout options.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#D32F2F", 
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/admin/payment/delete/' + id;
                }
            });
        }

        var createOffcanvasEl = document.getElementById('createPaymentOffcanvas');
        if (createOffcanvasEl) {
            createOffcanvasEl.addEventListener('shown.bs.offcanvas', function() {
                var el = createOffcanvasEl.querySelector('input[name="account_number"]');
                if (el) el.focus();
            });
        }
    </script>
@endsection
