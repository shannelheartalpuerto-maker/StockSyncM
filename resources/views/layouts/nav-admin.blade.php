<nav class="navbar navbar-expand-md navbar-light sticky-top admin-topnav">
    <div class="container-fluid px-4 px-lg-5">
        <a class="navbar-brand fw-bold d-flex align-items-center fs-4" href="{{ url('/') }}">
            <div class="admin-brand-icon me-2 d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
            <span class="text-indigo">{{ config('app.name', 'StockSync') }}</span>
        </a>

        <button class="navbar-toggler border-0 admin-nav-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <i class="fa-solid fa-bars"></i>
        </button>

        {{-- Mobile user avatar dropdown (top-right, shown only on mobile) --}}
        <div class="admin-mobile-avatar d-none align-items-center ms-auto dropdown">
            <a href="#" class="text-decoration-none" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="bg-light text-secondary rounded-circle d-flex align-items-center justify-content-center border" style="width: 36px; height: 36px; font-size: 0.85rem;">
                    @if(Auth::user()->profile_image)
                        <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    @else
                        {{ substr(Auth::user()->name, 0, 1) }}
                    @endif
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2 rounded-3" style="min-width: 200px;">
                <div class="px-3 py-2 border-bottom mb-1 bg-light rounded-top-3">
                    <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ Auth::user()->name }}</div>
                    <small class="text-muted" style="font-size: 0.7rem;">{{ Auth::user()->email }}</small>
                </div>
                <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                    <i class="fa-solid fa-user me-2 text-indigo"></i> Profile
                </a>
                <hr class="dropdown-divider my-1">
                <a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                </a>
                <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </div>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto gap-1 gap-lg-2 align-items-start align-items-md-center mb-3 mb-md-0 admin-nav-links">
                <li class="nav-item w-100 w-md-auto">
                    <a class="nav-link topnav-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fa-solid fa-chart-line"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item w-100 w-md-auto">
                    <a class="nav-link topnav-link {{ request()->routeIs('admin.products.*') ? 'is-active' : '' }}" href="{{ route('admin.products.index') }}">
                        <i class="fa-solid fa-boxes-stacked"></i> Inventory
                    </a>
                </li>
                <li class="nav-item w-100 w-md-auto">
                    <a class="nav-link topnav-link {{ request()->routeIs('admin.categories.*') ? 'is-active' : '' }}" href="{{ route('admin.categories.index') }}">
                        <i class="fa-solid fa-tags"></i> Categories
                    </a>
                </li>
                <li class="nav-item w-100 w-md-auto">
                    <a class="nav-link topnav-link {{ request()->routeIs('admin.transactions.*') ? 'is-active' : '' }}" href="{{ route('admin.transactions.index') }}">
                        <i class="fa-solid fa-file-invoice-dollar"></i> Sales
                    </a>
                </li>
                <li class="nav-item w-100 w-md-auto">
                    <a class="nav-link topnav-link {{ request()->routeIs('admin.staff.*') ? 'is-active' : '' }}" href="{{ route('admin.staff.index') }}">
                        <i class="fa-solid fa-users"></i> Staff
                    </a>
                </li>
                <li class="nav-item w-100 w-md-auto">
                    <a class="nav-link topnav-link {{ request()->routeIs('admin.admins.*') ? 'is-active' : '' }}" href="{{ route('admin.admins.index') }}">
                        <i class="fa-solid fa-user-shield"></i> Admins
                    </a>
                </li>
                <li class="nav-item w-100 w-md-auto">
                    <a class="nav-link topnav-link {{ request()->routeIs('admin.stock_logs.*') ? 'is-active' : '' }}" href="{{ route('admin.stock_logs.index') }}">
                        <i class="fa-solid fa-clipboard-list"></i> Logs
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle fw-semibold d-flex align-items-center py-1 px-3 rounded-pill admin-user-pill" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <div class="position-relative me-2">
                            <div class="bg-indigo text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm overflow-hidden" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                @if(Auth::user()->profile_image)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                @endif
                            </div>
                            <span class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle" style="width: 10px; height: 10px; transform: translate(25%, 25%);"></span>
                        </div>
                        <span class="text-dark">{{ Auth::user()->name }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2 rounded-3" aria-labelledby="navbarDropdown">
                        <div class="px-3 py-2 border-bottom mb-2 bg-light rounded-top-3">
                            <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Signed in as</small>
                            <div class="fw-bold text-dark">{{ Auth::user()->email }}</div>
                        </div>
                        <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                            <i class="fa-solid fa-user me-2 text-indigo"></i> {{ __('Profile') }}
                        </a>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa-solid fa-right-from-bracket me-2"></i> {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- Mobile Bottom Navigation --}}
<nav class="admin-bottom-nav" aria-label="Mobile navigation">
    <div class="admin-bottom-nav-inner">
        <a href="{{ route('admin.stock_logs.index') }}" class="bottom-nav-item {{ request()->routeIs('admin.stock_logs.*') ? 'is-active' : '' }}">
            <i class="fa-solid fa-clipboard-list"></i>
            <span>Logs</span>
        </a>
        <a href="{{ route('admin.products.index') }}" class="bottom-nav-item {{ request()->routeIs('admin.products.*') ? 'is-active' : '' }}">
            <i class="fa-solid fa-boxes-stacked"></i>
            <span>Inventory</span>
        </a>
        <div class="bottom-nav-home">
            <a href="{{ route('admin.dashboard') }}" class="bottom-nav-home-btn {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
                <i class="fa-solid fa-house"></i>
            </a>
        </div>
        <a href="{{ route('admin.transactions.index') }}" class="bottom-nav-item {{ request()->routeIs('admin.transactions.*') ? 'is-active' : '' }}">
            <i class="fa-solid fa-receipt"></i>
            <span>Sales</span>
        </a>
        <a href="{{ route('admin.categories.index') }}" class="bottom-nav-item {{ request()->routeIs('admin.categories.*') ? 'is-active' : '' }}">
            <i class="fa-solid fa-tags"></i>
            <span>Category</span>
        </a>
    </div>
</nav>

<style>
.admin-topnav {
    background: rgba(255, 255, 255, 0.92);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid #e5e7eb;
    box-shadow: 0 2px 12px rgba(15, 23, 42, 0.05);
}
.admin-brand-icon {
    width: 40px;
    height: 40px;
    border-radius: 11px;
    color: #fff;
    background: linear-gradient(135deg, #4f46e5 0%, #0ea5e9 100%);
    box-shadow: 0 6px 16px rgba(79, 70, 229, 0.28);
}
.admin-nav-toggle {
    color: #334155;
}
.admin-nav-links .topnav-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    border-radius: 10px;
    padding: 0.5rem 0.85rem;
    color: #475569;
    font-weight: 600;
    border: 1px solid transparent;
    transition: all 0.18s ease;
}
.admin-nav-links .topnav-link:hover {
    color: #334155;
    background: #f8fafc;
    border-color: #e2e8f0;
}
.admin-nav-links .topnav-link.is-active,
.admin-nav-links .topnav-link.is-active:hover {
    color: #1d4ed8;
    background: linear-gradient(135deg, #eef2ff 0%, #e0f2fe 100%);
    border-color: #c7d2fe;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.14);
}
.admin-user-pill {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
}
@media (max-width: 767.98px) {
    .admin-nav-links {
        margin-top: 0.6rem;
        margin-bottom: 0.75rem;
    }
    .admin-nav-links .topnav-link {
        width: 100%;
        justify-content: flex-start;
    }
}
</style>