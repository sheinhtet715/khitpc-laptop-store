@extends('admin.layouts.master')
@section('page-title', 'Category List')
@section('page-subtitle', 'Manage Categories')
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
            <h3 class="mb-0 fw-bold text-navy text-uppercase" style="letter-spacing: 0.5px;">Laptop Categories</h3>

            <div class="d-lg-none">
                <button class="btn btn-admin-primary" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#createCategoryOffcanvas">
                    <i class="fa-solid fa-plus me-2"></i> Add Category
                </button>
            </div>
        </div>

        <div class="row g-4">

            <div class="col-lg-4 d-none d-lg-block">
                <div class="admin-card h-100">
                    <div class="p-4 card-body">

                        <h5 class="pb-3 mb-4 fw-bold text-navy border-bottom"
                            style="border-color: rgba(30,58,95,0.1) !important;">
                            <i class="fa-solid fa-folder-plus me-2 text-gold"></i> Create Category
                        </h5>

                        <form action="{{ route('category#create') }}" method="post">
                            @csrf
                            <div class="mb-4">
                                <label for="categoryName"
                                    class="form-label fw-bold text-muted small text-uppercase">Category Name</label>
                                <input id="categoryName" type="text" name="categoryName"
                                    value="{{ old('categoryName') }}"
                                    class="form-control admin-input @error('categoryName') is-invalid @enderror"
                                    placeholder="e.g. Gaming Laptops" autocomplete="off">
                                @error('categoryName')
                                    <div class="mt-2 invalid-feedback fw-medium">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="py-2 btn btn-admin-primary w-100 fw-bold text-uppercase"
                                style="letter-spacing: 1px;">
                                Create Category
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
                            <div class="fw-bold text-muted text-uppercase small d-flex align-items-center"
                                style="letter-spacing: 0.5px;">
                                Total Categories:
                                <span class="px-2 py-1 text-white shadow-sm ms-2 rounded-2"
                                    style="background-color: #1E3A5F; font-size: 0.85rem; line-height: 1;">
                                    {{ $categories->total() ?? 0 }}
                                </span>
                            </div>

                            <form method="get" action="{{ route('category#list') }}" class="d-flex">
                                <div class="input-group">
                                    <input name="searchKey" class="form-control admin-input"
                                        value="{{ request('searchKey') }}" type="search"
                                        placeholder="Search categories...">
                                    <button class="px-3 btn btn-admin-primary" type="submit"><i
                                            class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table class="table mb-0 admin-table table-hover">
                                <thead>
                                    <tr>
                                        <th class="py-3 rounded-start">ID</th>
                                        <th class="py-3">Name</th>
                                        <th class="py-3">Created Date</th>
                                        <th class="py-3 text-end rounded-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($categories as $item)
                                        <tr>
                                            <td class="py-3">#{{ $item->category_id }}</td>
                                            <td class="py-3 fw-bold">{{ $item->category_name }}</td>
                                            <td class="py-3 text-muted small"><i
                                                    class="fa-regular fa-calendar me-2 text-gold"></i>{{ $item->created_at?->format('j M Y') }}
                                            </td>
                                            <td class="py-3 text-end text-nowrap">
                                                <a href="{{ route('category#edit', $item->category_id) }}"
                                                    class="border btn btn-sm btn-light me-1 text-navy" title="Edit">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <button type="button" onclick="deleteProcess({{ $item->category_id }})"
                                                    class="border btn btn-sm btn-light text-danger" title="Delete">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="py-5 text-center text-muted">
                                                <i class="mb-3 opacity-50 fa-regular fa-folder-open fs-2"></i>
                                                <div class="fw-medium">No categories found matching your search.</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($categories->hasPages())
                            <div class="mt-4 d-flex justify-content-end">
                                {{ $categories->appends(request()->query())->links('pagination::bootstrap-5') }}
                            </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="createCategoryOffcanvas"
        style="height: auto; border-radius: 20px 20px 0 0;">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-bold text-navy"><i class="fa-solid fa-folder-plus me-2 text-gold"></i> Create
                Category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="p-4 offcanvas-body">
            <form action="{{ route('category#create') }}" method="post">
                @csrf
                <div class="mb-4">
                    <label for="categoryNameMobile" class="form-label fw-bold text-muted small text-uppercase">Category
                        Name</label>
                    <input id="categoryNameMobile" type="text" name="categoryName" value="{{ old('categoryName') }}"
                        class="form-control admin-input @error('categoryName') is-invalid @enderror"
                        placeholder="Category Name..." autocomplete="off">
                    @error('categoryName')
                        <div class="mt-2 invalid-feedback fw-medium">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="py-3 btn btn-admin-primary w-100 fw-bold text-uppercase"
                    style="letter-spacing: 1px;">
                    Create Category
                </button>
            </form>
        </div>
    </div>
@endsection

@section('js-script')
    <script>
        function deleteProcess(id) {
            Swal.fire({
                title: "Delete Category?",
                text: "This action cannot be undone.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#D32F2F", //  Red
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/admin/category/delete/' + id;
                }
            });
        }

        var createOffcanvasEl = document.getElementById('createCategoryOffcanvas');
        if (createOffcanvasEl) {
            createOffcanvasEl.addEventListener('shown.bs.offcanvas', function() {
                var el = createOffcanvasEl.querySelector('input[name="categoryName"]');
                if (el) el.focus();
            });
        }
    </script>
@endsection
