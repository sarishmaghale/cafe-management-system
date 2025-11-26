@extends('layout')

@push('styles')
    <style>
        .edit-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .page-header {
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

        .edit-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .edit-card-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .edit-card-header h5 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .product-id-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .edit-card-body {
            padding: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-label i {
            color: #3b82f6;
        }

        .form-control {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            border-radius: 8px;
            border: 2px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        .input-group {
            position: relative;
        }

        .input-group-text {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-weight: 600;
            color: #64748b;
            pointer-events: none;
            z-index: 10;
        }

        .input-group .form-control {
            padding-left: 3rem;
        }

        .current-value {
            background: #f8f9fa;
            border-radius: 6px;
            padding: 0.5rem 0.75rem;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .current-value strong {
            color: var(--text-color);
        }

        .action-buttons {
            display: flex;
            gap: 0.75rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }

        .btn-action {
            flex: 1;
            padding: 0.75rem;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .btn-cancel {
            background: white;
            border: 2px solid var(--border-color);
            color: #64748b;
        }

        .btn-cancel:hover {
            background: #f8f9fa;
            border-color: #94a3b8;
            color: #475569;
        }

        .btn-update {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
        }

        .btn-update:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.35);
        }

        @media (max-width: 768px) {
            .edit-card-body {
                padding: 1.25rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-action {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid edit-container">
        <!-- Header -->
        <div class="page-header">
            <h2 class="page-title">
                <i class="fas fa-edit me-2 text-primary"></i>Edit Product
            </h2>
        </div>

        <!-- Edit Form Card -->
        <div class="edit-card">
            <div class="edit-card-header">
                <h5>
                    <i class="fas fa-box me-2"></i>{{ $products->product_name }}
                </h5>
                <span class="product-id-badge">#{{ str_pad($products->id, 3, '0', STR_PAD_LEFT) }}</span>
            </div>

            <div class="edit-card-body">
                <form action="{{ route('products.update', $products->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $products->id }}">

                    <!-- Product Name -->
                    <div class="form-group">
                        <label for="product_name" class="form-label">
                            <i class="fas fa-tag"></i>Product Name
                        </label>
                        <div class="current-value">
                            <i class="fas fa-info-circle"></i>
                            <span>Current: <strong>{{ $products->product_name }}</strong></span>
                        </div>
                        <input type="text" class="form-control" id="product_name" name="product_name"
                            value="{{ $products->product_name }}" placeholder="Enter new product name" required>
                    </div>

                    <!-- Product Price -->
                    <div class="form-group">
                        <label for="product_price" class="form-label">
                            <i class="fas fa-money-bill-wave"></i>Product Price
                        </label>
                        <div class="current-value">
                            <i class="fas fa-info-circle"></i>
                            <span>Current: <strong>Rs. {{ number_format($products->product_price, 2) }}</strong></span>
                        </div>
                        <div class="input-group">
                            <input type="number" class="form-control no-spin" id="product_price" name="product_price"
                                value="{{ $products->product_price }}" placeholder="Rs." step="0.01" min="0"
                                required>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <a href="{{ route('products.show') }}" class="btn btn-cancel btn-action">
                            <i class="fas fa-times me-1"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-update btn-action">
                            <i class="fas fa-save me-1"></i>Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
