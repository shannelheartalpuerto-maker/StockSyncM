@extends('layouts.app')

@section('content')
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
.class-form-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 1.2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,.04);
}
.class-form-card h6 {
    font-size: 0.95rem;
}
.classify-tabs-wrap {
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 0.4rem;
    display: inline-flex;
}
.class-list-shell {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,.04);
    overflow: hidden;
}
</style>

<div class="staff-container animate-fade-up">
    <div class="inv-topbar mb-4">
        <div class="inv-topbar-inner">
            <div class="inv-title-wrap">
                <span class="inv-title-icon"><i class="fa-solid fa-layer-group"></i></span>
                <h5 class="inv-title-text">Manage Classifications</h5>
            </div>
            <div class="inv-header-actions">
                <span class="inv-head-pill"><i class="fa-solid fa-tags"></i>{{ method_exists($categories, 'total') ? number_format($categories->total()) : number_format($categories->count()) }} Categories</span>
                <span class="inv-head-pill"><i class="fa-solid fa-copyright"></i>{{ method_exists($brands, 'total') ? number_format($brands->total()) : number_format($brands->count()) }} Brands</span>
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="card-body-custom">
            @if (session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                </div>
            @endif

            <div class="d-flex justify-content-center mb-4">
                <ul class="nav nav-pills dashboard-tabs classify-tabs-wrap" id="classificationTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-pill px-4 py-2" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories" type="button" role="tab" aria-controls="categories" aria-selected="true">
                            <i class="fa-solid fa-tags me-2"></i>Categories
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill px-4 py-2" id="brands-tab" data-bs-toggle="tab" data-bs-target="#brands" type="button" role="tab" aria-controls="brands" aria-selected="false">
                            <i class="fa-solid fa-copyright me-2"></i>Brands
                        </button>
                    </li>
                </ul>
            </div>

            <div class="tab-content" id="classificationTabsContent">
                <!-- Categories Tab -->
                <div class="tab-pane fade show active" id="categories" role="tabpanel" aria-labelledby="categories-tab">
                    <div class="row g-4 align-items-stretch">
                        <!-- Add Category Section -->
                        <div class="col-md-4">
                            <div class="class-form-card h-100">
                                <h6 class="fw-bold mb-3 text-indigo"><i class="fa-solid fa-folder-plus me-2"></i>Add New Category</h6>
                                <form method="POST" action="{{ route('admin.categories.store') }}" id="categoriesForm">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-semibold small text-muted text-uppercase">Category Name</label>
                                        <div class="input-group search-input-group border">
                                            <span class="input-group-text bg-transparent border-0"><i class="fa-solid fa-tag text-muted"></i></span>
                                            <input type="text" class="form-control border-0 bg-transparent @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required placeholder="e.g. School Supplies">
                                        </div>
                                        @error('name')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-indigo w-100">
                                        <i class="fa-solid fa-plus me-2"></i>Create Category
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Category List Section -->
                        <div class="col-md-8">
                            <div class="class-list-shell">
                            <div class="table-responsive" id="categoriesTableWrap">
                                <table class="table align-middle inv-table">
                                    <thead>
                                        <tr>
                                            <th class="ps-4">Category Name</th>
                                            <th>Product Count</th>
                                            <th class="text-end pe-4">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="categoriesTableBody">
                                        @include('admin.categories.partials.categories_rows', ['categories' => $categories])

                                        @if($categories->isEmpty())
                                        <tr>
                                            <td colspan="3" class="text-center py-5">
                                                <div class="py-3">
                                                    <i class="fa-solid fa-folder-open fa-3x mb-3 text-muted opacity-25"></i>
                                                    <p class="text-muted">No categories found.</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Brands Tab -->
                <div class="tab-pane fade" id="brands" role="tabpanel" aria-labelledby="brands-tab">
                    <div class="row g-4 align-items-stretch">
                        <!-- Add Brand Section -->
                        <div class="col-md-4">
                            <div class="class-form-card h-100">
                                <h6 class="fw-bold mb-3 text-teal"><i class="fa-solid fa-plus-circle me-2"></i>Add New Brand</h6>
                                <form method="POST" action="{{ route('admin.brands.store') }}" id="brandsForm">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="brand_name" class="form-label fw-semibold small text-muted text-uppercase">Brand Name</label>
                                        <div class="input-group search-input-group border">
                                            <span class="input-group-text bg-transparent border-0"><i class="fa-solid fa-copyright text-muted"></i></span>
                                            <input type="text" class="form-control border-0 bg-transparent @error('name') is-invalid @enderror" id="brand_name" name="name" required placeholder="e.g. Pilot">
                                        </div>
                                        @error('name')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-teal w-100">
                                        <i class="fa-solid fa-plus me-2"></i>Create Brand
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Brand List Section -->
                        <div class="col-md-8">
                            <div class="class-list-shell">
                            <div class="table-responsive" id="brandsTableWrap">
                                <table class="table align-middle inv-table">
                                    <thead>
                                        <tr>
                                            <th class="ps-4">Brand Name</th>
                                            <th>Product Count</th>
                                            <th class="text-end pe-4">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="brandsTableBody">
                                        @include('admin.categories.partials.brands_rows', ['brands' => $brands])

                                        @if($brands->isEmpty())
                                        <tr>
                                            <td colspan="3" class="text-center py-5">
                                                <div class="py-3">
                                                    <i class="fa-solid fa-copyright fa-3x mb-3 text-muted opacity-25"></i>
                                                    <p class="text-muted">No brands found.</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
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
        <div id="ajaxCategoriesModals"></div>
        <div id="ajaxBrandsModals"></div>
    </div>
</div>
@endsection

@push('modals')
<!-- Categories Modals -->
@foreach($categories as $category)
    <!-- Edit Modal -->
    <div class="modal fade" id="ajax-editCategoryModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header border-0 pb-0">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                                <i class="fa-solid fa-pen-to-square text-primary fs-4"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold">Edit Category</h5>
                                <p class="text-muted small mb-0">{{ $category->name }}</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-0">
                            <label for="name{{ $category->id }}" class="form-label fw-bold">Category Name</label>
                            <div class="input-group search-input-group border">
                                <span class="input-group-text bg-transparent border-0"><i class="fa-solid fa-tag text-muted"></i></span>
                                <input type="text" class="form-control border-0 bg-transparent" id="name{{ $category->id }}" name="name" value="{{ $category->name }}" required placeholder="Enter category name">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="ajax-deleteCategoryModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-body p-4 text-center">
                    <div class="mb-3">
                        <div class="bg-danger bg-opacity-10 d-inline-flex p-3 rounded-circle mb-3">
                            <i class="fa-solid fa-trash-can text-danger fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Delete Category?</h5>
                        <p class="text-muted small mb-2">Delete <strong>{{ $category->name }}</strong>? Products in this category will be affected.</p>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4">
                        <button type="button" class="btn btn-light px-4 flex-grow-1" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="flex-grow-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100 px-4">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- Brands Modals -->
@foreach($brands as $brand)
    <!-- Edit Modal -->
    <div class="modal fade" id="ajax-editBrandModal{{ $brand->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header border-0 pb-0">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                                <i class="fa-solid fa-pen-to-square text-primary fs-4"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold">Edit Brand</h5>
                                <p class="text-muted small mb-0">{{ $brand->name }}</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-0">
                            <label for="brand_name{{ $brand->id }}" class="form-label fw-bold">Brand Name</label>
                            <div class="input-group search-input-group border">
                                <span class="input-group-text bg-transparent border-0"><i class="fa-solid fa-copyright text-muted"></i></span>
                                <input type="text" class="form-control border-0 bg-transparent" id="brand_name{{ $brand->id }}" name="name" value="{{ $brand->name }}" required placeholder="Enter brand name">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="ajax-deleteBrandModal{{ $brand->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-body p-4 text-center">
                    <div class="mb-3">
                        <div class="bg-danger bg-opacity-10 d-inline-flex p-3 rounded-circle mb-3">
                            <i class="fa-solid fa-trash-can text-danger fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Delete Brand?</h5>
                        <p class="text-muted small mb-2">Delete <strong>{{ $brand->name }}</strong>? Products linked to this brand will be unlinked.</p>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4">
                        <button type="button" class="btn btn-light px-4 flex-grow-1" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" class="flex-grow-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100 px-4">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endpush
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoriesForm = document.querySelector('form[action="{{ route('admin.categories.store') }}"]');
    const brandsForm = document.querySelector('form[action="{{ route('admin.brands.store') }}"]');
    const categoriesWrap = document.getElementById('categoriesTableWrap');
    const brandsWrap = document.getElementById('brandsTableWrap');
    const categoriesBody = document.getElementById('categoriesTableBody');
    const brandsBody = document.getElementById('brandsTableBody');
    const ajaxCategoriesModals = document.getElementById('ajaxCategoriesModals');
    const ajaxBrandsModals = document.getElementById('ajaxBrandsModals');
    const animateOnce = (el) => { if(!el) return; el.classList.remove('animate-fade-up'); void el.offsetWidth; el.classList.add('animate-fade-up'); setTimeout(()=>el.classList.remove('animate-fade-up'), 600); };
    const setLoading = (wrap, btn, on) => { if(wrap) wrap.classList.toggle('is-loading', !!on); if(btn) btn.classList.toggle('loading', !!on); };

    async function refreshLists() {
        const resp = await fetch(`{{ route('admin.categories.index') }}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        const data = await resp.json();
        if (categoriesBody) categoriesBody.innerHTML = data.categories_rows_html;
        if (brandsBody) brandsBody.innerHTML = data.brands_rows_html;
        if (ajaxCategoriesModals) ajaxCategoriesModals.innerHTML = data.categories_modals_html;
        if (ajaxBrandsModals) ajaxBrandsModals.innerHTML = data.brands_modals_html;
        animateOnce(categoriesBody);
        animateOnce(brandsBody);
    }

    function handleAjaxSubmit(form, wrap) {
        if (!form) return;
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const btn = form.querySelector('button[type="submit"]');
            setLoading(wrap, btn, true);
            try {
                const resp = await fetch(form.action, {
                    method: form.method || 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: new FormData(form)
                });
                // If the server returns JSON with rows, apply them; otherwise fallback to refreshLists
                if (resp.headers.get('Content-Type')?.includes('application/json')) {
                    const data = await resp.json();
                    if (data.categories_rows_html) {
                        if (categoriesBody) categoriesBody.innerHTML = data.categories_rows_html;
                        if (ajaxCategoriesModals) ajaxCategoriesModals.innerHTML = data.categories_modals_html;
                        animateOnce(categoriesBody);
                    }
                    if (data.brands_rows_html) {
                        if (brandsBody) brandsBody.innerHTML = data.brands_rows_html;
                        if (ajaxBrandsModals) ajaxBrandsModals.innerHTML = data.brands_modals_html;
                        animateOnce(brandsBody);
                    }
                } else {
                    await refreshLists();
                }
                form.reset && form.reset();
            } finally {
                setLoading(wrap, btn, false);
            }
        });
    }
    handleAjaxSubmit(categoriesForm, categoriesWrap);
    handleAjaxSubmit(brandsForm, brandsWrap);

    document.addEventListener('submit', async function(e) {
        const form = e.target;
        const isCatUpdate = form.action.includes('/admin/categories/') && form.querySelector('input[name="_method"][value="PUT"]');
        const isCatDelete = form.action.includes('/admin/categories/') && form.querySelector('input[name="_method"][value="DELETE"]');
        const isBrandUpdate = form.action.includes('/admin/brands/') && form.querySelector('input[name="_method"][value="PUT"]');
        const isBrandDelete = form.action.includes('/admin/brands/') && form.querySelector('input[name="_method"][value="DELETE"]');
        if (isCatUpdate || isCatDelete || isBrandUpdate || isBrandDelete) {
            e.preventDefault();
            const wrap = (isCatUpdate || isCatDelete) ? categoriesWrap : brandsWrap;
            const modalEl = form.closest('.modal');
            const submitBtn = form.querySelector('button[type="submit"]');
            setLoading(wrap, submitBtn, true);
            try {
                const resp = await fetch(form.action, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: new FormData(form)
                });
                if (resp.headers.get('Content-Type')?.includes('application/json')) {
                    const data = await resp.json();
                    if (data.categories_rows_html) {
                        if (categoriesBody) categoriesBody.innerHTML = data.categories_rows_html;
                        if (ajaxCategoriesModals) ajaxCategoriesModals.innerHTML = data.categories_modals_html;
                        animateOnce(categoriesBody);
                    }
                    if (data.brands_rows_html) {
                        if (brandsBody) brandsBody.innerHTML = data.brands_rows_html;
                        if (ajaxBrandsModals) ajaxBrandsModals.innerHTML = data.brands_modals_html;
                        animateOnce(brandsBody);
                    }
                } else {
                    await refreshLists();
                }
            } finally {
                setLoading(wrap, submitBtn, false);
                if (modalEl) {
                    const instance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                    instance.hide();
                }
            }
        }
    });
});
</script>
@endpush
