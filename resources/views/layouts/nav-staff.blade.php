<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top">
    <div class="container-fluid px-4 px-lg-5">
        <a class="navbar-brand fw-bold d-flex align-items-center fs-4" href="{{ url('/') }}">
            <div class="bg-indigo text-white rounded p-2 me-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px;">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
            <span class="text-indigo">{{ config('app.name', 'StockSync') }}</span>
        </a>
        <button class="navbar-toggler border-0 staff-nav-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <i class="fa-solid fa-bars text-dark"></i>
        </button>

        {{-- Mobile user avatar dropdown (top-right, shown only on mobile) --}}
        <div class="staff-mobile-avatar d-none align-items-center ms-auto dropdown">
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
                <a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('staff-mobile-logout-form').submit();">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                </a>
                <form id="staff-mobile-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </div>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Centered Links -->
            <ul class="navbar-nav mx-auto gap-1 gap-lg-3 align-items-start align-items-md-center mb-3 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link fw-bold d-flex align-items-center gap-2 py-2 px-3 rounded-pill {{ request()->routeIs('staff.dashboard') ? 'active bg-indigo text-white shadow-sm' : 'text-secondary hover-bg-light' }}" href="{{ route('staff.dashboard') }}">
                        <i class="fa-solid fa-chart-line"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold d-flex align-items-center gap-2 py-2 px-3 rounded-pill {{ request()->routeIs('staff.pos') ? 'active bg-indigo text-white shadow-sm' : 'text-secondary hover-bg-light' }}" href="{{ route('staff.pos') }}">
                        <i class="fa-solid fa-cash-register"></i> POS
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold d-flex align-items-center gap-2 py-2 px-3 rounded-pill {{ request()->routeIs('staff.inventory') ? 'active bg-indigo text-white shadow-sm' : 'text-secondary hover-bg-light' }}" href="{{ route('staff.inventory') }}">
                        <i class="fa-solid fa-boxes-stacked"></i> Inventory
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold d-flex align-items-center gap-2 py-2 px-3 rounded-pill {{ request()->routeIs('staff.logs') ? 'active bg-indigo text-white shadow-sm' : 'text-secondary hover-bg-light' }}" href="{{ route('staff.logs') }}">
                        <i class="fa-solid fa-clipboard-list"></i> Logs
                    </a>
                </li>
            </ul>

            <!-- Right Side Profile -->
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle fw-bold d-flex align-items-center py-1 px-3 rounded-pill bg-light border" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <div class="position-relative me-2">
                            <div class="bg-indigo text-white rounded-circle d-flex align-items-center justify-content-center me-2 shadow-sm overflow-hidden" style="width: 32px; height: 32px; font-size: 0.8rem;">
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
                        <a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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

<style>
    .hover-bg-light:hover {
        background-color: #f8f9fa;
        color: var(--primary-color) !important;
    }
    .nav-link.active {
        background-color: var(--primary-color) !important;
    }
</style>

{{-- Mobile Bottom Navigation --}}
<nav class="staff-bottom-nav" aria-label="Staff mobile navigation">
    <div class="staff-bottom-nav-inner">
        <a href="{{ route('staff.logs') }}" class="bottom-nav-item {{ request()->routeIs('staff.logs') ? 'is-active' : '' }}">
            <i class="fa-solid fa-clipboard-list"></i>
            <span>Logs</span>
        </a>
        <a href="{{ route('staff.inventory') }}" class="bottom-nav-item {{ request()->routeIs('staff.inventory') ? 'is-active' : '' }}">
            <i class="fa-solid fa-boxes-stacked"></i>
            <span>Inventory</span>
        </a>
        <div class="bottom-nav-home">
            <a href="{{ route('staff.dashboard') }}" class="bottom-nav-home-btn {{ request()->routeIs('staff.dashboard') ? 'is-active' : '' }}">
                <i class="fa-solid fa-house"></i>
            </a>
        </div>
        <a href="{{ route('staff.pos') }}" class="bottom-nav-item {{ request()->routeIs('staff.pos') ? 'is-active' : '' }}">
            <i class="fa-solid fa-cash-register"></i>
            <span>POS</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="bottom-nav-item {{ request()->routeIs('profile.edit') ? 'is-active' : '' }}">
            <i class="fa-solid fa-user"></i>
            <span>Profile</span>
        </a>
    </div>
</nav>