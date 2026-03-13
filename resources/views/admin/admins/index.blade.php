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
.main-form-shell {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 1.2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,.04);
}
.main-list-shell {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,.04);
    overflow: hidden;
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
/* Keep confirm-modal overlay visible but not overly dark on this page. */
.modal {
    z-index: 2100 !important;
}
.modal-backdrop {
    z-index: 2090 !important;
}
.modal.show,
.modal.show .modal-dialog,
.modal.show .modal-content,
.modal.show .modal-content * {
    pointer-events: auto !important;
}
.confirm-modal .modal-dialog {
    opacity: 0;
    transform: translateY(8px) scale(0.985);
    transition: opacity 160ms ease, transform 160ms ease;
}
.confirm-modal.show .modal-dialog {
    opacity: 1;
    transform: translateY(0) scale(1);
}
.modal-backdrop.show {
    opacity: 0.18;
}
</style>

<div class="staff-container animate-fade-up">
    <div class="inv-topbar mb-4">
        <div class="inv-topbar-inner">
            <div class="inv-title-wrap">
                <span class="inv-title-icon"><i class="fa-solid fa-users-gear"></i></span>
                <h5 class="inv-title-text">Admin Management</h5>
            </div>
            <div class="inv-header-actions">
                <span class="inv-head-pill"><i class="fa-solid fa-user-shield"></i>{{ method_exists($admins, 'total') ? number_format($admins->total()) : number_format($admins->count()) }} Admins</span>
                <span class="inv-head-pill"><i class="fa-solid fa-user-lock"></i>Access Authority</span>
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

            <div class="row g-4">
                <!-- Add Admin Section -->
                <div class="col-md-4">
                    <div class="main-form-shell h-100">
                        <h6 class="fw-bold mb-3 text-indigo"><i class="fa-solid fa-user-plus me-2"></i>Add New Admin</h6>
                        <form method="POST" action="{{ route('admin.admins.store') }}" id="adminsForm">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold small text-muted text-uppercase">Full Name</label>
                                <div class="input-group search-input-group border">
                                    <span class="input-group-text bg-transparent border-0"><i class="fa-solid fa-user text-muted"></i></span>
                                    <input type="text" class="form-control border-0 bg-transparent @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required placeholder="e.g. Juan Dela Cruz">
                                </div>
                                @error('name')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold small text-muted text-uppercase">Email Address</label>
                                <div class="input-group search-input-group border">
                                    <span class="input-group-text bg-transparent border-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                                    <input type="email" class="form-control border-0 bg-transparent @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="juan@example.com">
                                </div>
                                @error('email')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold small text-muted text-uppercase">Password</label>
                                <div class="input-group search-input-group border">
                                    <span class="input-group-text bg-transparent border-0"><i class="fa-solid fa-lock text-muted"></i></span>
                                    <input type="password" class="form-control border-0 bg-transparent @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Min. 8 characters">
                                </div>
                                @error('password')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password-confirm" class="form-label fw-semibold small text-muted text-uppercase">Confirm Password</label>
                                <div class="input-group search-input-group border">
                                    <span class="input-group-text bg-transparent border-0"><i class="fa-solid fa-lock text-muted"></i></span>
                                    <input type="password" class="form-control border-0 bg-transparent" id="password-confirm" name="password_confirmation" required placeholder="Repeat password">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-indigo w-100">
                                <i class="fa-solid fa-plus me-2"></i>Create Admin Account
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Admin List Section -->
                <div class="col-md-8">
                    <div class="main-list-shell">
                    <div class="table-responsive" id="adminsTableWrap">
                        <table class="table align-middle inv-table">
                            <thead>
                                <tr>
                                    <th class="ps-4">Administrator</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="adminsTableBody">
                                @include('admin.admins.partials.rows', ['admins' => $admins])

                                @if($admins->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="py-3">
                                            <i class="fa-solid fa-users-slash fa-3x mb-3 text-muted opacity-25"></i>
                                            <p class="text-muted">No other admin accounts found.</p>
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

<!-- Modals Section -->
<div id="ajaxAdminsModals">
    @include('admin.admins.partials.modals', ['admins' => $admins])
</div>

@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const createForm = document.querySelector('form[action="{{ route('admin.admins.store') }}"]');
    const tableWrap = document.getElementById('adminsTableWrap');
    const tbody = document.getElementById('adminsTableBody');
    const modalsMount = document.getElementById('ajaxAdminsModals');
    const animateOnce = (el) => { if(!el) return; el.classList.remove('animate-fade-up'); void el.offsetWidth; el.classList.add('animate-fade-up'); setTimeout(()=>el.classList.remove('animate-fade-up'), 600); };
    const setLoading = (wrap, btn, on) => { if(wrap) wrap.classList.toggle('is-loading', !!on); if(btn) btn.classList.toggle('loading', !!on); };
    const forceCleanupModals = () => {
        if (document.querySelector('.modal.show')) return;
        document.querySelectorAll('.modal-backdrop').forEach((el) => el.remove());
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    };
    const replaceModals = (html) => {
        if (!modalsMount || typeof html !== 'string') return;
        document.querySelectorAll('.modal[data-managed-admin-modal="1"]').forEach((el) => el.remove());
        modalsMount.innerHTML = html;
        modalsMount.querySelectorAll('.modal').forEach((modalEl) => {
            modalEl.setAttribute('data-managed-admin-modal', '1');
            document.body.appendChild(modalEl);
        });
    };

    // Hoist initial server-rendered modals to body to avoid stacking-context click traps.
    if (modalsMount) replaceModals(modalsMount.innerHTML);

    async function refreshList() {
        const resp = await fetch(`{{ route('admin.admins.index') }}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        const data = await resp.json();
        if (tbody && data.rows_html) tbody.innerHTML = data.rows_html;
        if (data.modals_html) replaceModals(data.modals_html);
        animateOnce(tbody);
        forceCleanupModals();
    }

    function handleAjaxSubmit(form, wrap) {
        if (!form) return;
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const btn = form.querySelector('button[type="submit"]');
            setLoading(wrap, btn, true);
            try {
                const resp = await fetch(form.action, { method: form.method || 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' }, body: new FormData(form) });
                if (resp.headers.get('Content-Type')?.includes('application/json')) {
                    const data = await resp.json();
                    if (data.rows_html) tbody.innerHTML = data.rows_html;
                    if (data.modals_html) replaceModals(data.modals_html);
                    animateOnce(tbody);
                } else {
                    await refreshList();
                }
                form.reset && form.reset();
            } finally {
                setLoading(wrap, btn, false);
            }
        });
    }
    handleAjaxSubmit(createForm, tableWrap);

    document.addEventListener('submit', async function(e) {
        const form = e.target;
        const isUpdate = form.action.includes('/admin/admins/') && form.querySelector('input[name="_method"][value="PUT"]');
        const isDelete = form.action.includes('/admin/admins/') && form.querySelector('input[name="_method"][value="DELETE"]');
        if (isUpdate || isDelete) {
            e.preventDefault();
            const modalEl = form.closest('.modal');
            const btn = form.querySelector('button[type="submit"]');
            setLoading(tableWrap, btn, true);
            try {
                const resp = await fetch(form.action, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' }, body: new FormData(form) });
                if (modalEl) {
                    const instance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                    instance.hide();
                }
                if (resp.headers.get('Content-Type')?.includes('application/json')) {
                    const data = await resp.json();
                    if (data.rows_html) tbody.innerHTML = data.rows_html;
                    if (data.modals_html) replaceModals(data.modals_html);
                } else {
                    await refreshList();
                }
                animateOnce(tbody);
            } finally {
                setLoading(tableWrap, btn, false);
                setTimeout(forceCleanupModals, 50);
            }
        }
    });

    document.addEventListener('hidden.bs.modal', function() {
        setTimeout(forceCleanupModals, 10);
    });
});
</script>
@endpush
