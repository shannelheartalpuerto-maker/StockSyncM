@foreach($brands as $brand)
<tr>
    <td class="ps-4">
        <div class="fw-bold text-dark">{{ $brand->name }}</div>
        <div class="text-muted small">ID: #B-{{ str_pad($brand->id, 3, '0', STR_PAD_LEFT) }}</div>
    </td>
    <td>
        <span class="status-badge status-info">
            <i class="fa-solid fa-copyright small me-1"></i>{{ $brand->products->count() }} Products
        </span>
    </td>
    <td class="text-end pe-4">
        <div class="btn-group shadow-sm rounded-3 overflow-hidden">
            <button type="button" class="btn btn-white btn-sm border-end" data-bs-toggle="modal" data-bs-target="#ajax-editBrandModal{{ $brand->id }}" title="Edit">
                <i class="fa-solid fa-pen-to-square text-primary"></i>
            </button>
            <button type="button" class="btn btn-white btn-sm text-danger" data-bs-toggle="modal" data-bs-target="#ajax-deleteBrandModal{{ $brand->id }}" title="Delete">
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>
    </td>
</tr>
@endforeach
