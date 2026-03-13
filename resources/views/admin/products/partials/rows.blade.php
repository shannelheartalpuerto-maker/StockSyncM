@foreach($products as $product)
<tr>
    {{-- Product (image + name + ID combined) --}}
    <td style="padding-left:1.5rem;">
        <div class="d-flex align-items-center gap-3">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}"
                     alt=""
                     class="prod-thumb"
                     onerror="this.style.display='none'">
            @else
                <div class="prod-thumb-placeholder">
                    <i class="fa-solid fa-image"></i>
                </div>
            @endif
            <div>
                <div class="fw-semibold text-dark" style="font-size:.9rem;">{{ $product->name }}</div>
                <div class="text-muted" style="font-size:.75rem;">ID&nbsp;#{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</div>
            </div>
        </div>
    </td>

    {{-- SKU / Code --}}
    <td><span class="sku-badge">{{ $product->code }}</span></td>

    {{-- Category --}}
    <td><span class="text-secondary" style="font-size:.875rem;">{{ $product->category->name ?? 'N/A' }}</span></td>

    {{-- Brand --}}
    <td><span class="text-secondary" style="font-size:.875rem;">{{ $product->brand->name ?? 'N/A' }}</span></td>

    {{-- Price --}}
    <td><span class="fw-semibold text-dark">₱{{ number_format($product->price, 2) }}</span></td>

    {{-- Stock quantity --}}
    <td>
        <span class="fw-bold {{ $product->quantity <= $product->low_stock_threshold ? 'text-danger' : 'text-dark' }}">
            {{ $product->quantity }}
        </span>
    </td>

    {{-- Status badge --}}
    <td>
        @if($product->quantity <= 0)
            <span class="status-badge status-danger"><i class="fa-solid fa-circle-xmark me-1"></i>Out of Stock</span>
        @elseif($product->quantity <= $product->low_stock_threshold)
            <span class="status-badge status-warning"><i class="fa-solid fa-triangle-exclamation me-1"></i>Low Stock</span>
        @elseif($product->quantity >= $product->overstock_threshold)
            <span class="status-badge status-info"><i class="fa-solid fa-arrow-up me-1"></i>Overstock</span>
        @else
            <span class="status-badge status-success"><i class="fa-solid fa-circle-check me-1"></i>Good Stock</span>
        @endif
    </td>

    {{-- Single dropdown action button --}}
    <td class="text-center">
        <div class="dropdown">
            <button class="action-menu-btn" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false"
                    data-bs-boundary="viewport" title="Actions">
                <i class="fa-solid fa-ellipsis-vertical"></i>
            </button>
            <ul class="dropdown-menu action-dropdown-menu dropdown-menu-end">
                <li>
                    <button type="button" class="dropdown-item"
                            data-bs-toggle="modal" data-bs-target="#ajax-editProductModal{{ $product->id }}">
                        <span class="action-icon-wrap" style="background:#e0e7ff;">
                            <i class="fa-solid fa-pen text-primary"></i>
                        </span>
                        Edit Product
                    </button>
                </li>
                <li>
                    <button type="button" class="dropdown-item"
                            data-bs-toggle="modal" data-bs-target="#ajax-stockInModal{{ $product->id }}">
                        <span class="action-icon-wrap" style="background:#dcfce7;">
                            <i class="fa-solid fa-arrow-down text-success"></i>
                        </span>
                        Stock In
                    </button>
                </li>
                <li>
                    <button type="button" class="dropdown-item"
                            data-bs-toggle="modal" data-bs-target="#ajax-damagedModal{{ $product->id }}">
                        <span class="action-icon-wrap" style="background:#fef3c7;">
                            <i class="fa-solid fa-triangle-exclamation text-warning"></i>
                        </span>
                        Report Damage
                    </button>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <button type="button" class="dropdown-item item-danger"
                            data-bs-toggle="modal" data-bs-target="#ajax-deleteModal{{ $product->id }}">
                        <span class="action-icon-wrap" style="background:#fee2e2;">
                            <i class="fa-solid fa-trash text-danger"></i>
                        </span>
                        Delete
                    </button>
                </li>
            </ul>
        </div>
    </td>
</tr>
@endforeach
