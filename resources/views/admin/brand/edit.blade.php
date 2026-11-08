@extends('admin.layouts.master')

@section('page-title', 'Edit Brand')
@section('page-subtitle', 'Update Manufacturer Details')

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
                <a href="{{ route('brand#list') }}" class="px-3 border shadow-sm btn btn-light text-navy fw-bold btn-sm transition-hover">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back to Brands
                </a>
            </div>

            <div class="overflow-hidden admin-card">

                <div class="p-4 card-header-navy d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 text-white fw-bold"><i class="fa-solid fa-pen-to-square me-2 text-gold"></i> Update Brand</h4>
                        <div class="small" style="color: rgba(255,255,255,0.7); letter-spacing: 0.5px;">
                            BRAND ID: <span class="text-white fw-bold">#{{ $brand->brand_id }}</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-tags fs-1" style="color: rgba(255,255,255,0.1);"></i>
                </div>

                <div class="p-4 card-body p-md-5">

                    <form id="brandEditForm" action="{{ route('brand#update', $brand->brand_id) }}" method="post" novalidate>
                        @csrf

                        <div class="mb-4">
                            <label for="brandName" class="form-label fw-bold text-navy small text-uppercase">Brand Name</label>
                            <input id="brandName" type="text" name="brandName" value="{{ old('brandName', $brand->brand_name) }}"
                                class="form-control form-control-lg admin-input @error('brandName') is-invalid @enderror"
                                placeholder="Enter brand name..." required autocomplete="off">
                            @error('brandName')
                                <div class="mt-2 invalid-feedback fw-medium">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label for="brandDescription" class="form-label fw-bold text-navy small text-uppercase">Description</label>
                            <input id="brandDescription" type="text" name="brandDescription" value="{{ old('brandDescription', $brand->brand_description) }}"
                                class="form-control form-control-lg admin-input @error('brandDescription') is-invalid @enderror"
                                placeholder="Enter brand description..." required autocomplete="off">
                            @error('brandDescription')
                                <div class="mt-2 invalid-feedback fw-medium">{{ $message }}</div>
                            @enderror
                            <div class="mt-2 form-text text-muted"><i class="fa-solid fa-circle-info me-1"></i> This information will be displayed to customers on product pages.</div>
                        </div>

                        <div class="gap-3 pt-4 d-flex border-top" style="border-color: rgba(30,58,95,0.08) !important;">
                            <button type="button" id="btnUpdate" class="px-5 py-2 btn btn-admin-primary fw-bold text-uppercase" style="letter-spacing: 0.5px;">
                                <i class="fa-solid fa-floppy-disk me-2"></i> Save Changes
                            </button>
                            <a href="{{ route('brand#list') }}" class="px-4 py-2 border btn btn-light fw-bold text-muted">Cancel</a>
                        </div>
                    </form>

                    <div class="pt-3 mt-4 d-flex flex-column flex-sm-row justify-content-between text-muted small fw-medium">
                        <div>Created: <span class="text-dark">{{ $brand->created_at?->format('j M Y') ?? '—' }}</span></div>
                        <div class="mt-1 mt-sm-0">Last Updated: <span class="text-dark">{{ $brand->updated_at?->format('j M Y, H:i') ?? '—' }}</span></div>
                    </div>

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
                <p class="mb-0 text-dark fw-medium fs-5">Are you sure you want to save these changes?</p>
                <p class="mt-2 text-muted">Updating this brand will instantly change how it appears across the entire storefront.</p>
            </div>
            <div class="pt-0 modal-footer border-top-0">
                <button type="button" class="border btn btn-light fw-bold text-muted" data-bs-dismiss="modal">Cancel</button>
                <button id="confirmSubmit" type="button" class="px-4 btn btn-admin-primary fw-bold">Yes, Update</button>
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
                document.getElementById('brandEditForm').submit();
            });
        }

        window.addEventListener('load', () => {
            const el = document.getElementById('brandName');
            if (el) el.focus();
        });
    })();
</script>
@endsection
