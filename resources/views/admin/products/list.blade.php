@extends('admin.layouts.master')

@section('page-title', 'Products')
@section('page-subtitle', 'Manage Inventory')

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


        .product-img-wrapper {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-bottom: 1px solid rgba(30, 58, 95, 0.05);
        }

        .product-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            mix-blend-mode: multiply;
            padding: 1.5rem;
            transition: transform 0.3s ease;
        }

        .admin-card:hover .product-img-wrapper img {
            transform: scale(1.08);
        }

        .product-badge-brand {
            background-color: rgba(30, 58, 95, 0.1);
            color: #1E3A5F;
            border: 1px solid rgba(30, 58, 95, 0.2);
        }

        .product-badge-category {
            background-color: rgba(255, 191, 0, 0.15);
            color: #b38600;
            border: 1px solid rgba(255, 191, 0, 0.3);
        }

   
        .hover-opacity-100:hover { opacity: 1 !important; transform: scale(1.1); }
        .transition-all { transition: all 0.2s ease; }

        .minimized-fab {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1060;
            display: none; 
            box-shadow: 0 4px 20px rgba(30, 58, 95, 0.3);
            transition: transform 0.2s ease;
            border-radius: 50px;
        }

        .minimized-fab:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 25px rgba(30, 58, 95, 0.4);
        }
    </style>

    <div class="container-fluid">

        @if (session('success'))
            <div class="mb-4 border-0 shadow-sm alert alert-success fw-medium rounded-3 alert-dismissible fade show"
                role="alert">
                <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 border-0 shadow-sm alert alert-danger fw-medium rounded-3 alert-dismissible fade show"
                role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="gap-3 mb-4 d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">

            <div class="d-flex align-items-center fw-bold text-muted text-uppercase small" style="letter-spacing: 0.5px;">
                Total Inventory:
                <span class="px-2 py-1 text-white shadow-sm ms-2 rounded-2"
                    style="background-color: #1E3A5F; font-size: 0.85rem; line-height: 1;">
                    {{ $products->total() ?? 0 }}
                </span>
            </div>

            <div class="gap-2 d-flex flex-column flex-md-row align-items-md-center w-100 justify-content-lg-end">

                <form method="get" action="{{ route('product#list') }}"
                    class="gap-2 d-flex flex-column flex-md-row w-100 justify-content-lg-end">

                    <select name="filterBrand" class="form-select admin-input" style="min-width: 140px;">
                        <option value="">All Brands</option>
                        @foreach ($brands as $b)
                            <option value="{{ $b->brand_id }}"
                                {{ request('filterBrand') == $b->brand_id ? 'selected' : '' }}>
                                {{ $b->brand_name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="filterCategory" class="form-select admin-input" style="min-width: 140px;">
                        <option value="">All Categories</option>
                        @foreach ($categories as $c)
                            <option value="{{ $c->category_id }}"
                                {{ request('filterCategory') == $c->category_id ? 'selected' : '' }}>
                                {{ $c->category_name }}
                            </option>
                        @endforeach
                    </select>

                    <div class="input-group" style="min-width: 250px;">
                        <input name="searchKey" class="form-control admin-input" type="search"
                            placeholder="Search sku, name..." value="{{ request('searchKey') }}">
                        <button class="px-3 btn btn-admin-primary fw-bold" type="submit" title="Apply Filters">
                            <i class="fa-solid fa-filter"></i>
                        </button>
                    </div>

                    @if (request('searchKey') || request('filterBrand') || request('filterCategory'))
                        <a href="{{ route('product#list') }}" class="border btn btn-light text-danger fw-bold"
                            title="Clear Filters">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    @endif
                </form>

                <button class="shadow-sm btn btn-admin-primary fw-bold text-uppercase ms-md-2 text-nowrap"
                    style="letter-spacing: 0.5px;" data-bs-toggle="modal" data-bs-target="#createProductModal">
                    <i class="fa-solid fa-plus me-2"></i> Create
                </button>
            </div>
        </div>

        <div class="row g-4">
            @forelse ($products as $item)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="admin-card h-100 d-flex flex-column">

                        <div class="ratio ratio-4x3 product-img-wrapper rounded-top-3">
                            @if ($item->product_image && file_exists(public_path('productImage/' . $item->product_image)))
                                <img src="{{ asset('productImage/' . $item->product_image) }}" class="w-100 h-100"
                                    alt="{{ $item->product_name }}">
                            @else
                                <div class="opacity-25 d-flex align-items-center justify-content-center text-muted">
                                    <i class="fa-solid fa-laptop fa-3x"></i>
                                </div>
                            @endif
                        </div>

                        <div class="p-4 card-body d-flex flex-column flex-grow-1">

                            <div class="gap-2 mb-3 d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1 fw-bold text-navy"
                                        style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $item->product_name }}
                                    </h6>
                                    <div class="small text-muted fw-medium text-uppercase" style="letter-spacing: 0.5px;">
                                        SKU: {{ $item->sku }}</div>
                                </div>
                                <div class="fw-bolder text-danger fs-6 text-nowrap">
                                    K{{ number_format($item->product_price) }}
                                </div>
                            </div>

                            <div class="flex-wrap gap-2 mb-3 d-flex">
                                <span class="badge product-badge-brand">{{ $item->brand_name }}</span>
                                <span class="badge product-badge-category">{{ $item->category_name }}</span>

                                @if ($item->stock_quantity <= 5)
                                    <span
                                        class="border border-opacity-25 badge bg-danger bg-opacity-10 text-danger border-danger">Low
                                        Stock: {{ $item->stock_quantity }}</span>
                                @else
                                    <span
                                        class="border border-opacity-25 badge bg-success bg-opacity-10 text-success border-success">Stock:
                                        {{ $item->stock_quantity }}</span>
                                @endif
                            </div>

                            <p class="mb-4 small text-muted flex-grow-1"
                                style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $item->product_description }}
                            </p>

                            <div class="gap-2 mt-auto d-flex align-items-center justify-content-between">
                                <div class="shadow-sm btn-group" role="group">
                                    <a href="{{ route('product#edit', $item->product_id) }}"
                                        class="border btn btn-sm btn-light text-navy" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <button type="button" class="border btn btn-sm btn-light text-danger"
                                        onclick="deleteProcess({{ $item->product_id }})" title="Delete">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>

                                <a class="border btn btn-sm btn-light fw-bold text-muted" data-bs-toggle="collapse"
                                    href="#specs{{ $item->product_id }}" role="button" aria-expanded="false">
                                    <i class="fa-solid fa-microchip me-1 text-gold"></i> Specs
                                </a>
                            </div>
                            <div class="mt-3 collapse" id="specs{{ $item->product_id }}">
                                <div class="p-3 border border-dashed shadow-sm card card-body small bg-light rounded-3">
                                    <div class="row g-2">
                                        <div class="col-12"><span class="fw-bold text-uppercase text-muted"
                                                style="font-size:0.7rem;">Model:</span> <span
                                                class="fw-medium text-dark">{{ $item->Model ?? 'N/A' }}</span></div>
                                        <div class="col-12"><span class="fw-bold text-uppercase text-muted"
                                                style="font-size:0.7rem;">Display:</span> <span
                                                class="fw-medium text-dark">{{ $item->Display ?? 'N/A' }}</span></div>
                                        <div class="col-12"><span class="fw-bold text-uppercase text-muted"
                                                style="font-size:0.7rem;">CPU:</span> <span
                                                class="fw-medium text-dark">{{ $item->Processor ?? 'N/A' }}</span></div>
                                        <div class="col-12"><span class="fw-bold text-uppercase text-muted"
                                                style="font-size:0.7rem;">GPU:</span> <span
                                                class="fw-medium text-dark">{{ $item->Graphics_Card ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-6"><span class="fw-bold text-uppercase text-muted"
                                                style="font-size:0.7rem;">RAM:</span> <span
                                                class="fw-medium text-dark">{{ $item->Ram ?? 'N/A' }}</span></div>
                                        <div class="col-6"><span class="fw-bold text-uppercase text-muted"
                                                style="font-size:0.7rem;">OS:</span> <span
                                                class="fw-medium text-dark">{{ $item->System_type ?? 'N/A' }}</span></div>
                                        <div class="col-6"><span class="fw-bold text-uppercase text-muted"
                                                style="font-size:0.7rem;">Battery:</span> <span
                                                class="fw-medium text-dark">{{ $item->Battery ?? 'N/A' }}</span></div>
                                        <div class="col-6"><span class="fw-bold text-uppercase text-muted"
                                                style="font-size:0.7rem;">Warranty:</span> <span
                                                class="fw-medium text-dark">{{ $item->Warranty ?? 'N/A' }}</span></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="py-5 text-center admin-card">
                        @if (request('searchKey') || request('filterBrand') || request('filterCategory'))
                            <i class="mb-3 opacity-50 fa-solid fa-filter-circle-xmark fa-3x text-muted"></i>
                            <h5 class="fw-bold text-navy">No matches found</h5>
                            <p class="text-muted">Try clearing your filters or adjusting your search.</p>
                            <a href="{{ route('product#list') }}" class="mt-2 btn btn-admin-primary">Clear All
                                Filters</a>
                        @else
                            <i class="mb-3 opacity-50 fa-solid fa-box-open fa-3x text-muted"></i>
                            <h5 class="fw-bold text-navy">No products found</h5>
                            <p class="text-muted">Create a new product to populate your store.</p>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        @if ($products->hasPages())
            <div class="mt-5 d-flex justify-content-center">
                {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        @endif

        <button id="restoreProductModalBtn" class="px-4 py-3 btn btn-admin-primary minimized-fab align-items-center gap-2 fw-bold">
            <i class="fa-solid fa-laptop text-gold"></i> Resume Creating Product
            <i class="fa-solid fa-expand ms-2 opacity-75"></i>
        </button>

    </div>

    <div class="modal fade" id="createProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="border-0 shadow modal-content" style="border-radius: 16px; overflow: hidden;">

                <div class="p-4 border-0 modal-header"
                    style="background: linear-gradient(135deg, #1E3A5F 0%, #152842 100%); color: white;">
                    <h5 class="mb-0 modal-title fw-bold"><i class="fa-solid fa-laptop me-2 text-gold"></i> Create New
                        Product</h5>

                    <div class="d-flex align-items-center gap-3">
                        <button type="button" id="btnMinimizeModal" class="p-0 bg-transparent border-0 text-white transition-all hover-opacity-100" style="opacity: 0.7;" title="Minimize">
                            <i class="fa-solid fa-minus fs-5"></i>
                        </button>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                </div>

                <form action="{{ route('product#create') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="p-4 modal-body p-md-5 bg-light">
                        <div class="row g-4">

                            <div class="col-md-4">
                                <label class="form-label fw-bold text-navy small text-uppercase">SKU</label>
                                <input type="text" name="sku" class="form-control admin-input"
                                    value="{{ old('sku') }}" placeholder="e.g. ASUS-ROG-001" required>
                                @error('sku')
                                    <div class="mt-1 text-danger small fw-medium">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-8">
                                <label class="form-label fw-bold text-navy small text-uppercase">Product Name</label>
                                <input type="text" name="productName" class="form-control admin-input"
                                    value="{{ old('productName') }}" placeholder="Full product title..." required>
                                @error('productName')
                                    <div class="mt-1 text-danger small fw-medium">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold text-navy small text-uppercase">Price (K)</label>
                                <input type="number" name="productPrice" class="form-control admin-input"
                                    value="{{ old('productPrice') }}" placeholder="0" required>
                                @error('productPrice')
                                    <div class="mt-1 text-danger small fw-medium">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold text-navy small text-uppercase">Stock Qty</label>
                                <input type="number" name="stockQuantity" class="form-control admin-input"
                                    value="{{ old('stockQuantity', 0) }}" required>
                                @error('stockQuantity')
                                    <div class="mt-1 text-danger small fw-medium">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold text-navy small text-uppercase">Brand</label>
                                <select name="brandId" class="form-select admin-input" required>
                                    <option value="">— Select —</option>
                                    @foreach ($brands as $b)
                                        <option value="{{ $b->brand_id }}"
                                            {{ old('brandId') == $b->brand_id ? 'selected' : '' }}>{{ $b->brand_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('brandId')
                                    <div class="mt-1 text-danger small fw-medium">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-navy small text-uppercase">Category</label>
                                <select name="categoryId" class="form-select admin-input" required>
                                    <option value="">— Select —</option>
                                    @foreach ($categories as $c)
                                        <option value="{{ $c->category_id }}"
                                            {{ old('categoryId') == $c->category_id ? 'selected' : '' }}>
                                            {{ $c->category_name }}</option>
                                    @endforeach
                                </select>
                                @error('categoryId')
                                    <div class="mt-1 text-danger small fw-medium">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-navy small text-uppercase">Hardware Specs</label>
                                <select name="specId" class="form-select admin-input" required>
                                    <option value="">— Select Profile —</option>
                                    @foreach ($specs as $s)
                                        <option value="{{ $s->spec_id }}"
                                            {{ old('specId') == $s->spec_id ? 'selected' : '' }}>
                                            {{ $s->Model }} ({{ $s->Processor }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('specId')
                                    <div class="mt-1 text-danger small fw-medium">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold text-navy small text-uppercase">Product Image</label>

                                <input type="file" id="createProductImage" name="product_image" accept=".jpg,.jpeg,.png,.webp"
                                    class="bg-white form-control admin-input @error('product_image') is-invalid @enderror" required>

                                <div class="mt-1 form-text small text-muted"><i class="fa-solid fa-circle-info"></i> Max size: 2MB.</div>

                                @error('product_image')
                                    <div class="mt-1 text-danger small fw-medium">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold text-navy small text-uppercase">Description</label>
                                <textarea name="productDescription" class="form-control admin-input" rows="3"
                                    placeholder="Marketing description...">{{ old('productDescription') }}</textarea>
                                @error('productDescription')
                                    <div class="mt-1 text-danger small fw-medium">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="p-4 bg-white modal-footer border-top-0">
                        <button type="button" class="px-4 border btn btn-light fw-bold text-muted"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="px-5 btn btn-admin-primary fw-bold text-uppercase"
                            style="letter-spacing: 0.5px;">Create Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection

@section('js-script')
<script>
    function deleteProcess(id) {
        Swal.fire({
            title: "Delete Product?",
            text: "This will remove the product from the storefront permanently.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#D32F2F",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/admin/product/delete/' + id;
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {


        const modalEl = document.getElementById('createProductModal');
        let createModal = null;

        if (modalEl) {
            createModal = new bootstrap.Modal(modalEl, {
                backdrop: 'static', 
                keyboard: false
            });

            const btnMinimize = document.getElementById('btnMinimizeModal');
            const btnRestore = document.getElementById('restoreProductModalBtn');

            if (btnMinimize && btnRestore) {
                btnMinimize.addEventListener('click', function() {
                    createModal.hide(); 
                    btnRestore.style.display = 'flex';
                });

                btnRestore.addEventListener('click', function() {
                    btnRestore.style.display = 'none'; 
                    createModal.show(); 
                });
            }

            modalEl.addEventListener('hidden.bs.modal', function () {
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) backdrop.remove();
            });
        }

        @if($errors->any())
            if (createModal) {
                createModal.show();
            }
        @endif


        const createImgInput = document.getElementById('createProductImage');

        if (createImgInput) {
            createImgInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (!file) return;

                if (file.size > 2097152) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Too Large',
                        text: 'The product image must not exceed 2MB. Please choose a smaller file.',
                        confirmButtonColor: '#D32F2F',
                        borderRadius: '16px'
                    });
                    event.target.value = ''; 
                    return;
                }

              
                if (!file.type.startsWith('image/')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid File',
                        text: 'Please upload an image file (JPG, PNG, WEBP).',
                        confirmButtonColor: '#D32F2F',
                        borderRadius: '16px'
                    });
                    event.target.value = ''; 
                    return;
                }
            });

          
            const createForm = createImgInput.closest('form');
            if (createForm) {
                createForm.addEventListener('submit', function(e) {
                    const file = createImgInput.files[0];
                    if (file && file.size > 2097152) {
                        e.preventDefault();
                        Swal.fire('Error', 'Please replace the oversized image before submitting.', 'error');
                        createImgInput.value = '';
                    }
                });
            }
        }
    });
</script>
@endsection
