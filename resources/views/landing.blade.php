@extends('layouts.auth')

@section('content')
<div class="landing-page-container">
    <!-- Hero Section -->
    <section class="landing-hero-section">
        <div class="landing-hero-bg"></div>

        <div class="landing-hero-wrapper">
            <div class="landing-hero-grid">
                <div class="landing-hero-content">
                    <div class="landing-hero-badge">
                        <i class="fa-solid fa-sparkles"></i>
                        Smart Inventory Management
                    </div>
                    <h1 class="landing-hero-title">Inventory management designed for speed and control.</h1>
                    <p class="landing-hero-description">StockSync helps retail teams track stock, process sales, and maintain accuracy—all from one clean workspace built for desktop and mobile.</p>
                    <div class="landing-hero-actions">
                        <a href="{{ route('register') }}" class="landing-btn-primary">
                            <i class="fa-solid fa-rocket"></i> Get Started
                        </a>
                        <a href="{{ route('login') }}" class="landing-btn-secondary">
                            Sign In
                        </a>
                    </div>
                    <p style="font-size: 0.85rem; color: #94a3b8; margin: 0;">No credit card required. Start reporting in seconds.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="landing-features-section">
        <div class="landing-section-header">
            <h2 class="landing-section-title">Core Capabilities</h2>
            <p class="landing-section-description">Everything you need to manage inventory efficiently</p>
        </div>
        <div class="landing-features-grid">
            <div class="landing-feature-card">
                <div class="landing-feature-icon">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <h3 class="landing-feature-title">Real-Time Tracking</h3>
                <p class="landing-feature-description">Monitor your stock levels in real time. Get instant alerts when inventory runs low or when discrepancies are detected.</p>
            </div>
            <div class="landing-feature-card">
                <div class="landing-feature-icon">
                    <i class="fa-solid fa-barcode"></i>
                </div>
                <h3 class="landing-feature-title">Barcode Scanning</h3>
                <p class="landing-feature-description">Speed up transactions and stock movements with fast, accurate barcode scanning through your mobile device.</p>
            </div>
            <div class="landing-feature-card">
                <div class="landing-feature-icon">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <h3 class="landing-feature-title">Role-Based Access</h3>
                <p class="landing-feature-description">Separate staff and admin permissions. Control who can view, edit, or manage critical inventory data.</p>
            </div>
            <div class="landing-feature-card">
                <div class="landing-feature-icon">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <h3 class="landing-feature-title">POS Integration</h3>
                <p class="landing-feature-description">Seamlessly process sales and automatically update inventory. Reduce manual entry and human error.</p>
            </div>
            <div class="landing-feature-card">
                <div class="landing-feature-icon">
                    <i class="fa-solid fa-history"></i>
                </div>
                <h3 class="landing-feature-title">Complete Audit Trail</h3>
                <p class="landing-feature-description">Track every stock movement. See who did what and when for full accountability across your team.</p>
            </div>
            <div class="landing-feature-card">
                <div class="landing-feature-icon">
                    <i class="fa-solid fa-mobile"></i>
                </div>
                <h3 class="landing-feature-title">Mobile-First Design</h3>
                <p class="landing-feature-description">Access your inventory anywhere. Works smoothly on phones, tablets, and desktops.</p>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="landing-benefits-section">
        <div class="landing-section-header" style="color: #fff; margin-bottom: 3rem;">
            <h2 class="landing-section-title" style="color: #fff;">Why Choose StockSync</h2>
            <p class="landing-section-description" style="color: rgba(226, 232, 240, 0.9);">The advantages you get</p>
        </div>
        <div class="landing-benefits-grid">
            <div class="landing-benefit-card">
                <div class="landing-benefit-number">42%</div>
                <div class="landing-benefit-title">Faster Operations</div>
                <p class="landing-benefit-description">Reduce stock-checking time with real-time visibility and automated updates.</p>
            </div>
            <div class="landing-benefit-card">
                <div class="landing-benefit-number">99.5%</div>
                <div class="landing-benefit-title">Accuracy Rate</div>
                <p class="landing-benefit-description">Minimize errors with automated tracking and comprehensive audit logs.</p>
            </div>
            <div class="landing-benefit-card">
                <div class="landing-benefit-number">∞</div>
                <div class="landing-benefit-title">Scalability</div>
                <p class="landing-benefit-description">Handle growth from single store to multi-location enterprise effortlessly.</p>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="landing-works-section">
        <div class="landing-section-header">
            <h2 class="landing-section-title">How It Works</h2>
            <p class="landing-section-description">Get started in three simple steps</p>
        </div>
        <div class="landing-works-grid">
            <div class="landing-step-card">
                <div class="landing-step-number">1</div>
                <h3 class="landing-step-title">Register</h3>
                <p class="landing-step-description">Create your account and set up your store in seconds.</p>
            </div>
            <div class="landing-step-card">
                <div class="landing-step-number">2</div>
                <h3 class="landing-step-title">Add Inventory</h3>
                <p class="landing-step-description">Import or manually add your products and categories.</p>
            </div>
            <div class="landing-step-card">
                <div class="landing-step-number">3</div>
                <h3 class="landing-step-title">Start Tracking</h3>
                <p class="landing-step-description">Begin tracking stock, sales, and operations in real time.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="landing-cta-section">
        <div class="landing-cta-box">
            <h2>Ready to streamline your inventory?</h2>
            <p>Join retail teams that are already using StockSync to manage their operations faster and smarter.</p>
            <div class="landing-cta-buttons">
                <a href="{{ route('register') }}" class="landing-btn-primary">
                    <i class="fa-solid fa-rocket"></i> Create Account
                </a>
                <a href="{{ route('login') }}" class="landing-btn-secondary">
                    Already a member? Sign In
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
