@extends('admin.layouts.master')

@section('page-title', 'Product Specifications')
@section('page-subtitle', 'Manage Hardware Profiles')

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
    .btn-admin-primary:hover { background-color: #FFBF00; color: #1E3A5F; }

  
    .form-scroll-area {
        max-height: 55vh;
        overflow-y: auto;
        padding-right: 8px; 
    }

   
    .form-scroll-area::-webkit-scrollbar {
		width: 5px;
	}
	
    .form-scroll-area::-webkit-scrollbar-track {
		background: transparent;
	}
	
    .form-scroll-area::-webkit-scrollbar-thumb {
        background: rgba(30, 58, 95, 0.15);
        border-radius: 10px;
    }
	
    .form-scroll-area::-webkit-scrollbar-thumb:hover {
        background: rgba(30, 58, 95, 0.3);
    }


    .sticky-form-col {
        position: -webkit-sticky;
        position: sticky;
        top: 90px; 
        z-index: 10;
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
    <div class="mb-4 d-sm-flex align-items-center justify-content-between d-lg-none">
        <h3 class="mb-0 fw-bold text-navy text-uppercase" style="letter-spacing: 0.5px;">Specs List</h3>
        <button class="btn btn-admin-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#createSpecsOffcanvas">
            <i class="fa-solid fa-plus me-2"></i> Add Specs
        </button>
    </div>

    <div class="row g-4 align-items-start">

        <div class="col-lg-4 d-none d-lg-block sticky-form-col">
            <div class="admin-card">
                <div class="p-4 card-body">

                    <h5 class="pb-3 mb-3 fw-bold text-navy border-bottom" style="border-color: rgba(30,58,95,0.1) !important;">
                        <i class="fa-solid fa-list-check me-2 text-gold"></i> Create Profile
                    </h5>

                    <form action="{{ route('productspecs#create') }}" method="post">
                        @csrf

                        <div class="mb-3 form-scroll-area pe-2">
                            <div class="mb-3">
                                <label for="model" class="form-label fw-bold text-muted small text-uppercase">Model</label>
                                <input id="model" type="text" name="model" value="{{ old('model') }}" class="form-control admin-input @error('model') is-invalid @enderror" placeholder="e.g. ROG Strix G15" autocomplete="off">
                                @error('model')<div class="invalid-feedback fw-medium">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="processor" class="form-label fw-bold text-muted small text-uppercase">CPU</label>
                                <input id="processor" type="text" name="processor" value="{{ old('processor') }}" class="form-control admin-input @error('processor') is-invalid @enderror" placeholder="e.g. Intel Core i7-12700H" autocomplete="off">
                                @error('processor')<div class="invalid-feedback fw-medium">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="ram" class="form-label fw-bold text-muted small text-uppercase">RAM</label>
                                <input id="ram" type="text" name="ram" value="{{ old('ram') }}" class="form-control admin-input @error('ram') is-invalid @enderror" placeholder="e.g. 16GB DDR5" autocomplete="off">
                                @error('ram')<div class="invalid-feedback fw-medium">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="graphicsCard" class="form-label fw-bold text-muted small text-uppercase">Graphics Card</label>
                                <input id="graphicsCard" type="text" name="graphicsCard" value="{{ old('graphicsCard') }}" class="form-control admin-input @error('graphicsCard') is-invalid @enderror" placeholder="e.g. RTX 3060 6GB" autocomplete="off">
                                @error('graphicsCard')<div class="invalid-feedback fw-medium">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="display" class="form-label fw-bold text-muted small text-uppercase">Display</label>
                                <input id="display" type="text" name="display" value="{{ old('display') }}" class="form-control admin-input @error('display') is-invalid @enderror" placeholder="e.g. 15.6 FHD 144Hz" autocomplete="off">
                                @error('display')<div class="invalid-feedback fw-medium">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="storage" class="form-label fw-bold text-muted small text-uppercase">Storage</label>
                                <input id="storage" type="text" name="storage" value="{{ old('storage') }}" class="form-control admin-input @error('storage') is-invalid @enderror" placeholder="e.g. 512GB NVMe SSD" autocomplete="off">
                                @error('storage')<div class="invalid-feedback fw-medium">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="battery" class="form-label fw-bold text-muted small text-uppercase">Battery</label>
                                <input id="battery" type="text" name="battery" value="{{ old('battery') }}" class="form-control admin-input @error('battery') is-invalid @enderror" placeholder="e.g. 4-cell 90Whr" autocomplete="off">
                                @error('battery')<div class="invalid-feedback fw-medium">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="systemType" class="form-label fw-bold text-muted small text-uppercase">System Type</label>
                                <input id="systemType" type="text" name="systemType" value="{{ old('systemType') }}" class="form-control admin-input @error('systemType') is-invalid @enderror" placeholder="e.g. 64-bit Windows" autocomplete="off">
                                @error('systemType')<div class="invalid-feedback fw-medium">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="penandTouch" class="form-label fw-bold text-muted small text-uppercase">Pen & Touch</label>
                                <input id="penandTouch" type="text" name="penandTouch" value="{{ old('penandTouch') }}" class="form-control admin-input @error('penandTouch') is-invalid @enderror" placeholder="e.g. No / Multi-touch" autocomplete="off">
                                @error('penandTouch')<div class="invalid-feedback fw-medium">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-2">
                                <label for="warranty" class="form-label fw-bold text-muted small text-uppercase">Warranty</label>
                                <input id="warranty" type="text" name="warranty" value="{{ old('warranty') }}" class="form-control admin-input @error('warranty') is-invalid @enderror" placeholder="e.g. 1 Year Local" autocomplete="off">
                                @error('warranty')<div class="invalid-feedback fw-medium">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <button type="submit" class="py-2 mt-2 btn btn-admin-primary w-100 fw-bold text-uppercase" style="letter-spacing: 1px;">
                            Create Specs
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
                            Total Specs:
                            <span class="px-2 py-1 text-white shadow-sm ms-2 rounded-2" style="background-color: #1E3A5F; font-size: 0.85rem; line-height: 1;">
                                {{ $productspecs->total() ?? 0 }}
                            </span>
                        </div>

                        <form method="get" action="{{ route('productspecs#list') }}" class="d-flex">
                            <div class="input-group">
                                <input name="searchKey" class="form-control admin-input" type="search" placeholder="Search models or CPU..." value="{{ request('searchKey') }}">
                                <button class="px-3 btn btn-admin-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table mb-0 align-middle admin-table table-hover">
                            <thead>
                                <tr>
                                    <th class="py-3 rounded-start">ID</th>
                                    <th class="py-3">Model</th>
                                    <th class="py-3">CPU</th>
                                    <th class="py-3">RAM</th>
                                    <th class="py-3">GPU</th>
                                    <th class="py-3 text-end rounded-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($productspecs as $item)
                                    <tr>
                                        <td class="py-3 text-muted">#{{ $item->spec_id }}</td>
                                        <td class="py-3 fw-bold">{{ $item->Model }}</td>
                                        <td class="py-3 small">{{ $item->Processor }}</td>
                                        <td class="py-3 small">{{ $item->Ram }}</td>
                                        <td class="py-3 small">{{ $item->Graphics_Card }}</td>
                                        <td class="py-3 text-end text-nowrap">
                                            <a href="{{ route('productspecs#edit', $item->spec_id) }}" class="border btn btn-sm btn-light me-1 text-navy" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <button type="button" onclick="deleteProcess({{ $item->spec_id }})" class="border btn btn-sm btn-light text-danger" title="Delete">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-5 text-center text-muted">
                                            <i class="mb-3 opacity-50 fa-regular fa-folder-open fs-2"></i>
                                            <div class="fw-medium">No product specs found matching your search.</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($productspecs->hasPages())
                        <div class="mt-4 d-flex justify-content-end">
                            {{ $productspecs->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>

    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="createSpecsOffcanvas" style="width: 400px; max-width: 100vw;">
    <div class="border-bottom offcanvas-header">
        <h5 class="offcanvas-title fw-bold text-navy"><i class="fa-solid fa-list-check me-2 text-gold"></i> Create Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="p-4 offcanvas-body">
        <form action="{{ route('productspecs#create') }}" method="post">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-bold text-muted small text-uppercase">Model Name</label>
                <input type="text" name="model" value="{{ old('model') }}" class="form-control admin-input" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold text-muted small text-uppercase">CPU</label>
                <input type="text" name="processor" value="{{ old('processor') }}" class="form-control admin-input" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold text-muted small text-uppercase">RAM</label>
                <input type="text" name="ram" value="{{ old('ram') }}" class="form-control admin-input" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold text-muted small text-uppercase">Graphics Card</label>
                <input type="text" name="graphicsCard" value="{{ old('graphicsCard') }}" class="form-control admin-input" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold text-muted small text-uppercase">Display</label>
                <input type="text" name="display" value="{{ old('display') }}" class="form-control admin-input" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold text-muted small text-uppercase">Storage</label>
                <input type="text" name="storage" value="{{ old('storage') }}" class="form-control admin-input" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold text-muted small text-uppercase">Battery</label>
                <input type="text" name="battery" value="{{ old('battery') }}" class="form-control admin-input" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold text-muted small text-uppercase">System Type</label>
                <input type="text" name="systemType" value="{{ old('systemType') }}" class="form-control admin-input" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold text-muted small text-uppercase">Pen & Touch</label>
                <input type="text" name="penandTouch" value="{{ old('penandTouch') }}" class="form-control admin-input" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold text-muted small text-uppercase">Warranty</label>
                <input type="text" name="warranty" value="{{ old('warranty') }}" class="form-control admin-input" required>
            </div>

            <button type="submit" class="py-3 mt-4 btn btn-admin-primary w-100 fw-bold text-uppercase" style="letter-spacing: 1px;">
                Create Specs
            </button>
        </form>
    </div>
</div>

@endsection

@section('js-script')
<script>
    function deleteProcess(id){
        Swal.fire({
            title: "Delete Specifications?",
            text: "This action cannot be undone.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#D32F2F",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/admin/productspecs/delete/' + id;
            }
        });
    }

    var createOffcanvasEl = document.getElementById('createSpecsOffcanvas');
    if (createOffcanvasEl) {
        createOffcanvasEl.addEventListener('shown.bs.offcanvas', function () {
            var el = createOffcanvasEl.querySelector('input[name="model"]');
            if (el) el.focus();
        });
    }
</script>
@endsection
