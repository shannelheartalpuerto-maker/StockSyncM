@foreach($categories as $category)
<tr>
    <td class="ps-4">
        <div class="fw-bold text-dark">{{ $category->name }}</div>
        <div class="text-muted small">ID: #C-{{ str_pad($category->id, 3, '0', STR_PAD_LEFT) }}</div>
    </td>
    <td>
        <span class="status-badge status-info">
            <i class="fa-solid fa-box small me-1"></i>{{ $category->products->count() }} Products
        </span>
    </td>
    <td class="text-end pe-4">
        <div class="btn-group shadow-sm rounded-3 overflow-hidden">
            <button type="button" class="btn btn-white btn-sm border-end" data-bs-toggle="modal" data-bs-target="#ajax-editCategoryModal{{ $category->id }}" title="Edit">
                <i class="fa-solid fa-pen-to-square text-primary"></i>
            </button>
            <button type="button" class="btn btn-white btn-sm text-danger" data-bs-toggle="modal" data-bs-target="#ajax-deleteCategoryModal{{ $category->id }}" title="Delete">
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>
    </td>
</tr>
@endforeach
