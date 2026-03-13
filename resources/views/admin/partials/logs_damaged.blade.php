<div class="table-responsive">
    <table class="table table-hover align-middle custom-table">
        <thead>
            <tr>
                <th class="ps-4">Date & Time</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>User</th>
                <th class="text-end pe-4">Notes</th>
            </tr>
        </thead>
        <tbody>
            @forelse($damagedStocks as $log)
            <tr>
                <td class="ps-4">
                    <div class="fw-bold text-dark">{{ $log->created_at->format('M d, Y') }}</div>
                    <div class="text-muted small">{{ $log->created_at->format('h:i A') }}</div>
                </td>
                <td>
                    <div class="fw-bold text-dark">{{ $log->product->name ?? 'Deleted Product' }}</div>
                    <div class="text-muted small">{{ $log->product->code ?? '-' }}</div>
                </td>
                <td><span class="status-badge status-danger">-{{ $log->quantity }}</span></td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                            <i class="fa-solid fa-user small text-muted"></i>
                        </div>
                        <span class="text-dark fw-medium">{{ $log->user->name ?? 'System' }}</span>
                    </div>
                </td>
                <td class="text-end pe-4">
                    <button type="button" class="btn btn-white btn-sm shadow-sm px-3" data-bs-toggle="modal" data-bs-target="#damagedDetailsModal{{ $log->id }}">
                        <i class="fa-solid fa-eye me-1 text-primary"></i>View
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-5">
                    <i class="fa-solid fa-folder-open fa-3x mb-3 text-muted opacity-25"></i>
                    <p class="text-muted">No damaged stock records found.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $damagedStocks->appends(['in_page' => $stockIns->currentPage(), 'returned_page' => $returnedStocks->currentPage(), 'out_page' => $stockOuts->currentPage(), 'period' => $period])->links() }}
</div>

<!-- Damaged Details Modals -->
@foreach($damagedStocks as $log)
<div class="modal fade" id="damagedDetailsModal{{ $log->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center">
                    <div class="bg-danger bg-opacity-10 p-2 rounded-3 me-3">
                        <i class="fa-solid fa-triangle-exclamation text-danger fs-4"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold">Damaged Report Details</h5>
                        <p class="text-muted small mb-0">{{ $log->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="bg-light rounded-4 p-3 mb-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Product</label>
                            <p class="mb-0 fw-bold text-dark">{{ $log->product->name ?? 'Deleted Product' }}</p>
                            <small class="text-muted">{{ $log->product->code ?? '-' }}</small>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted fw-bold text-uppercase">Quantity Damaged</label>
                            <div><span class="status-badge status-danger">-{{ $log->quantity }}</span></div>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted fw-bold text-uppercase">Reported By</label>
                            <p class="mb-0 text-dark fw-medium">{{ $log->user->name ?? 'System' }}</p>
                        </div>
                    </div>
                </div>
                <div class="mb-0">
                    <label class="small text-muted fw-bold text-uppercase mb-2">Notes / Reason</label>
                    <div class="p-3 bg-white border rounded-3 text-break">
                        {{ $log->notes ?? 'No notes provided.' }}
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
    (function() {
        var modalIds = [
            @foreach($damagedStocks as $log)
                "damagedDetailsModal{{ $log->id }}",
            @endforeach
        ];

        modalIds.forEach(function(id) {
            // Remove any existing zombie modals from body (from previous AJAX loads)
            var existing = document.querySelectorAll('body > #' + id);
            existing.forEach(function(el) { el.remove(); });

            // Move the new modal to body to avoid backdrop/z-index issues
            var modal = document.getElementById(id);
            if (modal) {
                document.body.appendChild(modal);
            }
        });
    })();
</script>
