@extends('layouts.app')

@section('content')
@push('styles')
<link href="{{ asset('css/staff-design.css') }}?v={{ time() }}" rel="stylesheet">
<style>
    .inv-topbar {
        position: relative;
        overflow: hidden;
        border-radius: 18px;
        padding: 1.05rem 1.3rem;
        background: linear-gradient(130deg, #0f766e 0%, #0ea5e9 55%, #2563eb 100%);
        border: 1px solid rgba(255, 255, 255, 0.22);
        box-shadow: 0 10px 26px rgba(14, 116, 144, 0.18);
    }
    .inv-topbar::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            radial-gradient(circle at 15% 20%, rgba(255,255,255,.20) 0, rgba(255,255,255,0) 32%),
            radial-gradient(circle at 90% 0%, rgba(255,255,255,.14) 0, rgba(255,255,255,0) 34%);
        pointer-events: none;
    }
    .inv-topbar-inner {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.9rem;
        flex-wrap: wrap;
    }
    .inv-title-wrap {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }
    .inv-title-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,.18);
        color: #fff;
        font-size: 1rem;
        box-shadow: inset 0 0 0 1px rgba(255,255,255,.18);
    }
    .inv-title-text {
        font-size: 1.85rem;
        font-weight: 750;
        letter-spacing: -0.35px;
        color: #fff;
        line-height: 1.05;
        margin: 0;
    }
    .inv-header-actions {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .inv-head-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.5rem 0.95rem;
        border-radius: 999px;
        border: 1px solid rgba(255,255,255,.38);
        background: rgba(255,255,255,.16);
        color: #fff;
        font-size: 0.9rem;
        font-weight: 650;
        white-space: nowrap;
    }
    .modal-backdrop {
        z-index: 2090 !important;
    }
    .modal {
        z-index: 2100 !important;
    }
    .modal.show,
    .modal.show .modal-dialog,
    .modal.show .modal-content,
    .modal.show .modal-content * {
        pointer-events: auto !important;
    }
    .smooth-modal .modal-dialog {
        opacity: 0;
        transform: translateY(8px) scale(0.985);
        transition: opacity 160ms ease, transform 160ms ease;
    }
    .smooth-modal.show .modal-dialog {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
</style>
@endpush

<div class="container-fluid px-4 staff-container animate-fade-up">
    <div class="inv-topbar mb-4">
        <div class="inv-topbar-inner">
            <div class="inv-title-wrap">
                <span class="inv-title-icon"><i class="fa-solid fa-file-invoice-dollar"></i></span>
                <h5 class="inv-title-text">My Transactions</h5>
            </div>
            <div class="inv-header-actions">
                <span class="inv-head-pill"><i class="fa-solid fa-receipt"></i>{{ number_format($transactions->total()) }} Records</span>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="content-card">
                <div class="card-header-custom d-flex justify-content-between align-items-center">
                    <h5 class="card-title-custom mb-0"><i class="fa-solid fa-list-check me-2 text-primary"></i>Transaction History</h5>
                    <button class="btn btn-sm btn-outline-secondary rounded-pill px-3" onclick="location.reload()">
                        <i class="fa-solid fa-rotate me-1"></i> Refresh
                    </button>
                </div>

                <div class="card-body-custom p-0" id="staffTrxTableWrap">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 inv-table">
                            <thead>
                                <tr>
                                    <th class="ps-4">TRX Number</th>
                                    <th>Date</th>
                                    <th>Total Amount</th>
                                    <th>Items</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $trx)
                                <tr>
                                    <td class="ps-4">
                                        <span class="fw-bold text-dark">{{ $trx->transaction_number }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-600 text-dark">{{ $trx->created_at->format('M d, Y') }}</div>
                                        <div class="text-muted small">{{ $trx->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark">₱{{ number_format($trx->total_amount, 2) }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            @foreach($trx->items as $item)
                                                {{ $item->product->name ?? 'Unknown' }} (x{{ $item->quantity }})<br>
                                            @endforeach
                                        </small>
                                    </td>
                                    <td>
                                        @if($trx->status === 'returned')
                                            <span class="badge bg-soft-danger text-danger px-3 py-2 rounded-pill fw-bold">RETURNED</span>
                                        @else
                                            <span class="badge bg-soft-success text-success px-3 py-2 rounded-pill fw-bold">COMPLETED</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        @if($trx->status !== 'returned')
                                            <button class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-600" data-bs-toggle="modal" data-bs-target="#returnModal{{ $trx->id }}">
                                                <i class="fa-solid fa-rotate-left me-1"></i> Return
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-secondary rounded-pill px-3" disabled>Returned</button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach

                                @if($transactions->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-inbox fs-1 mb-3 d-block opacity-25"></i>
                                        <p class="h6 fw-bold">No transactions found.</p>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Return Modals -->
@foreach($transactions as $trx)
@if($trx->status !== 'returned')
<div class="modal smooth-modal" id="returnModal{{ $trx->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <form action="{{ route('staff.transactions.return', $trx->id) }}" method="POST">
                @csrf
                <div class="modal-header bg-danger text-white border-0">
                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-rotate-left me-2"></i>Process Return</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <div class="mb-3 text-danger">
                            <i class="fa-solid fa-circle-exclamation fa-4x opacity-75"></i>
                        </div>
                        <h5 class="fw-bold">Confirm Return</h5>
                        <p class="text-muted">Are you sure you want to process a return for transaction <span class="fw-bold text-dark">#{{ substr($trx->transaction_number, -6) }}</span>?</p>
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold">Reason for Return <span class="text-danger">*</span></label>
                        <textarea name="reason" class="form-control" rows="3" required placeholder="Please describe why this item is being returned..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top-0 justify-content-center">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger px-4 fw-bold"><i class="fa-solid fa-check me-2"></i>Confirm Return</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach
@endsection
