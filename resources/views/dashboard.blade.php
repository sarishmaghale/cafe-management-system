@extends('layout')

@section('content')
    <div class="compact-content">
        <!-- Stats Cards -->
        <div class="row g-3 mb-3">
            <!-- Total Sales Card -->
            <div class="col-xl-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <p class="stats-label">Total Sales</p>
                                <h3 class="stats-value">Rs. {{ number_format($dailySales, 2) }}</h3>
                            </div>
                            <div class="stats-icon bg-primary-light">
                                <i class="fas fa-money-bill text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Products Card -->
            <div class="col-xl-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <p class="stats-label">Total Products</p>
                                <h3 class="stats-value">{{ $totalProducts }}</h3>
                            </div>
                            <div class="stats-icon bg-success-light">
                                <i class="fas fa-box text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Stations Card -->
            <div class="col-xl-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <p class="stats-label">Stations/Tables</p>
                                <h3 class="stats-value">{{ $totalStations }}</h3>
                            </div>
                            <div class="stats-icon bg-warning-light">
                                <i class="fas fa-building text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Components Card -->
            <div class="col-xl-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <p class="stats-label">Components</p>
                                <h3 class="stats-value">12</h3>
                            </div>
                            <div class="stats-icon bg-danger-light">
                                <i class="fas fa-cogs text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Card -->
        <div class="row g-3">
            <!-- Sales Chart - Left Side -->
            <div class="col-lg-8">
                <div class="card enhanced-card">
                    <div class="card-header">
                        <h5 class="card-title mb-1">Sales This Month</h5>
                        <p class="text-muted small mb-0">Daily revenue overview for {{ date('F Y') }}</p>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="height: 280px;">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Most Popular Products - Right Side -->
            <div class="col-lg-4">
                <div class="card enhanced-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Most Popular Products</h5>
                    </div>
                    <div class="card-body">
                        <div class="product-list">
                            <div class="product-item">
                                <div class="product-info">
                                    <div>
                                        <p class="product-name mb-0">Margherita Pizza</p>
                                    </div>
                                </div>
                                <span class="badge bg-primary">Top</span>
                            </div>

                            <div class="product-item">
                                <div class="product-info">
                                    <div>
                                        <p class="product-name mb-0">Cheese Burger</p>
                                    </div>
                                </div>
                                <span class="badge bg-success">2nd</span>
                            </div>

                            <div class="product-item">
                                <div class="product-info">
                                    <div>
                                        <p class="product-name mb-0">Cappuccino</p>
                                    </div>
                                </div>
                                <span class="badge bg-warning">3rd</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* ============================================
                                   COMPACT CONTENT WRAPPER
                                   ============================================ */
        .compact-content {
            margin-top: -1rem;
        }

        /* ============================================
                                   ENHANCED STATS CARDS
                                   ============================================ */
        .stats-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            overflow: hidden;
            position: relative;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
            border-color: #cbd5e0;
        }

        .stats-card:hover::before {
            opacity: 1;
        }

        .stats-card-body {
            padding: 1.25rem;
        }

        .stats-label {
            font-size: 0.8125rem;
            font-weight: 500;
            color: #64748b;
            margin-bottom: 0.375rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stats-value {
            font-size: 1.625rem;
            font-weight: 700;
            color: #1a202c;
            line-height: 1.2;
        }

        .stats-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 0.25rem 0.625rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .stats-badge i {
            font-size: 0.625rem;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .stats-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stats-icon i {
            font-size: 1.25rem;
        }

        .bg-primary-light {
            background: #dbeafe;
        }

        .bg-success-light {
            background: #d1fae5;
        }

        .bg-warning-light {
            background: #fef3c7;
        }

        .bg-danger-light {
            background: #fee2e2;
        }

        .bg-info-light {
            background: #cffafe;
        }

        /* ============================================
                                   PRODUCT LIST
                                   ============================================ */
        .product-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .product-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.875rem;
            background: #f8f9fa;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .product-item:hover {
            background: #f1f3f5;
            transform: translateX(4px);
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .product-name {
            font-weight: 600;
            font-size: 0.875rem;
            color: #1a202c;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }

        .bg-primary {
            background-color: #3b82f6 !important;
        }

        .bg-success {
            background-color: #10b981 !important;
        }

        .bg-warning {
            background-color: #f59e0b !important;
        }

        .bg-secondary {
            background-color: #64748b !important;
        }

        /* ============================================
                                   ENHANCED CARD
                                   ============================================ */
        .enhanced-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .enhanced-card .card-header {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 1.25rem;
        }

        .enhanced-card .card-title {
            font-size: 1rem;
            font-weight: 600;
            color: #1a202c;
            margin: 0;
        }

        .enhanced-card .card-body {
            padding: 1.25rem;
        }

        /* ============================================
                                   BUTTON ENHANCEMENTS
                                   ============================================ */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .btn-sm {
            padding: 0.375rem 0.875rem;
            font-size: 0.875rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            color: #ffffff;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        }

        .btn-outline-primary {
            border-color: #3b82f6;
            color: #3b82f6;
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: #3b82f6;
            color: #ffffff;
            transform: translateY(-1px);
        }

        .btn-outline-secondary {
            border-color: #e2e8f0;
            color: #64748b;
            background: transparent;
        }

        .btn-outline-secondary:hover,
        .btn-outline-secondary.active {
            background: #f1f5f9;
            border-color: #cbd5e0;
            color: #1a202c;
        }

        .btn-group-sm .btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.8125rem;
        }

        /* ============================================
                                   CHART CONTAINER
                                   ============================================ */
        .chart-container {
            position: relative;
            width: 100%;
            min-height: 280px;
        }

        .chart-container canvas {
            display: block;
            width: 100% !important;
            height: 100% !important;
        }

        /* ============================================
                                   RESPONSIVE DESIGN
                                   ============================================ */
        @media (max-width: 768px) {
            .page-header .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 1rem;
            }

            .stats-value {
                font-size: 1.5rem;
            }

            .stats-icon {
                width: 48px;
                height: 48px;
            }

            .stats-icon i {
                font-size: 1.25rem;
            }

            .chart-container {
                min-height: 280px;
            }
        }

        /* ============================================
                                   UTILITY CLASSES
                                   ============================================ */
        .gap-2 {
            gap: 0.5rem;
        }

        .gap-3 {
            gap: 1rem;
        }

        .text-primary {
            color: #3b82f6 !important;
        }

        .text-success {
            color: #10b981 !important;
        }

        .text-warning {
            color: #f59e0b !important;
        }

        .text-danger {
            color: #ef4444 !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart');
        const labels = @json($chartData['days']);
        const data = @json($chartData['totals']);
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Daily Sales (₨)',
                    data: data,
                    borderColor: '#007bff', // line color
                    fill: false, // <-- disables background shading
                    tension: 0.3, // smooth curve
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Day of Month'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Sales (₨)'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `₨ ${context.raw}`;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
