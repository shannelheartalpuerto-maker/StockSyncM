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
    .inv-table thead th {
        background: #f8faff;
        font-size: 0.71rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .6px;
        color: #6b7280;
        border-bottom: 2px solid #e5e7eb;
        padding: 0.85rem 1rem;
        white-space: nowrap;
    }
    .inv-table td {
        padding: 0.85rem 1rem;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }
    .inv-table tbody tr:last-child td { border-bottom: none; }
    .inv-table tbody tr:hover { background: #fafbff; }
    /* Stable modal stack + clickability (same behavior as admin fixes). */
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
    .inventory-search-group {
        background: white;
        border-radius: 12px;
        padding: 5px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
    }
    .inventory-search-group .form-control, 
    .inventory-search-group .form-select {
        border: none;
        box-shadow: none;
    }
    .inventory-search-group .input-group-text {
        background: transparent;
        border: none;
    }
    .inventory-search-group .btn-primary {
        border-radius: 10px;
        padding: 0.5rem 1.5rem;
    }
    .scan-btn-pulse {
        color: var(--primary-color);
        background: #eef2ff;
        border: none;
        border-radius: 10px;
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    .scan-btn-pulse:hover {
        background: var(--primary-color);
        color: white;
        transform: scale(1.05);
    }
</style>
@endpush
<div class="container-fluid px-4 staff-container animate-fade-up">
    <div class="inv-topbar mb-4">
        <div class="inv-topbar-inner">
            <div class="inv-title-wrap">
                <span class="inv-title-icon"><i class="fa-solid fa-boxes-stacked"></i></span>
                <h5 class="inv-title-text">Staff Inventory</h5>
            </div>
            <div class="inv-header-actions">
                <span class="inv-head-pill"><i class="fa-solid fa-box"></i>{{ number_format($totalItems) }} Items</span>
                <span class="inv-head-pill"><i class="fa-solid fa-triangle-exclamation"></i>{{ number_format($lowStockCount) }} Low Stock</span>
            </div>
        </div>
    </div>

    <!-- Stat Cards Section (Matching Dashboard) -->
    <div class="row g-4 mb-5">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-label">Total Items</span>
                    <div class="stat-icon icon-primary"><i class="fa-solid fa-boxes-stacked"></i></div>
                </div>
                <h3 class="stat-value">{{ number_format($totalItems) }}</h3>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-label text-danger">Low Stock</span>
                    <div class="stat-icon icon-danger"><i class="fa-solid fa-triangle-exclamation"></i></div>
                </div>
                <h3 class="stat-value text-danger">{{ number_format($lowStockCount) }}</h3>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-label text-dark">Out of Stock</span>
                    <div class="stat-icon icon-dark" style="background-color: #f3f4f6; color: #1f2937;"><i class="fa-solid fa-ban"></i></div>
                </div>
                <h3 class="stat-value text-dark">{{ number_format($outOfStockCount) }}</h3>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-label text-success">Good Stock</span>
                    <div class="stat-icon icon-success"><i class="fa-solid fa-check-circle"></i></div>
                </div>
                <h3 class="stat-value text-success">{{ number_format($goodStockCount) }}</h3>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="content-card">
                <div class="card-header-custom d-flex justify-content-between align-items-center">
                    <h5 class="card-title-custom mb-0"><i class="fa-solid fa-list-check me-2 text-primary"></i>Live Inventory Stock</h5>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-secondary rounded-pill px-3" onclick="location.reload()">
                            <i class="fa-solid fa-rotate me-1"></i> Refresh
                        </button>
                    </div>
                </div>

                <div class="card-body-custom">
                    <!-- Filter Form -->
                    <form action="{{ route('staff.inventory') }}" method="GET" class="mb-4" id="staffInventoryFilterForm">
                        <div class="row g-3">
                            <div class="col-lg-5 col-md-12">
                                <div class="inventory-search-group">
                                    <span class="px-3 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                                    <input type="text" name="search" id="searchInput" class="form-control" placeholder="Search by name, SKU or barcode..." value="{{ request('search') }}">
                                    <button class="scan-btn-pulse me-2" type="button" id="scanBtn" title="Scan Barcode">
                                        <i class="fa-solid fa-barcode"></i>
                                    </button>
                                    <button class="btn btn-primary px-4" type="submit">Search</button>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-12">
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <select name="category" class="form-select border-0 bg-light shadow-none" onchange="this.form.submit()">
                                            <option value="all">All Categories</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="status" class="form-select border-0 bg-light shadow-none" onchange="this.form.submit()">
                                            <option value="all">All Status</option>
                                            <option value="out" {{ request('status') == 'out' ? 'selected' : '' }}>Out of Stock</option>
                                            <option value="low" {{ request('status') == 'low' ? 'selected' : '' }}>Low Stock</option>
                                            <option value="good" {{ request('status') == 'good' ? 'selected' : '' }}>Good Stock</option>
                                            <option value="over" {{ request('status') == 'over' ? 'selected' : '' }}>Overstock</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex gap-2">
                                            <select name="brand" class="form-select border-0 bg-light shadow-none" onchange="this.form.submit()">
                                                <option value="all">All Brands</option>
                                                @isset($brands)
                                                    @foreach($brands as $brand)
                                                        <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                            <a href="{{ route('staff.inventory') }}" class="btn btn-outline-secondary px-3" title="Reset Filters">
                                                <i class="fa-solid fa-xmark"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div id="inventory-container" class="animate-fade-up">
                        @include('staff.partials.inventory_table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inventoryContainer = document.getElementById('inventory-container');
        const filterForm = document.getElementById('staffInventoryFilterForm');
        const anim = (el) => { if(!el) return; el.classList.remove('animate-fade-up'); void el.offsetWidth; el.classList.add('animate-fade-up'); setTimeout(()=>el.classList.remove('animate-fade-up'), 600); };

        // Debounce function
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Helper to move modals to body (fixes stacking context issues)
        function moveModalsToBody() {
            if (!inventoryContainer) return;
            const modals = inventoryContainer.querySelectorAll('.modal');
            modals.forEach(modal => {
                document.body.appendChild(modal);
            });
        }

        // Intercept filter form submit for AJAX load + animation
        if (filterForm && inventoryContainer) {
            filterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const url = filterForm.action + (filterForm.action.includes('?') ? '&' : '?') + new URLSearchParams(new FormData(filterForm)).toString();
                inventoryContainer.style.opacity = '0.5';
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    }
                })
                .then(resp => resp.text())
                .then(html => {
                    cleanupOldModals();
                    inventoryContainer.innerHTML = html;
                    inventoryContainer.style.opacity = '1';
                    anim(inventoryContainer);
                    moveModalsToBody();
                })
                .catch(err => {
                    console.error(err);
                    filterForm.submit();
                });
            });

            // Auto-search on input
            const searchInput = filterForm.querySelector('input[name="search"]');
            if (searchInput) {
                searchInput.addEventListener('input', debounce(function() {
                    filterForm.dispatchEvent(new Event('submit', { cancelable: true }));
                }, 500));
            }
        }

        // Helper to remove old modals before loading new content
        function cleanupOldModals() {
            // Remove any existing inventory modals that were moved to body
            const oldModals = document.querySelectorAll('div[id^="reportDamageModal"]');
            oldModals.forEach(modal => modal.remove());
            
            // Cleanup backdrops just in case
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(backdrop => backdrop.remove());
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        }

        // Initial move on page load
        moveModalsToBody();

        if (inventoryContainer) {
            inventoryContainer.addEventListener('click', function(e) {
                // Target pagination links specifically
                const link = e.target.closest('.pagination .page-link');
                if (link) {
                    e.preventDefault();
                    e.stopPropagation(); // Stop bubbling
                    
                    const url = link.getAttribute('href');
                    if (!url || url === '#') return;

                    inventoryContainer.style.opacity = '0.5';
                    
                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.text();
                    })
                    .then(html => {
                        // 1. Cleanup old modals (from previous page)
                        cleanupOldModals();

                        // 2. Update content
                        inventoryContainer.innerHTML = html;
                        inventoryContainer.style.opacity = '1';
                        anim(inventoryContainer);
                        
                        // 3. Move new modals to body
                        moveModalsToBody();
                    })
                    .catch(error => {
                        console.error('Error loading inventory:', error);
                        inventoryContainer.style.opacity = '1';
                        // Fallback to normal navigation if fetch fails
                        window.location.href = url;
                    });
                }
            });
        }
    });
</script>

@endsection

@push('scripts')
<!-- Scanner Modal -->
<div class="modal smooth-modal" id="scannerModal" tabindex="-1" aria-labelledby="scannerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white border-0 p-4">
                <h5 class="modal-title fw-bold" id="scannerModalLabel"><i class="fa-solid fa-barcode me-2"></i>Scan Barcode</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="position-relative bg-dark rounded-4 overflow-hidden shadow-inner mb-4">
                    <video id="video" class="w-100" style="max-height: 300px; object-fit: cover;"></video>
                    <div class="scanner-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; display: flex; align-items: center; justify-content: center; pointer-events: none;">
                        <div style="width: 70%; height: 50%; border: 2px solid rgba(255,255,255,0.8); box-shadow: 0 0 0 9999px rgba(0,0,0,0.5); border-radius: 12px;"></div>
                        <div class="scanner-line" style="position: absolute; top: 50%; left: 15%; right: 15%; height: 2px; background: rgba(255, 0, 0, 0.8); box-shadow: 0 0 8px red;"></div>
                    </div>
                </div>
                <div class="p-3 bg-light rounded-3">
                    <select id="sourceSelect" class="form-select border-0 bg-white shadow-sm mb-2" style="display: none;"></select>
                    <p class="text-muted small fw-600 mb-0" id="scannerStatus">Initializing camera...</p>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="button" class="btn btn-light px-4 rounded-3" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let codeReader;
        let selectedDeviceId;
        const scanBtn = document.getElementById('scanBtn');
        const modalElement = document.getElementById('scannerModal');
        const scannerModal = new bootstrap.Modal(modalElement);
        const searchInput = document.getElementById('searchInput');
        const sourceSelect = document.getElementById('sourceSelect');
        const statusText = document.getElementById('scannerStatus');
        
        if(scanBtn) {
            scanBtn.addEventListener('click', function () {
                scannerModal.show();
            });
        }

        modalElement.addEventListener('shown.bs.modal', function () {
            if (typeof ZXing === 'undefined') {
                statusText.textContent = "Scanner library not loaded.";
                return;
            }

            codeReader = new ZXing.BrowserMultiFormatReader();
            statusText.textContent = "Starting camera...";
            
            codeReader.listVideoInputDevices()
                .then((videoInputDevices) => {
                    sourceSelect.innerHTML = '';
                    if (videoInputDevices.length >= 1) {
                        videoInputDevices.forEach((element) => {
                            const sourceOption = document.createElement('option');
                            sourceOption.text = element.label;
                            sourceOption.value = element.deviceId;
                            sourceSelect.appendChild(sourceOption);
                        });

                        sourceSelect.onchange = () => {
                            selectedDeviceId = sourceSelect.value;
                            startScanning(selectedDeviceId);
                        };

                        if(videoInputDevices.length > 1) {
                            sourceSelect.style.display = 'block';
                        }

                        // Prefer back camera
                        const backCamera = videoInputDevices.find(device => device.label.toLowerCase().includes('back') || device.label.toLowerCase().includes('environment'));
                        selectedDeviceId = backCamera ? backCamera.deviceId : videoInputDevices[0].deviceId;
                        
                        sourceSelect.value = selectedDeviceId;
                        startScanning(selectedDeviceId);
                    } else {
                        statusText.textContent = "No camera found.";
                    }
                })
                .catch((err) => {
                    console.error(err);
                    statusText.textContent = "Error accessing camera: " + err;
                });
        });

        modalElement.addEventListener('hidden.bs.modal', function () {
            if (codeReader) {
                codeReader.reset();
                codeReader = null;
            }
            statusText.textContent = "Camera stopped.";
        });

        function startScanning(deviceId) {
            codeReader.decodeFromVideoDevice(deviceId, 'video', (result, err) => {
                if (result) {
                    console.log(result);
                    searchInput.value = result.text;
                    scannerModal.hide();
                    
                    // Create a visual flash effect on the input
                    searchInput.style.backgroundColor = '#e8f5e9';
                    setTimeout(() => {
                        searchInput.style.backgroundColor = '';
                        // Auto submit
                        searchInput.form.submit();
                    }, 500);
                }
                if (err && !(err instanceof ZXing.NotFoundException)) {
                    // console.error(err); // Ignore frequent scan errors
                }
            });
        }
    });
</script>
@endpush
