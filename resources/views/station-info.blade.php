@extends('layout')

@push('styles')
    <style>
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--border-color);
        }

        .page-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-color);
            margin: 0;
        }

        .add-order-form {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .orders-table-wrapper {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #f8f9fa;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: #64748b;
            border-bottom: 1px solid var(--border-color);
            padding: 0.625rem 0.75rem;
        }

        .table tbody td {
            padding: 0.625rem 0.75rem;
            vertical-align: middle;
            font-size: 0.875rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr:hover {
            background: #f8fafc;
        }

        .table tfoot td {
            background: #f8f9fa;
            font-weight: 600;
            padding: 0.75rem;
            border-top: 2px solid var(--border-color);
            font-size: 0.9rem;
        }

        .checkout-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.875rem 1rem;
            margin-top: 1rem;
        }

        .checkout-total {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .checkout-label {
            font-size: 0.9rem;
            font-weight: 500;
            color: #64748b;
        }

        .checkout-amount {
            font-size: 1.5rem;
            font-weight: 700;
            color: #16a34a;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }

        .btn-checkout {
            padding: 0.625rem 1.5rem;
            font-weight: 600;
            border-radius: 6px;
        }

        .empty-state {
            padding: 2.5rem 1rem;
            text-align: center;
        }

        .empty-state i {
            font-size: 2.5rem;
            color: #cbd5e0;
            margin-bottom: 0.75rem;
        }

        .empty-state p {
            color: #64748b;
            margin: 0;
            font-size: 0.875rem;
        }

        .form-control,
        .form-select {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 6px;
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 500;
            color: #475569;
            margin-bottom: 0.375rem;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.375rem 0.625rem;
        }

        .product-name {
            font-weight: 600;
            color: var(--text-color);
            font-size: 0.95rem;
        }

        .quantity-badge {
            font-weight: 600;
            font-size: 0.85rem;
            padding: 0.4rem 0.75rem;
        }

        .modal-content {
            border-radius: 10px;
            border: none;
        }

        .modal-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border-color);
        }

        .modal-body {
            padding: 1.25rem;
        }

        .modal-footer {
            padding: 1rem 1.25rem;
            background: #f8f9fa;
            border-top: 1px solid var(--border-color);
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 1.1rem;
            }

            .add-order-form {
                padding: 0.875rem;
            }

            .table thead th,
            .table tbody td {
                padding: 0.5rem;
                font-size: 0.8rem;
            }

            .checkout-bar {
                flex-direction: column;
                gap: 0.75rem;
                align-items: stretch;
            }

            .checkout-amount {
                font-size: 1.25rem;
            }

            .btn-checkout {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="page-header d-flex align-items-center justify-content-between">
            <h2 class="page-title mb-0">{{ $stationInfo->station_name }}</h2>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('stations.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
                <span class="badge bg-primary">{{ $orders->count() }} items</span>
            </div>
        </div>

        <!-- Add Product Form -->
        <div class="add-order-form">
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <input type="hidden" name="station_id" value="{{ $stationInfo->id }}">
                <div class="row g-2">
                    <div class="col-md-7">
                        <label for="product_id" class="form-label">Product</label>
                        <select name="product_id" id="product_id" class="form-select" required>
                            <option value="" disabled selected>Select product...</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">
                                    {{ $product->product_name }} - Rs. {{ $product->product_price }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="quantity" class="form-label">Qty</label>
                        <input type="number" name="quantity" id="quantity" value="1" min="1"
                            class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label d-none d-md-block">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-plus me-1"></i>Add
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="orders-table-wrapper">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th class="text-center" style="width: 80px;">Qty</th>
                            <th class="text-end" style="width: 100px;">Price</th>
                            <th class="text-end" style="width: 100px;">Total</th>
                            <th class="text-center" style="width: 80px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($orders->isEmpty())
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="fas fa-cart-plus"></i>
                                        <p>No items added yet</p>
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="product-name">{{ $order->product->product_name }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark">{{ $order->quantity }}</span>
                                    </td>
                                    <td class="text-end">{{ number_format($order->product->product_price, 2) }}</td>
                                    <td class="text-end fw-semibold">
                                        {{ number_format($order->quantity * $order->product->product_price, 2) }}
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                            data-url="{{ route('orders.delete') }}?id={{ $order->id }}&station_id={{ $stationInfo->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    @if ($orders->isNotEmpty())
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end">Subtotal:</td>
                                <td class="text-end fw-bold text-success">
                                    {{ number_format($stationInfo->total_amount, 2) }}
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>

        <!-- Checkout Bar -->
        @if ($orders->isNotEmpty())
            <div class="checkout-bar">
                <div class="checkout-total">
                    <span class="checkout-label">Total:</span>
                    <span class="checkout-amount">Rs. {{ number_format($stationInfo->total_amount, 2) }}</span>
                </div>
                <form action="{{ route('billings.initiate', $billings->id) }}" method="GET">
                    @csrf
                    <button type="submit" class="btn btn-success btn-checkout">
                        <i class="fas fa-check me-2"></i>Checkout
                    </button>
                </form>
            </div>
        @endif
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title mb-0">Remove Item</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Remove this item from order?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const url = button.getAttribute('data-url');
            const form = deleteModal.querySelector('#deleteForm');
            form.action = url;
        });
    </script>
@endpush
