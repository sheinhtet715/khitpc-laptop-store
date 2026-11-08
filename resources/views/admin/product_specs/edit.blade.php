@extends('admin.layouts.master')

@section('page-title', 'Edit Specifications')
@section('page-subtitle', 'Update Hardware Profile')

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
        <div class="col-12 col-xl-10">

            <div class="mb-3">
                <a href="{{ route('productspecs#list') }}" class="px-3 border shadow-sm btn btn-light text-navy fw-bold btn-sm transition-hover">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back to Specs List
                </a>
            </div>

            <div class="overflow-hidden admin-card">

                <div class="p-4 card-header-navy d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 text-white fw-bold"><i class="fa-solid fa-microchip me-2 text-gold"></i> Update Specifications</h4>
                        <div class="small" style="color: rgba(255,255,255,0.7); letter-spacing: 0.5px;">
                            SPEC ID: <span class="text-white fw-bold">#{{ $productspec->spec_id }}</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-list-check fs-1" style="color: rgba(255,255,255,0.1);"></i>
                </div>

                <div class="p-4 card-body p-md-5">

                    <form id="specEditForm" action="{{ route('productspecs#update', $productspec->spec_id) }}" method="post" novalidate>
                        @csrf

                        <div class="row g-4">

                            <div class="col-md-6">
                                <label for="model" class="form-label fw-bold text-navy small text-uppercase">Model Name</label>
                                <input id="model" type="text" name="model" value="{{ old('model', $productspec->Model) }}" class="form-control form-control-lg admin-input @error('model') is-invalid @enderror" required autocomplete="off">
                                @error('model')<div class="mt-1 invalid-feedback fw-medium">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="processor" class="form-label fw-bold text-navy small text-uppercase">CPU (Processor)</label>
                                <input id="processor" type="text" name="processor" value="{{ old('processor', $productspec->Processor) }}" class="form-control form-control-lg admin-input @error('processor') is-invalid @enderror" required autocomplete="off">
                                @error('processor')<div class="mt-1 invalid-feedback fw-medium">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="ram" class="form-label fw-bold text-navy small text-uppercase">RAM (Memory)</label>
                                <input id="ram" type="text" name="ram" value="{{ old('ram', $productspec->Ram) }}" class="form-control form-control-lg admin-input @error('ram') is-invalid @enderror" required autocomplete="off">
                                @error('ram')<div class="mt-1 invalid-feedback fw-medium">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="graphicsCard" class="form-label fw-bold text-navy small text-uppercase">GPU (Graphics Card)</label>
                                <input id="graphicsCard" type="text" name="graphicsCard" value="{{ old('graphicsCard', $productspec->Graphics_Card) }}" class="form-control form-control-lg admin-input @error('graphicsCard') is-invalid @enderror" required autocomplete="off">
                                @error('graphicsCard')<div class="mt-1 invalid-feedback fw-medium">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="display" class="form-label fw-bold text-navy small text-uppercase">Display Panel</label>
                                <input id="display" type="text" name="display" value="{{ old('display', $productspec->Display) }}" class="form-control form-control-lg admin-input @error('display') is-invalid @enderror" required autocomplete="off">
                                @error('display')<div class="mt-1 invalid-feedback fw-medium">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="storage" class="form-label fw-bold text-navy small text-uppercase">Storage Drive</label>
                                <input id="storage" type="text" name="storage" value="{{ old('storage', $productspec->Storage) }}" class="form-control form-control-lg admin-input @error('storage') is-invalid @enderror" required autocomplete="off">
                                @error('storage')<div class="mt-1 invalid-feedback fw-medium">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="battery" class="form-label fw-bold text-navy small text-uppercase">Battery Capacity</label>
                                <input id="battery" type="text" name="battery" value="{{ old('battery', $productspec->Battery) }}" class="form-control form-control-lg admin-input @error('battery') is-invalid @enderror" required autocomplete="off">
                                @error('battery')<div class="mt-1 invalid-feedback fw-medium">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="systemType" class="form-label fw-bold text-navy small text-uppercase">Operating System</label>
                                <input id="systemType" type="text" name="systemType" value="{{ old('systemType', $productspec->System_type) }}" class="form-control form-control-lg admin-input @error('systemType') is-invalid @enderror" required autocomplete="off">
                                @error('systemType')<div class="mt-1 invalid-feedback fw-medium">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="penandTouch" class="form-label fw-bold text-navy small text-uppercase">Pen & Touch Support</label>
                                <input id="penandTouch" type="text" name="penandTouch" value="{{ old('penandTouch', $productspec->Pen_and_touch) }}" class="form-control form-control-lg admin-input @error('penandTouch') is-invalid @enderror" required autocomplete="off">
                                @error('penandTouch')<div class="mt-1 invalid-feedback fw-medium">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="warranty" class="form-label fw-bold text-navy small text-uppercase">Warranty Period</label>
                                <input id="warranty" type="text" name="warranty" value="{{ old('warranty', $productspec->Warranty) }}" class="form-control form-control-lg admin-input @error('warranty') is-invalid @enderror" required autocomplete="off">
                                @error('warranty')<div class="mt-1 invalid-feedback fw-medium">{{ $message }}</div>@enderror
                            </div>

                        </div> <div class="gap-3 pt-4 mt-5 d-flex border-top" style="border-color: rgba(30,58,95,0.08) !important;">
                            <button type="button" id="btnUpdate" class="px-5 py-2 btn btn-admin-primary fw-bold text-uppercase" style="letter-spacing: 0.5px;">
                                <i class="fa-solid fa-floppy-disk me-2"></i> Save Changes
                            </button>
                            <a href="{{ route('productspecs#list') }}" class="px-4 py-2 border btn btn-light fw-bold text-muted">Cancel</a>
                        </div>
                    </form>

                    <div class="pt-3 mt-4 d-flex flex-column flex-sm-row justify-content-between text-muted small fw-medium">
                        <div>Profile Created: <span class="text-dark">{{ $productspec->created_at?->format('j M Y') ?? '—' }}</span></div>
                        <div class="mt-1 mt-sm-0">Last Updated: <span class="text-dark">{{ $productspec->updated_at?->format('j M Y, H:i') ?? '—' }}</span></div>
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
                <p class="mb-0 text-dark fw-medium fs-5">Save changes to these specifications?</p>
                <p class="mt-2 text-muted">Any connected products will automatically display these updated hardware details.</p>
            </div>
            <div class="pt-0 modal-footer border-top-0">
                <button type="button" class="border btn btn-light fw-bold text-muted" data-bs-dismiss="modal">Cancel</button>
                <button id="confirmSubmit" type="button" class="px-4 btn btn-admin-primary fw-bold">Yes, Update Specs</button>
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
                document.getElementById('specEditForm').submit();
            });
        }

        window.addEventListener('load', () => {
            const el = document.getElementById('model');
            if (el) el.focus();
        });
    })();
</script>
@endsection
