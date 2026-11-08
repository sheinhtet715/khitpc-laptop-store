@extends('admin.layouts.master')

@section('page-title', 'Edit Payment Method')
@section('page-subtitle', 'Update Account Details')

@section('content')

<style>
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

    .card-header-navy {
        background: linear-gradient(135deg, #1E3A5F 0%, #152842 100%);
        color: white;
    }
</style>

<div class="py-4 container-fluid">

    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-7">

            <div class="mb-3">
                <a href="{{ route('payment#list') }}" class="px-3 border shadow-sm btn btn-light text-navy fw-bold btn-sm transition-hover">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back to Payments
                </a>
            </div>

            <div class="overflow-hidden admin-card">

                <div class="p-4 card-header-navy d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 text-white fw-bold"><i class="fa-solid fa-wallet me-2 text-gold"></i> Update Account</h4>
                        <div class="small" style="color: rgba(255,255,255,0.7); letter-spacing: 0.5px;">
                            ACCOUNT ID: <span class="text-white fw-bold">#{{ $paymentMethod->payment_method_id }}</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-building-columns fs-1" style="color: rgba(255,255,255,0.1);"></i>
                </div>

                <div class="p-4 card-body p-md-5">

                    <form id="paymentEditForm" action="{{ route('payment#update', $paymentMethod->payment_method_id) }}" method="post" novalidate>
                        @csrf

                        <div class="mb-4">
                            <label for="account_number" class="form-label fw-bold text-navy small text-uppercase">Account Number</label>
                            <input id="account_number" type="text" name="account_number" value="{{ old('account_number', $paymentMethod->account_number) }}"
                                class="form-control form-control-lg admin-input @error('account_number') is-invalid @enderror font-monospace"
                                placeholder="Account number..." required autocomplete="off">
                            @error('account_number')
                                <div class="mt-2 invalid-feedback fw-medium">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="account_name" class="form-label fw-bold text-navy small text-uppercase">Account Holder Name</label>
                            <input id="account_name" type="text" name="account_name" value="{{ old('account_name', $paymentMethod->account_name) }}"
                                class="form-control form-control-lg admin-input @error('account_name') is-invalid @enderror"
                                placeholder="Account name..." required autocomplete="off">
                            @error('account_name')
                                <div class="mt-2 invalid-feedback fw-medium">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label for="account_type" class="form-label fw-bold text-navy small text-uppercase">Account Type (Platform)</label>
                            <input id="account_type" type="text" name="account_type" value="{{ old('account_type', $paymentMethod->account_type) }}"
                                class="form-control form-control-lg admin-input @error('account_type') is-invalid @enderror"
                                placeholder="e.g. KPay, KBZ..." required autocomplete="off">
                            @error('account_type')
                                <div class="mt-2 invalid-feedback fw-medium">{{ $message }}</div>
                            @enderror
                            <div class="mt-2 form-text text-muted"><i class="fa-solid fa-circle-info me-1"></i> This is the label customers will see at checkout.</div>
                        </div>

                        <div class="gap-3 pt-4 d-flex border-top" style="border-color: rgba(30,58,95,0.08) !important;">
                            <button type="button" id="btnUpdate" class="px-5 py-2 btn btn-admin-primary fw-bold text-uppercase" style="letter-spacing: 0.5px;">
                                <i class="fa-solid fa-floppy-disk me-2"></i> Save Changes
                            </button>
                            <a href="{{ route('payment#list') }}" class="px-4 py-2 border btn btn-light fw-bold text-muted">Cancel</a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="border-0 shadow modal-content" style="border-radius: 16px;">
            <div class="pb-0 modal-header border-bottom-0">
                <h5 class="modal-title fw-bold text-navy"><i class="fa-solid fa-triangle-exclamation text-gold me-2"></i> Confirm Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="py-4 modal-body">
                <p class="mb-0 text-dark fw-medium fs-5">Save changes to this payment method?</p>
                <p class="mt-2 text-muted">Ensure these details are correct, as customers will use this to send you money.</p>
            </div>
            <div class="pt-0 modal-footer border-top-0">
                <button type="button" class="border btn btn-light fw-bold text-muted" data-bs-dismiss="modal">Cancel</button>
                <button id="confirmSubmit" type="button" class="px-4 btn btn-admin-primary fw-bold">Yes, Update Account</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js-script')
<script>
    (function () {
        const btn = document.getElementById('btnUpdate');
        const confirmModalEl = document.getElementById('confirmModal');
        let confirmModal = null;

        if (confirmModalEl) {
            confirmModal = new bootstrap.Modal(confirmModalEl);
        }

        if (btn && confirmModal) {
            btn.addEventListener('click', () => {
                confirmModal.show();
            });

            document.getElementById('confirmSubmit').addEventListener('click', () => {
                document.getElementById('paymentEditForm').submit();
            });
        }

        window.addEventListener('load', () => {
            const el = document.getElementById('account_number');
            if (el) el.focus();
        });
    })();
</script>
@endsection
