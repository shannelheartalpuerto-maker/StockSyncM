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
                <div class="auth-clean-kicker">Create account</div>
                <h1 class="auth-clean-title">Register a new account</h1>
                <p class="auth-clean-subtitle">Fill in your details to get started.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="auth-clean-form">
                @csrf

                <div class="form-floating mb-3">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="John Doe">
                    <label for="name">Full Name</label>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="name@example.com">
                    <label for="email">Email Address</label>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
                    <label for="password">Password</label>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-floating mb-2">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                    <label for="password-confirm">Confirm Password</label>
                </div>

                <button type="submit" class="btn btn-primary-custom auth-clean-submit">Register</button>

                <div class="auth-clean-footnote text-center mt-4">
                    <p class="small mb-0">Already have an account?
                        <a href="{{ route('login') }}" class="fw-bold text-decoration-none">Log in here</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
