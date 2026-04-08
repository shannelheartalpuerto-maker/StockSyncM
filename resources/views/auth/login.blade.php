@extends('layouts.auth')

@section('content')
<div class="auth-clean-shell">
    <div class="auth-clean-wrap">
        <a href="{{ url('/') }}" class="auth-clean-brand text-decoration-none">
            <span class="auth-clean-brand-mark"><i class="fa-solid fa-boxes-stacked"></i></span>
            <span class="auth-clean-brand-copy">
                <span class="auth-clean-brand-name">StockSync</span>
                <span class="auth-clean-brand-tag">Inventory Control Suite</span>
            </span>
        </a>

        <div class="auth-clean-card">
            <div class="auth-clean-head">
                <div class="auth-clean-kicker">Welcome back</div>
                <h1 class="auth-clean-title">Log in to your account</h1>
                <p class="auth-clean-subtitle">Enter your credentials to continue.</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="auth-clean-form">
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

                <button type="submit" class="btn btn-primary-custom auth-clean-submit">
                    <i class="fa-solid fa-arrow-right-to-bracket me-2"></i>
                    Log In
                </button>

                <div class="auth-clean-footnote text-center mt-4">
                    <p class="small mb-0">No account yet?
                        <a href="{{ route('register') }}" class="fw-bold text-decoration-none">Register here</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
