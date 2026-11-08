@extends('admin.layouts.master')

@section('page-title', 'Security')
@section('page-subtitle', 'System Audit Trail')

@section('content')
<div class="py-4 container-fluid">
    <div class="shadow-sm admin-card">

        <div class="p-3 border-bottom rounded-top-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center" style="background-color: #1E3A5F;">
            <h5 class="mb-3 text-white mb-md-0 fw-bold"><i class="fa-solid fa-clipboard-list me-2 text-gold"></i> Activity Logs</h5>

            <form action="{{ route('admin#auditLogs') }}" method="GET" class="d-flex align-items-center">
                <div class="shadow-sm input-group input-group-sm">
                    <span class="border-0 input-group-text bg-light text-navy fw-bold">
                        <i class="fa-regular fa-calendar-days me-1"></i> Date
                    </span>
                    <input type="date" name="filter_date" class="border-0 form-control" value="{{ request('filter_date') }}">

                    <button type="submit" class="px-3 border-0 btn btn-warning text-navy fw-bold">Filter</button>

                    @if(request('filter_date'))
                        <a href="{{ route('admin#auditLogs') }}" class="btn btn-light text-danger border-start fw-bold" title="Clear Filter">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="p-0 card-body">
            <div class="table-responsive">
                <table class="table mb-0 align-middle table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3 text-muted small text-uppercase">Date & Time</th>
                            <th class="py-3 text-muted small text-uppercase">Admin</th>
                            <th class="py-3 text-muted small text-uppercase">Action Category</th>
                            <th class="px-4 py-3 text-muted small text-uppercase">Detailed Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td class="px-4 py-3 small text-muted">
                                    {{ $log->created_at->format('d M Y, h:i A') }}
                                </td>
                                <td class="py-3 fw-bold text-navy">
                                    {{ $log->user->name ?? 'System' }}
                                </td>
                                <td class="py-3">
                                    <span class="border badge bg-light text-dark">{{ $log->action }}</span>
                                </td>
                                <td class="px-4 py-3 small text-dark">
                                    {{ $log->description }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-5 text-center text-muted">
                                    @if(request('filter_date'))
                                        <i class="mb-3 opacity-25 fa-regular fa-calendar-xmark fa-3x"></i>
                                        <h6 class="fw-bold">No activity found</h6>
                                        <p class="small">There are no logs for {{ \Carbon\Carbon::parse(request('filter_date'))->format('d M Y') }}.</p>
                                    @else
                                        <i class="mb-3 opacity-25 fa-solid fa-clipboard-list fa-3x"></i>
                                        <h6 class="fw-bold">No activity recorded yet.</h6>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($logs->hasPages())
                <div class="p-3 border-top">
                    {{ $logs->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
