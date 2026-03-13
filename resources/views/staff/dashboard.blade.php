@extends('layouts.app')

@section('content')
@push('styles')
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
    .db-tab-strip {
        background: transparent;
        border-radius: 0;
        padding: 0;
        gap: 0.65rem;
        border: none;
        border-bottom: none;
    }
    .db-tab-strip .nav-link {
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.95rem;
        color: #6b7280;
        padding: 0.65rem 1.35rem;
        border: 1px solid #dbe2ea;
        transition: all .18s ease;
        white-space: nowrap;
        background: #fff;
    }
    .db-tab-strip .nav-link.active {
        background: #f8fafc !important;
        color: #4f46e5 !important;
        border-color: #c7d2fe;
        box-shadow: 0 2px 8px rgba(79,70,229,.14) !important;
    }
    .db-tab-strip .nav-link:hover:not(.active) {
        color: #4f46e5 !important;
        background: #f8fafc !important;
        border-color: #d6ddeb;
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

    /* Mobile Filter Dropdown */
    .mobile-filter-btn {
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        border: none;
        background: rgba(255,255,255,.16);
    }
    .mobile-filter-btn:hover, .mobile-filter-btn.active {
        background: rgba(255,255,255,.25);
        color: #fff;
    }
    .mobile-filter-dropdown {
        margin-top: 0.75rem;
        position: relative;
        z-index: 1;
    }
    .mobile-filter-content {
        background: rgba(255,255,255,.1);
        border-radius: 12px;
        padding: 1rem;
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,.2);
    }
    .mobile-filter-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }
    .mobile-filter-field {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    .mobile-filter-label {
        font-size: 0.7rem;
        font-weight: 650;
        color: #fff;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0;
    }
    .mobile-filter-field .form-control {
        background: rgba(255,255,255,.9);
        border: 1px solid rgba(255,255,255,.3);
        border-radius: 8px;
        font-size: 0.75rem;
        padding: 0.4rem 0.6rem;
    }
    .mobile-filter-field .form-control:focus {
        background: #fff;
        border-color: rgba(255,255,255,.6);
        box-shadow: 0 0 0 2px rgba(255,255,255,.2);
    }
    .mobile-filter-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        margin-top: 0.25rem;
    }
    .mobile-filter-actions .btn {
        font-size: 0.7rem;
        padding: 0.35rem 0.8rem;
        border-radius: 8px;
        font-weight: 650;
    }
    .mobile-filter-actions .btn-primary {
        background: rgba(255,255,255,.2);
        border-color: rgba(255,255,255,.4);
        color: #fff;
    }
    .mobile-filter-actions .btn-primary:hover {
        background: rgba(255,255,255,.3);
        border-color: rgba(255,255,255,.5);
    }
    .mobile-filter-actions .btn-outline-secondary {
        background: transparent;
        border-color: rgba(255,255,255,.3);
        color: rgba(255,255,255,.9);
    }
    .mobile-filter-actions .btn-outline-secondary:hover {
        background: rgba(255,255,255,.1);
        border-color: rgba(255,255,255,.4);
        color: #fff;
    }

    @media (min-width: 768px) {
        .mobile-filter-btn {
            display: none !important;
        }
        .mobile-filter-dropdown {
            display: none !important;
        }
    }
</style>
@endpush
<div class="container-fluid px-4 staff-container animate-fade-up">

    {{-- ═══ Mobile Header (mirrors inv-topbar + quick access, mobile only) ═══ --}}
    <div class="mobile-topbar-card" style="display:none;">
        <div class="inv-topbar-inner">
            <div class="inv-title-wrap">
                <span class="inv-title-icon"><i class="fa-solid fa-gauge-high"></i></span>
                <h5 class="inv-title-text">Staff Dashboard</h5>
            </div>
            <div class="inv-header-actions">
                <span class="inv-head-pill"><i class="fa-solid fa-triangle-exclamation"></i>{{ number_format($outOfStockCount + $lowStockCount) }} Alerts</span>
                <span class="inv-head-pill"><i class="fa-solid fa-peso-sign"></i>₱{{ number_format($todayRevenue, 2) }} Today</span>
            </div>
        </div>
        <div class="mobile-topbar-actions">
            <a href="{{ route('staff.pos') }}" class="mobile-topbar-btn">
                <i class="fa-solid fa-cash-register"></i> POS
            </a>
            <a href="{{ route('staff.inventory') }}" class="mobile-topbar-btn">
                <i class="fa-solid fa-boxes-stacked"></i> Inventory
            </a>
        </div>
    </div>


    <div class="inv-topbar mb-4">
        <div class="inv-topbar-inner">
            <div class="inv-title-wrap">
                <span class="inv-title-icon"><i class="fa-solid fa-gauge-high"></i></span>
                <h5 class="inv-title-text">Staff Dashboard</h5>
            </div>
            <div class="inv-header-actions">
                <span class="inv-head-pill"><i class="fa-solid fa-triangle-exclamation"></i>{{ number_format($outOfStockCount + $lowStockCount) }} Alerts</span>
                <span class="inv-head-pill"><i class="fa-solid fa-peso-sign"></i>₱{{ number_format($todayRevenue, 2) }} Today</span>
                <button class="inv-head-pill mobile-filter-btn d-none" id="salesFilterBtn" type="button">
                    <i class="fa-solid fa-filter"></i> Filters
                </button>
            </div>
        </div>

        <!-- Mobile Sales Filter Dropdown -->
        <div class="mobile-filter-dropdown collapse" id="mobileFilterDropdown">
            <div class="mobile-filter-content">
                <form action="{{ route('staff.dashboard') }}" method="GET" id="mobileSalesFilterForm">
                    <input type="hidden" name="tab" value="sales">
                    <div class="mobile-filter-grid">
                        <div class="mobile-filter-field">
                            <label class="mobile-filter-label">Start Date</label>
                            <input type="date" name="start_date" class="form-control form-control-sm" value="{{ request('start_date') }}">
                        </div>
                        <div class="mobile-filter-field">
                            <label class="mobile-filter-label">End Date</label>
                            <input type="date" name="end_date" class="form-control form-control-sm" value="{{ request('end_date') }}">
                        </div>
                        <div class="mobile-filter-field">
                            <label class="mobile-filter-label">Search TRX</label>
                            <input type="text" name="search" class="form-control form-control-sm" placeholder="Transaction #..." value="{{ request('search') }}">
                        </div>
                        <div class="mobile-filter-actions">
                            <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                            <a href="{{ route('staff.dashboard') }}?tab=sales" class="btn btn-outline-secondary btn-sm">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="d-flex justify-content-center mb-4">
        <ul class="nav db-tab-strip" id="dashboardTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="product-tab" data-bs-toggle="tab" data-bs-target="#product" type="button" role="tab" aria-controls="product" aria-selected="true">
                    <i class="fa-solid fa-box me-2"></i>Product Data
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="sales-tab" data-bs-toggle="tab" data-bs-target="#sales" type="button" role="tab" aria-controls="sales" aria-selected="false">
                    <i class="fa-solid fa-chart-line me-2"></i>Sales Analytics
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="forecast-tab" data-bs-toggle="tab" data-bs-target="#forecast" type="button" role="tab" aria-controls="forecast" aria-selected="false">
                    <i class="fa-solid fa-bell me-2"></i>Stock Alerts
                </button>
            </li>
        </ul>
    </div>

    <div class="tab-content" id="dashboardTabsContent">
        <!-- Product Data Tab -->
        <div class="tab-pane fade show active" id="product" role="tabpanel" aria-labelledby="product-tab">
            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">Total Products</span>
                            <div class="stat-icon icon-primary">
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                        </div>
                        <h3 class="stat-value">{{ number_format($totalProducts) }}</h3>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">Total Stock</span>
                            <div class="stat-icon icon-info">
                                <i class="fa-solid fa-layer-group"></i>
                            </div>
                        </div>
                        <h3 class="stat-value">{{ number_format($totalStock) }}</h3>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">Total Categories</span>
                            <div class="stat-icon icon-warning">
                                <i class="fa-solid fa-tags"></i>
                            </div>
                        </div>
                        <h3 class="stat-value">{{ number_format($totalCategories) }}</h3>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">Top Mover</span>
                            <div class="stat-icon icon-success">
                                <i class="fa-solid fa-fire"></i>
                            </div>
                        </div>
                        <h3 class="stat-value">{{ $topMovingProduct }}</h3>
                    </div>
                </div>
            </div>

            <div class="content-card">
                <div class="card-header-custom">
                    <h5 class="card-title-custom">Stock Level Monitoring</h5>
                </div>
                <div class="card-body-custom p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Product</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Stock Level</th>
                                    <th class="text-end pe-4">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stockLevels as $product)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="rounded-circle me-3" width="40" height="40" style="object-fit: cover;">
                                            @else
                                                <div class="rounded-circle me-3 d-flex align-items-center justify-content-center bg-light text-secondary" style="width: 40px; height: 40px;">
                                                    <i class="fa-solid fa-box"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0 fw-bold">{{ $product->name }}</h6>
                                                <small class="text-muted">{{ $product->code }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                                    <td>{{ $product->brand->name ?? 'N/A' }}</td>
                                    <td>
                                        <div class="progress" style="height: 8px;">
                                            @php
                                                $percentage = ($product->quantity / max(1, $product->good_stock_threshold)) * 100;
                                                $color = 'success';
                                                if($product->quantity <= $product->low_stock_threshold) $color = 'warning';
                                                if($product->quantity <= 0) $color = 'danger';
                                            @endphp
                                            <div class="progress-bar bg-{{ $color }}" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <span class="fw-bold">{{ $product->quantity }}</span> <span class="text-muted">units</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">No stock data available.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Tab -->
        <div class="tab-pane fade" id="sales" role="tabpanel" aria-labelledby="sales-tab">
            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">Today's Revenue</span>
                            <div class="stat-icon icon-success">
                                <i class="fa-solid fa-dollar-sign"></i>
                            </div>
                        </div>
                        <h3 class="stat-value">₱{{ number_format($todayRevenue, 2) }}</h3>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">Transactions Today</span>
                            <div class="stat-icon icon-info">
                                <i class="fa-solid fa-receipt"></i>
                            </div>
                        </div>
                        <h3 class="stat-value">{{ number_format($todayTransactions) }}</h3>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">Items Sold Today</span>
                            <div class="stat-icon icon-warning">
                                <i class="fa-solid fa-shopping-basket"></i>
                            </div>
                        </div>
                        <h3 class="stat-value">{{ number_format($itemsSoldToday) }}</h3>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">My Avg Sale</span>
                            <div class="stat-icon icon-primary">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                        </div>
                        <h3 class="stat-value">₱{{ number_format($averageSale, 2) }}</h3>
                    </div>
                </div>
            </div>

            <div class="content-card mb-4 d-none d-md-block">
                <div class="card-header-custom d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <h5 class="card-title-custom mb-0"><i class="fa-solid fa-filter me-2"></i>Filter Transactions</h5>
                    <form action="{{ route('staff.dashboard') }}" method="GET" class="d-flex gap-2 flex-wrap align-items-center" id="filterForm">
                        <input type="hidden" name="tab" value="sales">
                        <div class="input-group input-group-sm" style="width: 180px;">
                            <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-calendar text-muted"></i></span>
                            <input type="date" name="start_date" class="form-control border-start-0" value="{{ request('start_date') }}" title="Start Date">
                        </div>
                        <div class="input-group input-group-sm" style="width: 180px;">
                            <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-calendar text-muted"></i></span>
                            <input type="date" name="end_date" class="form-control border-start-0" value="{{ request('end_date') }}" title="End Date">
                        </div>
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                            <input type="text" name="search" class="form-control border-start-0" placeholder="Search TRX #..." value="{{ request('search') }}">
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary px-3">Apply</button>
                        <a href="{{ route('staff.dashboard') }}?tab=sales" class="btn btn-sm btn-outline-secondary px-3">Reset</a>
                    </form>
                </div>
            </div>

            <div class="content-card">
                <div class="card-header-custom">
                    <h5 class="card-title-custom mb-0"><i class="fa-solid fa-list-check me-2"></i>My Transactions History</h5>
                </div>
                <div class="card-body-custom p-0" id="transactions-container">
                    @include('staff.partials.transactions_table')
                </div>
            </div>
        </div>

        <!-- Stock Alerts Tab -->
        <div class="tab-pane fade" id="forecast" role="tabpanel" aria-labelledby="forecast-tab">
            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">Low Stock</span>
                            <div class="stat-icon icon-danger">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </div>
                        </div>
                        <h3 class="stat-value text-danger">{{ number_format($lowStockCount) }}</h3>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">Good Stock</span>
                            <div class="stat-icon icon-success">
                                <i class="fa-solid fa-square-check"></i>
                            </div>
                        </div>
                        <h3 class="stat-value text-success">{{ number_format($goodStockCount) }}</h3>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">Excess Items</span>
                            <div class="stat-icon icon-info">
                                <i class="fa-solid fa-boxes-stacked"></i>
                            </div>
                        </div>
                        <h3 class="stat-value text-info">{{ number_format($overStockCount) }}</h3>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-label">Out of Stock</span>
                            <div class="stat-icon icon-dark" style="background-color: #f3f4f6; color: #1f2937;">
                                <i class="fa-solid fa-ban"></i>
                            </div>
                        </div>
                        <h3 class="stat-value text-dark">{{ number_format($outOfStockCount) }}</h3>
                    </div>
                </div>
            </div>

            <!-- Alert Summary Card -->
            <div class="content-card mb-4 border-start border-4 border-primary">
                <div class="card-body-custom">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="fw-bold text-primary mb-2"><i class="fa-solid fa-bell me-2"></i>Stock Alert Summary</h5>
                            <p class="text-secondary mb-0">
                                You currently have <strong>{{ number_format($lowStockCount) }} low-stock</strong> and <strong>{{ number_format($outOfStockCount) }} out-of-stock</strong> items that need immediate attention.
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <a href="{{ route('staff.inventory') }}" class="btn btn-primary rounded-pill px-4">
                                <i class="fa-solid fa-boxes-stacked me-2"></i>Manage Inventory
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="content-card h-100 overflow-hidden">
                        <div class="card-header-custom bg-light">
                            <h5 class="card-title-custom mb-0 text-warning"><i class="fa-solid fa-circle-exclamation me-2"></i>Priority Restock</h5>
                        </div>
                        <div class="card-body-custom p-0">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th class="ps-4">Product Name</th>
                                            <th class="text-end pe-4">Current Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($lowStockProducts as $product)
                                            <tr>
                                                <td class="ps-4">
                                                    <div class="fw-bold">{{ $product->name }}</div>
                                                    <small class="text-muted">{{ $product->code }}</small>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <span class="badge bg-soft-warning px-3 py-2 rounded-pill">{{ number_format($product->quantity) }} units</span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center py-5 text-muted">
                                                    <i class="fa-solid fa-check-circle fa-2x mb-3 d-block text-success opacity-50"></i>
                                                    No priority restock needed.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="content-card h-100 overflow-hidden">
                        <div class="card-header-custom bg-light">
                            <h5 class="card-title-custom mb-0 text-danger"><i class="fa-solid fa-ban me-2"></i>Out of Stock</h5>
                        </div>
                        <div class="card-body-custom p-0">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th class="ps-4">Product Name</th>
                                            <th class="text-end pe-4">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($outOfStockProducts as $product)
                                            <tr>
                                                <td class="ps-4">
                                                    <div class="fw-bold">{{ $product->name }}</div>
                                                    <small class="text-muted">{{ $product->code }}</small>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <span class="badge bg-soft-danger px-3 py-2 rounded-pill">Unavailable</span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center py-5 text-muted">
                                                    <i class="fa-solid fa-circle-check fa-2x mb-3 d-block text-success opacity-50"></i>
                                                    All products are currently in stock.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab Persistence
        const tabLinks = document.querySelectorAll('#dashboardTabs button[data-bs-toggle="tab"]');
        tabLinks.forEach(function(tab) {
            tab.addEventListener('shown.bs.tab', function (event) {
                localStorage.setItem('activeStaffDashboardTab', event.target.id);
            });
        });

        // Check for tab query parameter first
        const urlParams = new URLSearchParams(window.location.search);
        const tabParam = urlParams.get('tab');
        let activeTabId = null;

        if (tabParam) {
            activeTabId = `${tabParam}-tab`;
            localStorage.setItem('activeStaffDashboardTab', activeTabId);
        } else {
            activeTabId = localStorage.getItem('activeStaffDashboardTab');
        }

        if (activeTabId) {
            const activeTab = document.getElementById(activeTabId);
            if (activeTab) {
                if (typeof bootstrap !== 'undefined' && bootstrap.Tab) {
                    const tabInstance = new bootstrap.Tab(activeTab);
                    tabInstance.show();
                } else {
                    activeTab.click();
                }
            }
        }

        // Mobile Sales Filter Logic
        const salesFilterBtn = document.getElementById('salesFilterBtn');
        const mobileFilterDropdown = document.getElementById('mobileFilterDropdown');
        const salesTab = document.getElementById('sales-tab');

        function toggleMobileFilterButton() {
            if (salesFilterBtn) {
                // Show filter button only on mobile and when sales tab is active
                if (window.innerWidth <= 767.98 && salesTab && salesTab.classList.contains('active')) {
                    salesFilterBtn.classList.remove('d-none');
                } else {
                    salesFilterBtn.classList.add('d-none');
                    // Hide dropdown if button is hidden
                    if (mobileFilterDropdown && mobileFilterDropdown.classList.contains('show')) {
                        const bsCollapse = new bootstrap.Collapse(mobileFilterDropdown, { toggle: false });
                        bsCollapse.hide();
                    }
                }
            }
        }

        // Toggle filter dropdown
        if (salesFilterBtn && mobileFilterDropdown) {
            salesFilterBtn.addEventListener('click', function() {
                const bsCollapse = new bootstrap.Collapse(mobileFilterDropdown, { toggle: true });
                salesFilterBtn.classList.toggle('active');
            });

            // Remove active state when dropdown is hidden
            mobileFilterDropdown.addEventListener('hidden.bs.collapse', function() {
                salesFilterBtn.classList.remove('active');
            });
        }

        // Listen to tab changes to show/hide filter button
        tabLinks.forEach(function(tab) {
            tab.addEventListener('shown.bs.tab', function (event) {
                setTimeout(toggleMobileFilterButton, 10); // Small delay to ensure tab is active
            });
        });

        // Check on page load and resize
        toggleMobileFilterButton();
        window.addEventListener('resize', toggleMobileFilterButton);

        // AJAX Pagination for Transactions
        const transactionsContainer = document.getElementById('transactions-container');
        if (transactionsContainer) {
            transactionsContainer.addEventListener('click', function(e) {
                const link = e.target.closest('.pagination .page-link');
                if (link) {
                    e.preventDefault();
                    const url = link.getAttribute('href');
                    if (!url || url === '#') return;
                    
                    transactionsContainer.style.opacity = '0.5';
                    
                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        transactionsContainer.innerHTML = html;
                        transactionsContainer.style.opacity = '1';
                        // Scroll to container top
                        transactionsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    })
                    .catch(error => {
                        console.error('Error loading transactions:', error);
                        transactionsContainer.style.opacity = '1';
                    });
                }
            });
        }
    });
</script>
@endsection
