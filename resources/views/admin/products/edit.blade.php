@extends('admin.layouts.master')

@section('page-title', 'Edit Product')
@section('page-subtitle', 'Update Inventory Details')

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

    .img-upload-box {
        border: 2px dashed rgba(30, 58, 95, 0.2);
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        background: #f8fafc;
        transition: all 0.2s ease;
    }
    .img-upload-box:hover { 
		border-color: #FFBF00; 
		background: #ffffff;
	}
</style>

<div class="py-4 container-fluid">

    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">

            <div class="mb-3">
                <a href="{{ route('product#list') }}" class="px-3 border shadow-sm btn btn-light text-navy fw-bold btn-sm transition-hover">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back to Products
                </a>
            </div>

            <div class="overflow-hidden admin-card">

                <div class="p-4 card-header-navy d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 text-white fw-bold"><i class="fa-solid fa-laptop me-2 text-gold"></i> Update Product</h4>
                        <div class="small" style="color: rgba(255,255,255,0.7); letter-spacing: 0.5px;">
                            PRODUCT ID: <span class="text-white fw-bold">#{{ $product->product_id }}</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-box-open fs-1" style="color: rgba(255,255,255,0.1);"></i>
                </div>

                <div class="p-4 card-body p-md-5">

                    <form id="productEditForm" action="{{ route('product#update', $product->product_id) }}" method="post" enctype="multipart/form-data" novalidate>
                        @csrf
                        <input type="hidden" name="productId" value="{{ $product->product_id }}">
                        <input type="hidden" name="productImage" value="{{ $product->product_image }}">

                        <div class="row g-5">
                            <div class="col-12 col-lg-8">
                                <div class="row g-4">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-navy small text-uppercase">SKU</label>
                                        <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="form-control form-control-lg admin-input @error('sku') is-invalid @enderror" required>
                                        @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-8">
                                        <label class="form-label fw-bold text-navy small text-uppercase">Product Name</label>
                                        <input type="text" name="productName" value="{{ old('productName', $product->product_name) }}" class="form-control form-control-lg admin-input @error('productName') is-invalid @enderror" required>
                                        @error('productName')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-navy small text-uppercase">Price (K)</label>
                                        <input type="number" name="productPrice" value="{{ old('productPrice', $product->product_price) }}" class="form-control form-control-lg admin-input @error('productPrice') is-invalid @enderror" required>
                                        @error('productPrice')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-navy small text-uppercase">Stock Quantity</label>
                                        <input type="number" name="stockQuantity" value="{{ old('stockQuantity', $product->stock_quantity) }}" class="form-control form-control-lg admin-input @error('stockQuantity') is-invalid @enderror" required>
                                        @error('stockQuantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-navy small text-uppercase">Brand</label>
                                        <select name="brandId" class="form-select form-select-lg admin-input @error('brandId') is-invalid @enderror">
                                            @foreach ($brands as $item)
                                                <option value="{{ $item->brand_id }}" @if (old('brandId', $product->brand_id) == $item->brand_id) selected @endif>
                                                    {{ $item->brand_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-navy small text-uppercase">Category</label>
                                        <select name="categoryId" class="form-select form-select-lg admin-input @error('categoryId') is-invalid @enderror">
                                            @foreach ($categories as $item)
                                                <option value="{{ $item->category_id }}" @if (old('categoryId', $product->category_id) == $item->category_id) selected @endif>
                                                    {{ $item->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-navy small text-uppercase">Hardware Specs</label>
                                        <select name="specId" class="form-select form-select-lg admin-input @error('specId') is-invalid @enderror">
                                            @foreach ($specs as $item)
                                                <option value="{{ $item->spec_id }}" {{ old('specId', $product->spec_id) == $item->spec_id ? 'selected' : '' }}>
                                                    {{ $item->Model }} ({{ $item->Processor }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold text-navy small text-uppercase">Product Description</label>
                                        <textarea name="productDescription" class="form-control admin-input @error('productDescription') is-invalid @enderror" rows="4" required>{{ old('productDescription', $product->product_description) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-4">
                                <div class="p-4 bg-white border shadow-sm rounded-3 h-100">
                                    <label class="mb-3 form-label fw-bold text-navy small text-uppercase">Product Image</label>

                                    <div class="mb-3 img-upload-box">
                                        <img id="output" src="{{ asset('productImage/' . $product->product_image) }}" class="mb-3 rounded img-fluid" style="max-height: 200px; object-fit: contain;">

                                        <input type="file" name="product_image" accept=".jpg,.jpeg,.png,.webp" class="mt-2 form-control admin-input @error('product_image') is-invalid @enderror" onchange="loadFile(event)">
                                        @error('product_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="text-center form-text text-muted small"><i class="fa-solid fa-circle-info me-1"></i> Max size: 2MB. Use a transparent or white background for best results.</div>
                                </div>
                            </div>
                        </div>

                        <div class="gap-3 pt-4 mt-5 d-flex border-top" style="border-color: rgba(30,58,95,0.08) !important;">
                            <button type="button" id="btnUpdate" class="px-5 py-2 btn btn-admin-primary fw-bold text-uppercase" style="letter-spacing: 0.5px;">
                                <i class="fa-solid fa-floppy-disk me-2"></i> Save Changes
                            </button>
                            <a href="{{ route('product#list') }}" class="px-4 py-2 border btn btn-light fw-bold text-muted">Cancel</a>
                        </div>
                    </form>

                    <div class="pt-3 mt-4 d-flex flex-column flex-sm-row justify-content-between text-muted small fw-medium">
                        <div>Created: <span class="text-dark">{{ $product->created_at?->format('j M Y') ?? '—' }}</span></div>
                        <div class="mt-1 mt-sm-0">Last Updated: <span class="text-dark">{{ $product->updated_at?->format('j M Y, H:i') ?? '—' }}</span></div>
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
                <p class="mb-0 text-dark fw-medium fs-5">Save changes to this product?</p>
                <p class="mt-2 text-muted">These updates will go live on the storefront immediately.</p>
            </div>
            <div class="pt-0 modal-footer border-top-0">
                <button type="button" class="border btn btn-light fw-bold text-muted" data-bs-dismiss="modal">Cancel</button>
                <button id="confirmSubmit" type="button" class="px-4 btn btn-admin-primary fw-bold">Yes, Update Product</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js-script')
<script>

    const outputImg = document.getElementById('output');
    const originalImageSrc = outputImg ? outputImg.src : '';

    function loadFile(event) {
        const input = event.target;
        const file = input.files[0];


        if (!file) {
            if (outputImg) outputImg.src = originalImageSrc;
            return;
        }


        if (file.size > 2097152) {
            Swal.fire({
                icon: 'error',
                title: 'File Too Large',
                text: 'The image is too large! Maximum allowed size is 2MB.',
                confirmButtonColor: '#D32F2F',
                borderRadius: '16px'
            });

            input.value = '';
            if (outputImg) outputImg.src = originalImageSrc;
            return;
        }

        if (!file.type.startsWith('image/')) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid File',
                text: 'Please upload a valid image file (JPG, PNG, WEBP).',
                confirmButtonColor: '#D32F2F',
                borderRadius: '16px'
            });

            input.value = '';
            if (outputImg) outputImg.src = originalImageSrc;
            return;
        }


        if (outputImg) {
            outputImg.src = URL.createObjectURL(file);
            outputImg.onload = function() {
                URL.revokeObjectURL(outputImg.src); 
            }
        }
    }

    (function() {
        const btn = document.getElementById('btnUpdate');
        const confirmModalEl = document.getElementById('confirmModal');
        let confirmModal = null;

        if (confirmModalEl) {
            confirmModal = new bootstrap.Modal(confirmModalEl);
        }

        if (btn && confirmModal) {
            btn.addEventListener('click', (e) => {


                const fileInput = document.querySelector('input[name="product_image"]');

                if (fileInput && fileInput.files.length > 0) {
                    const file = fileInput.files[0];

                    if (file.size > 2097152) {
                        e.preventDefault(); 
                        Swal.fire('Error', 'Image exceeds 2MB limit. Please upload a smaller image.', 'error');

                        fileInput.value = '';
                        if (outputImg) outputImg.src = originalImageSrc;
                        return; 
                    }
                }
                confirmModal.show();
            });

            document.getElementById('confirmSubmit').addEventListener('click', () => {
                document.getElementById('productEditForm').submit();
            });
        }
    })();
</script>
@endsection
