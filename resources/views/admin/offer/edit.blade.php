@extends('admin.layouts.master')

@section('page-title', 'Edit Offer')
@section('page-subtitle', 'Update Product Promotion')

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
                    <a href="{{ route('offer#list') }}"
                        class="px-3 border shadow-sm btn btn-light text-navy fw-bold btn-sm transition-hover">
                        <i class="fa-solid fa-arrow-left me-2"></i> Back to Offers
                    </a>
                </div>

                <div class="overflow-hidden admin-card">

                    <div class="p-4 card-header-navy d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 text-white fw-bold"><i class="fa-solid fa-tags me-2 text-gold"></i> Update Offer
                            </h4>
                            <div class="small" style="color: rgba(255,255,255,0.7); letter-spacing: 0.5px;">
                                OFFER ID: <span class="text-white fw-bold">#{{ $offer->offer_id }}</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-badge-percent fs-1" style="color: rgba(255,255,255,0.1);"></i>
                    </div>

                    <div class="p-4 card-body p-md-5">

                        <form id="offerEditForm" action="{{ route('offer#update', $offer->offer_id) }}" method="post"
                            novalidate>
                            @csrf

                            <div class="mb-4">
                                <label for="title" class="form-label fw-bold text-navy small text-uppercase">Offer
                                    Title</label>
                                <input id="title" type="text" name="title"
                                    value="{{ old('title', $offer->title) }}"
                                    class="form-control form-control-lg admin-input @error('title') is-invalid @enderror"
                                    placeholder="Enter title..." required autocomplete="off">
                                @error('title')
                                    <div class="mt-2 invalid-feedback fw-medium">{{ $message }}</div>
                                @enderror
                                <div class="mt-2 form-text text-muted"><i class="fa-solid fa-circle-info me-1"></i>
                                    Customers will see this badge on the product page.</div>
                            </div>

                            <div class="mb-5 row g-4">
                                <div class="col-md-4">
                                    <label for="discount_percent"
                                        class="form-label fw-bold text-navy small text-uppercase">Discount (%)</label>
                                    <input id="discount_percent" type="number" step="any" name="discount_percent"
                                        value="{{ old('discount_percent', $offer->discount_percent) }}"
                                        class="form-control form-control-lg admin-input fw-bold text-danger @error('discount_percent') is-invalid @enderror"
                                        placeholder="15" required autocomplete="off" min="0" max="100"
                                        oninput="if(this.value < 0) this.value = Math.abs(this.value)">
                                    @error('discount_percent')
                                        <div class="mt-2 invalid-feedback fw-medium">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-8">
                                    <label for="product_id" class="form-label fw-bold text-navy small text-uppercase">Target
                                        Product</label>
                                    <select id="product_id" name="product_id"
                                        class="form-select form-select-lg admin-input @error('product_id') is-invalid @enderror"
                                        required>
                                        @foreach ($products as $p)
                                            <option value="{{ $p->product_id }}"
                                                {{ (string) old('product_id', $offer->product_id) === (string) $p->product_id ? 'selected' : '' }}>
                                                {{ $p->product_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <div class="mt-2 invalid-feedback fw-medium">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="gap-3 pt-4 d-flex border-top" style="border-color: rgba(30,58,95,0.08) !important;">
                                <button type="button" id="btnUpdate"
                                    class="px-5 py-2 btn btn-admin-primary fw-bold text-uppercase"
                                    style="letter-spacing: 0.5px;">
                                    <i class="fa-solid fa-floppy-disk me-2"></i> Save Changes
                                </button>
                                <a href="{{ route('offer#list') }}"
                                    class="px-4 py-2 border btn btn-light fw-bold text-muted">Cancel</a>
                            </div>
                        </form>

                        <div
                            class="pt-3 mt-4 d-flex flex-column flex-sm-row justify-content-between text-muted small fw-medium">
                            <div>Created: <span class="text-dark">{{ $offer->created_at?->format('j M Y') ?? '—' }}</span>
                            </div>
                            <div class="mt-1 mt-sm-0">Last Updated: <span
                                    class="text-dark">{{ $offer->updated_at?->format('j M Y, H:i') ?? '—' }}</span></div>
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
                    <h5 class="modal-title fw-bold text-navy"><i
                            class="fa-solid fa-triangle-exclamation text-gold me-2"></i> Confirm Update</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="py-4 modal-body">
                    <p class="mb-0 text-dark fw-medium fs-5">Save changes to this offer?</p>
                    <p class="mt-2 text-muted">The product price will instantly adjust on the storefront based on the new
                        percentage.</p>
                </div>
                <div class="pt-0 modal-footer border-top-0">
                    <button type="button" class="border btn btn-light fw-bold text-muted"
                        data-bs-dismiss="modal">Cancel</button>
                    <button id="confirmSubmit" type="button" class="px-4 btn btn-admin-primary fw-bold">Yes, Update
                        Offer</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js-script')
    <script>
        (function() {
            const productSelect = document.getElementById('product_id');


            if (productSelect) {
                new TomSelect(productSelect, {
                    create: false,
                    sortField: {
                        field: "text",
                        direction: "asc"
                    },
                    placeholder: "-- Search for a laptop... --"
                });
            }

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
                    document.getElementById('offerEditForm').submit();
                });
            }

            window.addEventListener('load', () => {
                const el = document.getElementById('title');
                if (el) el.focus();
            });
        })();
    </script>
@endsection
