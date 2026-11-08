@extends('admin.layouts.master')

@section('page-title', 'Laptop Brands')
@section('page-subtitle', 'Manage Manufacturers')

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

    @if(session('success'))
        <div class="mb-4 border-0 shadow-sm alert alert-success fw-medium rounded-3 alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 border-0 shadow-sm alert alert-danger fw-medium rounded-3 alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h3 class="mb-0 fw-bold text-navy text-uppercase" style="letter-spacing: 0.5px;">Brands List</h3>

        <div class="d-lg-none">
            <button class="btn btn-admin-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#createBrandOffcanvas">
                <i class="fa-solid fa-plus me-2"></i> Add Brand
            </button>
        </div>
    </div>

    <div class="row g-4">

        <div class="col-lg-4 d-none d-lg-block">
            <div class="admin-card h-100">
                <div class="p-4 card-body">

                    <h5 class="pb-3 mb-4 fw-bold text-navy border-bottom" style="border-color: rgba(30,58,95,0.1) !important;">
                        <i class="fa-solid fa-tags me-2 text-gold"></i> Create Brand
                    </h5>

                    <form action="{{ route('brand#create') }}" method="post">
                        @csrf

                        <div class="mb-4">
                            <label for="brandName" class="form-label fw-bold text-muted small text-uppercase">Brand Name</label>
                            <input id="brandName" type="text" name="brandName" value="{{ old('brandName') }}"
                                class="form-control admin-input @error('brandName') is-invalid @enderror"
                                placeholder="e.g. ASUS" autocomplete="off">
                            @error('brandName')
                                <div class="mt-2 invalid-feedback fw-medium">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="brandDescription" class="form-label fw-bold text-muted small text-uppercase">Description</label>
                            <input id="brandDescription" type="text" name="brandDescription" value="{{ old('brandDescription') }}"
                                class="form-control admin-input @error('brandDescription') is-invalid @enderror"
                                placeholder="e.g. Republic of Gamers..." autocomplete="off">
                            @error('brandDescription')
                                <div class="mt-2 invalid-feedback fw-medium">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="py-2 btn btn-admin-primary w-100 fw-bold text-uppercase" style="letter-spacing: 1px;">
                            Create Brand
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
                            Total Brands:
                            <span class="px-2 py-1 text-white shadow-sm ms-2 rounded-2" style="background-color: #1E3A5F; font-size: 0.85rem; line-height: 1;">
                                {{ $brands->total() ?? 0 }}
                            </span>
                        </div>

                        <form method="get" action="{{ route('brand#list') }}" class="d-flex">
                            <div class="input-group">
                                <input name="searchKey" class="form-control admin-input" value="{{ request('searchKey') }}" type="search" placeholder="Search brands...">
                                <button class="px-3 btn btn-admin-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table mb-0 align-middle admin-table table-hover">
                            <thead>
                                <tr>
                                    <th class="py-3 rounded-start">ID</th>
                                    <th class="py-3">Name</th>
                                    <th class="py-3">Description</th>
                                    <th class="py-3">Created Date</th>
                                    <th class="py-3 text-end rounded-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($brands as $item)
                                    <tr>
                                        <td class="py-3">#{{ $item->brand_id }}</td>
                                        <td class="py-3 fw-bold">{{ $item->brand_name }}</td>
                                        <td class="py-3 text-muted">
                                            {{ Str::limit($item->brand_description, 30) ?: '—' }}
                                        </td>
                                        <td class="py-3 text-muted small"><i class="fa-regular fa-calendar me-2 text-gold"></i>{{ $item->created_at?->format('j M Y') }}</td>
                                        <td class="py-3 text-end text-nowrap">
                                            <a href="{{ route('brand#edit', $item->brand_id) }}" class="border btn btn-sm btn-light me-1 text-navy" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <button type="button" onclick="deleteProcess({{ $item->brand_id }})" class="border btn btn-sm btn-light text-danger" title="Delete">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-5 text-center text-muted">
                                            <i class="mb-3 opacity-50 fa-regular fa-folder-open fs-2"></i>
                                            <div class="fw-medium">No brands found matching your search.</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($brands->hasPages())
                        <div class="mt-4 d-flex justify-content-end">
                            {{ $brands->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>

    </div>
</div>

<div class="offcanvas offcanvas-bottom" tabindex="-1" id="createBrandOffcanvas" style="height: auto; border-radius: 20px 20px 0 0;">
    <div class="border-bottom offcanvas-header">
        <h5 class="offcanvas-title fw-bold text-navy"><i class="fa-solid fa-tags me-2 text-gold"></i> Create Brand</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="p-4 offcanvas-body">
        <form action="{{ route('brand#create') }}" method="post">
            @csrf
            <div class="mb-4">
                <label for="brandNameMobile" class="form-label fw-bold text-muted small text-uppercase">Brand Name</label>
                <input id="brandNameMobile" type="text" name="brandName" value="{{ old('brandName') }}" class="form-control admin-input @error('brandName') is-invalid @enderror" placeholder="Brand Name..." autocomplete="off">
                @error('brandName')
                    <div class="mt-2 invalid-feedback fw-medium">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="brandDescMobile" class="form-label fw-bold text-muted small text-uppercase">Description</label>
                <input id="brandDescMobile" type="text" name="brandDescription" value="{{ old('brandDescription') }}" class="form-control admin-input @error('brandDescription') is-invalid @enderror" placeholder="Brand Description..." autocomplete="off">
                @error('brandDescription')
                    <div class="mt-2 invalid-feedback fw-medium">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="py-3 btn btn-admin-primary w-100 fw-bold text-uppercase" style="letter-spacing: 1px;">
                Create Brand
            </button>
        </form>
    </div>
</div>

@endsection

@section('js-script')
<script>
    function deleteProcess(id){
        Swal.fire({
            title: "Delete Brand?",
            text: "This action cannot be undone.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#D32F2F", // Brand Red
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/admin/brand/delete/' + id;
            }
        });
    }

    var createOffcanvasEl = document.getElementById('createBrandOffcanvas');
    if (createOffcanvasEl) {
        createOffcanvasEl.addEventListener('shown.bs.offcanvas', function () {
            var el = createOffcanvasEl.querySelector('input[name="brandName"]');
            if (el) el.focus();
        });
    }
</script>
@endsection
