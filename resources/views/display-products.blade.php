@extends('layout')

@push('styles')
    <style>
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .page-title-section h2 {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text-color);
            margin: 0 0 0.25rem 0;
        }

        .page-subtitle {
            font-size: 0.875rem;
            color: #64748b;
            margin: 0;
        }

        .btn-add-product {
            padding: 0.625rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: 8px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
            transition: all 0.3s ease;
        }

        .btn-add-product:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.35);
        }

        .stats-bar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            padding: 1rem 1.5rem;
            margin-bottom: 1rem;
            display: flex;
            gap: 3rem;
            align-items: center;
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .stat-icon {
            font-size: 1.75rem;
            opacity: 0.9;
        }

        .stat-content span {
            display: block;
            font-size: 0.75rem;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-content strong {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .products-table-wrapper {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .table {
            margin-bottom: 0;
            font-size: 0.875rem;
        }

        .table thead th {
            background: linear-gradient(135deg, #1e293b, #334155);
            color: white;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: none;
            padding: 1rem 0.875rem;
        }

        .table tbody td {
            padding: 1rem 0.875rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background: linear-gradient(to right, #f8fafc, #ffffff);
            transform: scale(1.01);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .product-id {
            font-weight: 600;
            color: #3b82f6;
            font-family: 'Courier New', monospace;
        }

        .product-name-cell {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .product-icon-small {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            font-size: 0.9rem;
        }

        .product-name {
            font-weight: 600;
            color: var(--text-color);
            font-size: 0.95rem;
        }

        .product-price {
            font-weight: 700;
            color: #16a34a;
            font-size: 1rem;
        }

        .product-actions {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
        }

        .btn-action {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-edit {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
        }

        .btn-edit:hover {
            background: #e2e8f0;
            color: #1e293b;
            transform: translateY(-1px);
        }

        .btn-delete {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .btn-delete:hover {
            background: #fecaca;
            color: #991b1b;
            transform: translateY(-1px);
        }

        .modal-content {
            border-radius: 12px;
            border: none;
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 1.25rem 1.5rem;
            border: none;
        }

        .modal-title {
            font-size: 1.15rem;
            font-weight: 600;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1rem 1.5rem;
            background: #f8f9fa;
            border-top: 1px solid var(--border-color);
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
            display: block;
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

        .empty-state {
            background: white;
            border: 2px dashed var(--border-color);
            border-radius: 12px;
            padding: 4rem 2rem;
            text-align: center;
        }

        .empty-state-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .empty-state-icon i {
            font-size: 2.5rem;
            color: #94a3b8;
        }

        .empty-state h5 {
            color: var(--text-color);
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #64748b;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .btn-add-product {
                width: 100%;
            }

            .stats-bar {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .product-name-cell {
                flex-direction: column;
                align-items: flex-start;
            }

            .product-actions {
                flex-direction: column;
                width: 100%;
            }

            .btn-action {
                width: 100%;
            }

            .table thead th,
            .table tbody td {
                padding: 0.75rem 0.5rem;
                font-size: 0.8rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="page-header">
            <div class="page-title-section">
                <h2><i class="fas fa-box-open me-2" style="color: #3b82f6;"></i>Product Catalog</h2>
                <p class="page-subtitle">Manage your products and pricing</p>
            </div>
            <button type="button" class="btn btn-primary btn-add-product" data-bs-toggle="modal"
                data-bs-target="#newProductModal">
                <i class="fas fa-plus me-2"></i>Add Product
            </button>
        </div>

        <!-- Stats Bar -->
        <div class="stats-bar">
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-cube"></i>
                </div>
                <div class="stat-content">
                    <span>Total Products</span>
                    <strong>{{ count($products) }}</strong>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-content">
                    <span>Avg. Price</span>
                    {{-- <strong>Rs.
                        {{ count($products) > 0 ? number_format($products->avg('product_price'), 2) : '0.00' }}
                    </strong> --}}
                </div>
            </div>
        </div>

        <!-- Products Table -->
        @if (count($products) > 0)
            <div class="products-table-wrapper">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 100px;">ID</th>
                                <th>Product Name</th>
                                <th style="width: 150px;">Price</th>
                                <th style="width: 180px;" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td class="product-id">#{{ str_pad($product->id, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td>
                                        <div class="product-name-cell">
                                            <div class="product-icon-small">
                                                <i class="fas fa-box"></i>
                                            </div>
                                            <span class="product-name">{{ $product->product_name }}</span>
                                        </div>
                                    </td>
                                    <td class="product-price">Rs. {{ number_format($product->product_price, 2) }}</td>
                                    <td>
                                        <div class="product-actions">
                                            <form action="{{ route('products.edit', $product->id) }}" method="GET"
                                                style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-edit btn-action">
                                                    <i class="fas fa-edit me-1"></i>Edit
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-delete btn-action" data-bs-toggle="modal"
                                                data-bs-target="#deleteProductModal" data-url="..?id={{ $product->id }}">
                                                <i class="fas fa-trash me-1"></i>Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <h5>No Products Yet</h5>
                <p>Start building your product catalog by adding your first product</p>
                <button type="button" class="btn btn-primary btn-add-product" data-bs-toggle="modal"
                    data-bs-target="#newProductModal">
                    <i class="fas fa-plus me-2"></i>Add Your First Product
                </button>
            </div>
        @endif
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="newProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle me-2"></i>Add New Product
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="product_name" class="form-label">
                                <i class="fas fa-tag me-1"></i>Product Name
                            </label>
                            <input type="text" class="form-control" id="product_name" name="product_name"
                                placeholder="e.g., Cappuccino, Caesar Salad" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="product_price" class="form-label">
                                <i class="fas fa-money-bill-wave me-1"></i>Price
                            </label>
                            <div class="input-group">
                                <input type="number" class="form-control no-spin" id="product_price" name="product_price"
                                    placeholder="Rs." min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Save Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title mb-0">Remove Product</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Remove this product?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteProductForm" method="POST" action="">
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
        const deleteProductModal = document.getElementById('deleteProductModal');
        deleteProductModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const url = button.getAttribute('data-url');
            const form = deleteModal.querySelector('#deleteProductForm');
            form.action = url;
        });
    </script>
@endpush
