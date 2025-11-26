@extends('layout')

@push('styles')
    <style>
        .receipt-container {
            max-width: 1000px;
            margin: 0 auto;
        }

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

        .receipt-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
        }

        .receipt-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 0.875rem 1rem;
            text-align: center;
        }

        .receipt-number {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.125rem;
        }

        .receipt-subtitle {
            font-size: 0.75rem;
            opacity: 0.9;
        }

        .receipt-body {
            padding: 1rem;
        }

        .info-section {
            background: #f8f9fa;
            border-radius: 6px;
            padding: 0.75rem;
            margin-bottom: 0.875rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.375rem 0;
            border-bottom: 1px dashed #e2e8f0;
        }

        .info-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .info-label {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 500;
        }

        .info-value {
            font-size: 0.8rem;
            color: var(--text-color);
            font-weight: 600;
        }

        .section-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.625rem;
            padding-bottom: 0.375rem;
            border-bottom: 2px solid var(--border-color);
        }

        .table {
            margin-bottom: 0;
            font-size: 0.8rem;
        }

        .table thead th {
            background: #f8f9fa;
            font-weight: 600;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: #64748b;
            border-bottom: 2px solid var(--border-color);
            padding: 0.5rem;
        }

        .table tbody td {
            padding: 0.5rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tfoot td {
            background: #f0fdf4;
            font-weight: 700;
            padding: 0.625rem;
            border-top: 2px solid #86efac;
            font-size: 0.9rem;
            color: #16a34a;
        }

        .product-name {
            font-weight: 600;
            color: var(--text-color);
        }

        .quantity-badge {
            background: #dbeafe;
            color: #1e40af;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-weight: 600;
            font-size: 0.8rem;
            display: inline-block;
        }

        .customer-info-card {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border: 1px solid #86efac;
            border-radius: 8px;
            padding: 1.25rem;
        }

        .customer-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: #16a34a;
            margin-bottom: 0.75rem;
        }

        .btn-print {
            padding: 0.625rem 1.5rem;
            font-weight: 600;
            border-radius: 6px;
            background: #3b82f6;
            border: none;
            color: white;
            transition: all 0.2s ease;
        }

        .btn-print:hover {
            background: #2563eb;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3);
        }

        .btn-back {
            padding: 0.625rem 1.5rem;
            font-weight: 600;
            border-radius: 6px;
            background: white;
            border: 1px solid var(--border-color);
            color: var(--text-color);
            transition: all 0.2s ease;
        }

        .btn-back:hover {
            background: #f8f9fa;
            border-color: #3b82f6;
            color: #3b82f6;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .receipt-container,
            .receipt-container * {
                visibility: visible;
            }

            .receipt-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .btn-print,
            .btn-back,
            .page-header {
                display: none !important;
            }
        }

        @media (max-width: 768px) {
            .receipt-header {
                padding: 1rem;
            }

            .receipt-number {
                font-size: 1.5rem;
            }

            .receipt-body {
                padding: 1rem;
            }

            .info-section {
                padding: 0.875rem;
            }

            .table thead th,
            .table tbody td {
                padding: 0.625rem 0.5rem;
                font-size: 0.8rem;
            }

            .customer-name {
                font-size: 1.1rem;
            }
        }
    </style>
@endpush

@section('content')
    @if ($bill)
        <div class="container-fluid receipt-container">
            <!-- Header with Actions -->
            <div class="page-header">
                <h2 class="page-title">
                    <i class="fas fa-file-invoice me-2 text-primary"></i>Receipt Details
                </h2>
                <div class="d-flex gap-2">
                    <button onclick="window.print()" class="btn btn-print">
                        <i class="fas fa-print me-1"></i>Print
                    </button>
                    <a href="{{ route('bills.show') }}" class="btn btn-back">
                        <i class="fas fa-arrow-left me-1"></i>Back
                    </a>
                </div>
            </div>

            <!-- Receipt Card -->
            <div class="receipt-card">
                <!-- Receipt Header -->
                <div class="receipt-header">
                    <div class="receipt-number">#{{ $bill->bill_num }}</div>
                    <div class="receipt-subtitle">Official Receipt</div>
                </div>

                <!-- Receipt Body -->
                <div class="receipt-body">
                    <div class="row g-3">
                        <!-- Left Column: Order Details -->
                        <div class="col-lg-7">
                            <!-- Receipt Info -->
                            <div class="info-section">
                                <div class="info-row">
                                    <span class="info-label">Station/Table</span>
                                    <span class="info-value">{{ $bill->station->station_name }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Order Date</span>
                                    <span class="info-value">{{ $bill->created_at->format('M d, Y - h:i A') }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Checkout Date</span>
                                    <span class="info-value">{{ $bill->updated_at->format('M d, Y - h:i A') }}</span>
                                </div>
                            </div>

                            <!-- Orders Table -->
                            <h6 class="section-title">
                                <i class="fas fa-shopping-bag me-2"></i>Order Items
                            </h6>
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
                                        @foreach ($bill->orders as $order)
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
                                            <td class="text-end">Rs. {{ number_format($bill->total, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- Right Column: Customer Details -->
                        <div class="col-lg-5">
                            <h6 class="section-title">
                                <i class="fas fa-user me-2"></i>Customer Information
                            </h6>
                            <div class="customer-info-card">
                                <div class="customer-name">
                                    <i class="fas fa-user-circle me-2"></i>{{ $bill->customer_name }}
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Payment Status</span>
                                    <span class="badge bg-success">Paid</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Payment Method</span>
                                    <span class="info-value">Cash</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Total Items</span>
                                    <span class="info-value">{{ $bill->orders->sum('quantity') }} items</span>
                                </div>
                            </div>

                            <!-- Summary Box -->
                            <div class="mt-3 p-3 border rounded"
                                style="background: #fefce8; border-color: #fde047 !important;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span style="font-size: 1rem; font-weight: 600; color: #854d0e;">Amount Paid:</span>
                                    <span style="font-size: 1.5rem; font-weight: 700; color: #16a34a;">
                                        Rs. {{ number_format($bill->total, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
