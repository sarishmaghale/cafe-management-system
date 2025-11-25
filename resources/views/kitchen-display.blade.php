@extends('layout')
@push('styles')
    <style>
        .kds-header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        .kds-header h1 {
            margin: 0;
            color: #1e293b;
            font-size: 2rem;
        }

        .timestamp {
            color: #64748b;
            font-size: 1rem;
            margin-top: 3px;
        }

        .stats-bar {
            background: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            gap: 40px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: #3b82f6;
        }

        .stat-label {
            color: #64748b;
            font-size: 0.9rem;
        }

        .orders-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
        }

        .order-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: 3px solid transparent;
        }

        .order-card.new-order {
            background: #fef3c7;
            border: 3px solid #f59e0b;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                box-shadow: 0 2px 10px rgba(245, 158, 11, 0.3);
            }

            50% {
                box-shadow: 0 4px 20px rgba(245, 158, 11, 0.5);
            }
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e5e7eb;
        }

        .order-time {
            font-size: 0.9rem;
            color: #64748b;
        }

        .new-badge {
            display: inline-block;
            background: #ef4444;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .order-type {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 5px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .order-type.dine-in {
            background: #dbeafe;
            color: #1e40af;
        }

        .order-items {
            margin: 15px 0;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .item-name {
            font-weight: 600;
            color: #1e293b;
        }

        .item-quantity {
            background: #3b82f6;
            color: white;
            padding: 2px 10px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .btn-preparing {
            width: 100%;
            background: #3b82f6;
            border: none;
            padding: 12px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 15px;
        }

        .btn-preparing:hover {
            background: #2563eb;
        }

        @media (max-width: 768px) {
            .orders-grid {
                grid-template-columns: 1fr;
            }

            .stats-bar {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="kds-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1><i class="fas fa-utensils me-2"></i>Kitchen Display System</h1>
                    <div class="timestamp" id="currentTime"></div>
                </div>
            </div>
        </div>

        <div class="partialView" id="partialView">

        </div>

    </div>
@endsection

@push('scripts')
    <script>
        function updateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            document.getElementById('currentTime').textContent = now.toLocaleDateString('en-US', options);
        }
        updateTime();
        setInterval(updateTime, 1000);

        function loadOrders() {
            $.get('{{ route('kitchen.orders') }}', function(html) {
                $('#partialView').html(html);
            });
        }

        function markPreparing(id) {
            $.ajax({
                url: '{{ route('kitchen.update', ':id') }}'.replace(':id', id),
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        loadOrders(); // refresh the orders 
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error updating order:', error);
                }
            });
        }
        loadOrders();
        setInterval(loadOrders, 10000);
    </script>
@endpush
