@extends('layouts.auth')

@section('content')
<div class="login-page-shell">
    <div class="container-fluid p-0">
        <div class="row g-0 login-container intro-login-layout">
            <div class="col-lg-7 login-intro-panel">
                <div class="intro-glow intro-glow-one"></div>
                <div class="intro-glow intro-glow-two"></div>

                <div class="intro-content-wrap">
                    <div class="intro-chip">
                        <span class="intro-chip-dot"></span>
                        Inventory Platform
                    </div>

                    <div class="intro-brand-row">
                        <div class="intro-brand-icon">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                        <div>
                            <h1 class="intro-brand-title">StockSync</h1>
                            <p class="intro-brand-subtitle">Business Control Center</p>
                        </div>
                    </div>

                    <h2 class="intro-hero-title">Manage stock, sales, and teams in one professional workspace.</h2>
                    <p class="intro-hero-text">Built for fast-paced stores that need real-time inventory visibility, smooth transaction flow, and cleaner operational control every day.</p>

                    <div class="intro-metrics-grid">
                        <div class="intro-metric-card">
                            <div class="intro-metric-icon"><i class="fa-solid fa-chart-line"></i></div>
                            <div>
                                <p class="intro-metric-value">Real-Time</p>
                                <p class="intro-metric-label">Inventory Monitoring</p>
                            </div>
                        </div>
                        <div class="intro-metric-card">
                            <div class="intro-metric-icon"><i class="fa-solid fa-cash-register"></i></div>
                            <div>
                                <p class="intro-metric-value">Fast POS</p>
                                <p class="intro-metric-label">Seamless Checkout</p>
                            </div>
                        </div>
                        <div class="intro-metric-card">
                            <div class="intro-metric-icon"><i class="fa-solid fa-shield-halved"></i></div>
                            <div>
                                <p class="intro-metric-value">Secure</p>
                                <p class="intro-metric-label">Role-Based Access</p>
                            </div>
                        </div>
                        <div class="intro-metric-card">
                            <div class="intro-metric-icon"><i class="fa-solid fa-file-lines"></i></div>
                            <div>
                                <p class="intro-metric-value">Smart Reports</p>
                                <p class="intro-metric-label">Actionable Insights</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 login-form-panel">
                <div class="login-form-card">
                    <div class="login-form-top">
                        <p class="form-eyebrow">Welcome Back</p>
                        <h3 class="form-title">Sign in to continue</h3>
                        <p class="form-subtitle">Access your dashboard and keep your operations moving.</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="login-modern-form">
                        @csrf

                        <div class="form-floating mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="name@example.com">
                            <label for="email">Email Address</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-floating mb-2">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                            <label for="password">Password</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="login-form-meta">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>

                            @if (Route::has('password.request'))
                                <a class="forgot-link" href="{{ route('password.request') }}">Forgot password?</a>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary-custom shadow-sm">
                            <i class="fa-solid fa-arrow-right-to-bracket me-2"></i>
                            Sign In
                        </button>

                        <div class="text-center mt-4">
                            <p class="small mb-0 form-switch-link">New to StockSync?
                                <a href="{{ route('register') }}" class="fw-bold text-decoration-none">Create an account</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
