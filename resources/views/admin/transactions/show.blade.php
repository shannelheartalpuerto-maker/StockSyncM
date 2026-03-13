@extends('layouts.app')

@section('content')
<link href="{{ asset('css/staff-design.css') }}?v={{ time() }}" rel="stylesheet">

<div class="staff-container animate-fade-up">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 no-print">
        <a href="{{ route('admin.transactions.index') }}" class="btn btn-light btn-sm px-3 shadow-sm border">
            <i class="fa-solid fa-arrow-left me-2"></i>Back to Transactions
        </a>
        <button class="btn btn-indigo btn-sm px-3" onclick="window.print()">
            <i class="fa-solid fa-print me-2"></i>Print Receipt
        </button>
    </div>

    <div class="receipt-wrap">
        <div class="receipt-paper">
            <div class="receipt-head text-center">
                <div class="receipt-chips mb-3">
                    <span class="receipt-chip">Transaction #{{ $transaction->id }}</span>
                    <span class="receipt-chip receipt-chip-soft">Completed</span>
                </div>
                <div class="receipt-logo mx-auto mb-2">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
                <h4 class="receipt-store mb-1">{{ config('app.name', 'StockSync') }}</h4>
                <p class="receipt-subtitle mb-0">Sales Receipt</p>
            </div>

            <div class="receipt-dash my-3"></div>

            <div class="receipt-meta-grid mb-3">
                <div class="receipt-meta-item">
                    <span class="meta-label">Receipt No.</span>
                    <span class="meta-value">#{{ $transaction->id }}</span>
                </div>
                <div class="receipt-meta-item text-end">
                    <span class="meta-label">Date</span>
                    <span class="meta-value">{{ $transaction->created_at->format('M d, Y h:i A') }}</span>
                </div>
                <div class="receipt-meta-item">
                    <span class="meta-label">Cashier</span>
                    <span class="meta-value">{{ $transaction->user->name }}</span>
                </div>
                <div class="receipt-meta-item text-end">
                    <span class="meta-label">Payment</span>
                    <span class="meta-value">Cash</span>
                </div>
            </div>

            <div class="receipt-dash mb-3"></div>

            <div class="table-responsive">
                <table class="table receipt-table mb-0">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Price</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaction->items as $item)
                            @php
                                $unitPrice = $item->product->price ?? 0;
                                $lineTotal = $item->quantity * $unitPrice;
                            @endphp
                            <tr>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $item->product->name ?? 'Unknown Product' }}</div>
                                    <div class="text-muted small">SKU: {{ $item->product->code ?? 'N/A' }}</div>
                                </td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end">₱{{ number_format($unitPrice, 2) }}</td>
                                <td class="text-end fw-semibold">₱{{ number_format($lineTotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="receipt-dash my-3"></div>

            <div class="receipt-total-block">
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Items</span>
                    <span class="fw-semibold">{{ $transaction->items->sum('quantity') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Subtotal</span>
                    <span class="fw-semibold">₱{{ number_format($transaction->total_amount, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Discount</span>
                    <span class="fw-semibold">₱0.00</span>
                </div>
                <div class="d-flex justify-content-between pt-2 mt-2 receipt-total-row">
                    <span class="fw-bold">TOTAL</span>
                    <span class="fw-bold text-success">₱{{ number_format($transaction->total_amount, 2) }}</span>
                </div>
            </div>

            <div class="receipt-note text-center mt-4">
                <small>Thank you for your purchase.</small>
            </div>
        </div>
    </div>
</div>

<style>
    .receipt-wrap {
        max-width: 820px;
        margin: 0 auto;
        padding: 0.65rem;
        border-radius: 22px;
        background:
            radial-gradient(circle at 12% 10%, rgba(14,165,233,0.12) 0, rgba(14,165,233,0) 42%),
            radial-gradient(circle at 88% 84%, rgba(99,102,241,0.14) 0, rgba(99,102,241,0) 44%),
            #eef2ff;
    }
    .receipt-paper {
        position: relative;
        background:
            linear-gradient(180deg, rgba(79,70,229,0.03) 0%, rgba(255,255,255,0.96) 13%, #fff 100%),
            repeating-linear-gradient(0deg, rgba(15,23,42,0.018) 0, rgba(15,23,42,0.018) 1px, transparent 1px, transparent 28px);
        border: 1px solid #dbe2ea;
        border-radius: 18px;
        box-shadow: 0 16px 34px rgba(15, 23, 42, 0.12);
        padding: 1.35rem 1.3rem 1.1rem;
        overflow: hidden;
    }
    .receipt-paper::before {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        height: 7px;
        background: linear-gradient(90deg, #4f46e5 0%, #0ea5e9 40%, #10b981 100%);
    }
    .receipt-head {
        position: relative;
        padding-top: 0.15rem;
    }
    .receipt-chips {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .receipt-chip {
        border-radius: 999px;
        padding: 0.26rem 0.62rem;
        font-size: 0.67rem;
        font-weight: 700;
        letter-spacing: 0.25px;
        text-transform: uppercase;
        background: #eef2ff;
        color: #4338ca;
        border: 1px solid #c7d2fe;
    }
    .receipt-chip-soft {
        background: #ecfdf5;
        color: #047857;
        border-color: #a7f3d0;
    }
    .receipt-logo {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #4f46e5 0%, #0ea5e9 100%);
        color: #fff;
        font-size: 1.05rem;
        box-shadow: 0 12px 22px rgba(37, 99, 235, 0.28);
    }
    .receipt-store {
        font-weight: 800;
        letter-spacing: -0.35px;
        color: #0f172a;
        font-size: 1.7rem;
    }
    .receipt-subtitle {
        color: #64748b;
        font-size: 0.9rem;
        font-weight: 600;
    }
    .receipt-dash {
        border-top: 2px dashed #cbd5e1;
    }
    .receipt-meta-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.65rem 0.7rem;
    }
    .receipt-meta-item {
        display: flex;
        flex-direction: column;
        gap: 0.15rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.58rem 0.7rem;
        text-align: center;
    }
    .meta-label {
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.45px;
        color: #64748b;
        font-weight: 700;
    }
    .meta-value {
        font-size: 0.92rem;
        font-weight: 700;
        color: #0f172a;
    }
    .receipt-table thead th {
        font-size: 0.69rem;
        text-transform: uppercase;
        letter-spacing: 0.55px;
        color: #64748b;
        border-bottom: 1px solid #dbe2ea;
        background: #f8fafc;
        padding: 0.62rem 0.72rem;
    }
    .receipt-table td {
        padding: 0.68rem 0.72rem;
        border-bottom: 1px dashed #e2e8f0;
        vertical-align: middle;
        font-size: 0.9rem;
    }
    .receipt-total-block {
        max-width: 290px;
        font-size: 0.9rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.68rem 0.75rem;
        margin: 0.25rem auto 0;
    }
    .receipt-total-row {
        border-top: 1px solid #cbd5e1;
        font-size: 1.05rem;
    }
    .receipt-note {
        color: #64748b;
        font-weight: 500;
    }

    @media print {
        .no-print,
        .navbar,
        .btn,
        .sidebar,
        .header-icon-container,
        .staff-container > .mb-4 {
            display: none !important;
        }
        main.py-4 {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }
        .staff-container {
            padding: 0 !important;
            margin: 0 !important;
        }
        .receipt-wrap {
            max-width: 100% !important;
        }
        .receipt-paper {
            box-shadow: none !important;
            border: none !important;
            border-radius: 0 !important;
            padding: 0 !important;
            background: #fff !important;
        }
        .receipt-paper::before {
            display: none !important;
        }
        .receipt-table thead th {
            background: transparent !important;
        }
        .receipt-meta-item,
        .receipt-total-block {
            background: transparent !important;
            border: 1px solid #dbe2ea !important;
        }
    }

    @media (max-width: 767.98px) {
        .receipt-wrap {
            padding: 0.35rem;
        }
        .receipt-paper {
            padding: 1rem 0.85rem 0.9rem;
        }
        .receipt-store {
            font-size: 1.45rem;
        }
        .receipt-meta-grid {
            grid-template-columns: 1fr;
        }
        .receipt-meta-item.text-end {
            text-align: center !important;
        }
        .receipt-total-block {
            max-width: 100%;
        }
    }
</style>
@endsection
