<div class="table-responsive">
    <table class="table align-middle">
        <thead>
            <tr>
                <th>Date / Time</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Staff</th>
                <th class="text-end">Details</th>
            </tr>
        </thead>
        <tbody>
            @forelse($returnedItems as $log)
            <tr>
                <td class="text-muted small">
                    <div class="fw-600 text-dark">{{ $log->created_at->format('M d, Y') }}</div>
                    {{ $log->created_at->format('h:i A') }}
                </td>
                <td>
                    <div class="fw-bold text-dark">{{ $log->product->name ?? 'Deleted Product' }}</div>
                    <div class="text-muted small code-font">{{ $log->product->code ?? '-' }}</div>
                </td>
                <td>
                    <span class="badge bg-soft-success text-success px-3 py-2 rounded-pill fw-bold">+{{ $log->quantity }}</span>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-2 bg-light rounded-circle d-flex align-items-center justify-content-center text-primary fw-bold" style="width: 32px; height: 32px; font-size: 0.8rem;">
                            {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                        </div>
                        <span class="small fw-600">{{ $log->user->name ?? 'System' }}</span>
                    </div>
                </td>
                <td class="text-end">
                    <button type="button" class="btn btn-sm btn-light border rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#returnDetailsModal{{ $log->id }}">
                        <i class="fa-solid fa-eye me-1"></i> View
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted py-5">
                    <i class="fa-solid fa-inbox fs-2 mb-3 d-block opacity-25"></i>
                    No returned items found for this period.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4 d-flex justify-content-center">
    {{ $returnedItems->appends(request()->query())->links() }}
</div>

<!-- Return Details Modals -->
@foreach($returnedItems as $log)
@php
    $noteParts = explode('|', $log->notes);
    $transactionRef = trim($noteParts[0]);
    $reasonText = isset($noteParts[1]) ? trim(str_replace('Reason:', '', $noteParts[1])) : 'No specific reason provided';
    
    if (count($noteParts) === 1 && str_contains($log->notes, 'Return of Transaction')) {
        $transactionRef = $log->notes;
        $reasonText = 'No reason recorded for this transaction';
    } elseif (count($noteParts) === 1) {
         $transactionRef = 'Manual Entry';
         $reasonText = $log->notes;
    }
@endphp
<div class="modal fade" id="returnDetailsModal{{ $log->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-success text-white border-0 p-4">
                <h5 class="modal-title fw-bold">
                    <i class="fa-solid fa-rotate-left me-2"></i>Return Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-3">
                    <div class="me-3">
                        <div class="bg-white border rounded d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px;">
                            <i class="fa-solid fa-receipt text-success fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-muted small fw-600 text-uppercase">Reference</div>
                        <div class="fw-bold text-dark">{{ $transactionRef }}</div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-6">
                        <label class="small text-muted fw-bold text-uppercase mb-1 d-block">Date & Time</label>
                        <p class="mb-0 text-dark fw-600">{{ $log->created_at->format('M d, Y') }}</p>
                        <p class="text-muted small mb-0">{{ $log->created_at->format('h:i A') }}</p>
                    </div>
                    <div class="col-6">
                        <label class="small text-muted fw-bold text-uppercase mb-1 d-block">Processed By</label>
                        <p class="mb-0 text-dark fw-600">{{ $log->user->name ?? 'System' }}</p>
                    </div>
                    <div class="col-12">
                        <hr class="my-0 opacity-10">
                    </div>
                    <div class="col-12">
                        <label class="small text-muted fw-bold text-uppercase mb-1 d-block">Product</label>
                        <div class="fw-bold text-dark fs-5">{{ $log->product->name ?? 'Deleted Product' }}</div>
                        <div class="text-muted small code-font">{{ $log->product->code ?? '-' }}</div>
                    </div>
                    <div class="col-12">
                        <label class="small text-muted fw-bold text-uppercase mb-1 d-block">Quantity Restocked</label>
                        <div><span class="badge bg-soft-success text-success px-3 py-2 rounded-pill fw-bold">+{{ $log->quantity }} Items</span></div>
                    </div>
                    <div class="col-12">
                        <label class="small text-muted fw-bold text-uppercase mb-2 d-block">Reason for Return</label>
                        <div class="p-3 bg-light border rounded-3 text-break text-dark">
                            {{ $reasonText }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="button" class="btn btn-light px-4 rounded-3" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
    (function() {
        var modalIds = [
            @foreach($returnedItems as $log)
                "returnDetailsModal{{ $log->id }}",
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
