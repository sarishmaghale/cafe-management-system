@extends('layout')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card text-center p-3 shadow">
                <h5>Total Sales</h5>
                <p class="h4 text-primary">Rs. {{ $dailySales }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3 shadow">
                <h5>Total Products</h5>
                <p class="h4 text-success">{{ $totalProducts }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3 shadow">
                <h5>Total Stations/Tables</h5>
                <p class="h4 text-warning">{{ $totalStations }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3 shadow">
                <h5>Components</h5>
                <p class="h4 text-danger">12</p>
            </div>
        </div>
    </div>

    <div class="card mt-3 p-2">
        <h5 class="mb-3">Sales This Month</h5>
        <div class="chart-container">
            <canvas id="salesChart"></canvas>
        </div>

    </div>
@endsection
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
