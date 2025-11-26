@extends('layout')

@push('styles')
    <style>
        .billing-container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .page-header {
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--border-color);
        }

        .page-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--text-color);
            margin: 0;
        }

        .billing-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            height: 100%;
        }

        .card-header-custom {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 0.875rem 1rem;
            font-weight: 600;
            font-size: 0.95rem;
            border-radius: 8px 8px 0 0;
        }

        .card-body-custom {
            padding: 1rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px dashed var(--border-color);
            font-size: 0.875rem;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #64748b;
            font-weight: 500;
        }

        .info-value {
            color: var(--text-color);
            font-weight: 600;
        }

        .orders-table {
            margin-top: 1rem;
        }

        .table {
            margin-bottom: 0;
            font-size: 0.875rem;
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
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tfoot td {
            background: #f8f9fa;
            font-weight: 700;
            padding: 0.75rem;
            border-top: 2px solid var(--border-color);
            font-size: 1rem;
            color: #16a34a;
        }

        .product-name {
            font-weight: 600;
            color: var(--text-color);
        }

        .quantity-badge {
            background: #dbeafe;
            color: #1e40af;
            padding: 0.25rem 0.625rem;
            border-radius: 4px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .customer-form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .form-group-custom {
            margin-bottom: 0;
        }

        .form-group-custom label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            padding: 0.625rem 0.875rem;
            font-size: 0.875rem;
            border-radius: 6px;
            border: 1px solid var(--border-color);
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .payment-summary {
            background: #f0fdf4;
            border: 1px solid #86efac;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
        }

        .payment-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .payment-label {
            font-size: 1rem;
            font-weight: 600;
            color: #166534;
        }

        .payment-amount {
            font-size: 1.75rem;
            font-weight: 700;
            color: #16a34a;
        }

        .btn-pay {
            width: 100%;
            padding: 0.875rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 8px;
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
            border: none;
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-pay:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(22, 163, 74, 0.4);
        }

        @media (max-width: 992px) {
            .page-title {
                font-size: 1.25rem;
            }

            .orders-table {
                margin-top: 0.75rem;
            }

            .payment-amount {
                font-size: 1.5rem;
            }

            .card-body-custom {
                padding: 0.875rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid billing-container">
        <!-- Header -->
        <div class="page-header">
            <h2 class="page-title">
                <i class="fas fa-file-invoice-dollar text-primary me-2"></i>Checkout
            </h2>
        </div>

        <div class="row g-3">
            <!-- Order Summary (Left) -->
            <div class="col-lg-7">
                <div class="billing-card">
                    <div class="card-header-custom">
                        <i class="fas fa-shopping-bag me-2"></i>Order Summary
                    </div>
                    <div class="card-body-custom">
                        <!-- Station & Date Info -->
                        <div class="mb-3">
                            <div class="info-row">
                                <span class="info-label">Station</span>
                                <span class="info-value">{{ $billings->station->station_name }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Date & Time</span>
                                <span class="info-value">{{ $billings->created_at->format('M d, Y - h:i A') }}</span>
                            </div>
                        </div>

                        <!-- Orders Table -->
                        <div class="orders-table">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th class="text-center" style="width: 80px;">Qty</th>
                                            <th class="text-end" style="width: 100px;">Price</th>
                                            <th class="text-end" style="width: 100px;">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($billings->orders as $order)
                                            <tr>
                                                <td class="product-name">{{ $order->product->product_name }}</td>
                                                <td class="text-center">
                                                    <span class="quantity-badge">{{ $order->quantity }}</span>
                                                </td>
                                                <td class="text-end text-muted">
                                                    {{ number_format($order->product->product_price, 2) }}</td>
                                                <td class="text-end fw-semibold">
                                                    {{ number_format($order->quantity * $order->product->product_price, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end">Total Amount:</td>
                                            <td class="text-end">Rs. {{ number_format($billings->total, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Details Form (Right) -->
            <div class="col-lg-5">
                <div class="billing-card">
                    <div class="card-header-custom">
                        <i class="fas fa-user me-2"></i>Customer Details
                    </div>
                    <div class="card-body-custom">
                        <form action="{{ route('billings.update', $billings->id) }}" method="POST" class="customer-form">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="id" value="{{ $billings->id }}">
                            <input type="hidden" name="total" value="{{ $billings->total }}">

                            <div class="form-group-custom">
                                <label for="Name">Customer Name</label>
                                <input type="text" class="form-control" id="Name" name="customer_name"
                                    placeholder="Enter full name" required>
                            </div>

                            <!-- Payment Summary -->
                            <div class="payment-summary">
                                <div class="payment-total">
                                    <span class="payment-label">Amount to Pay:</span>
                                    <span class="payment-amount">Rs. {{ number_format($billings->total, 2) }}</span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success btn-pay">
                                <i class="fas fa-credit-card me-2"></i>Complete Payment
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
