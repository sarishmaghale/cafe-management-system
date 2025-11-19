@extends('layout')

@section('content')
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="container mx-auto p-3">
        <h2 class="text-xl font-bold mb-4">Orders for {{ $stationInfo->station_name }}:</h2>
        <!-- Add New Product Form -->
        <form action="{{ route('orders.store') }}" method="POST" class="row g-2 align-items-center mb-4">
            @csrf
            <input type="hidden" name="station_id" value="{{ $stationInfo->id }}">

            <div class="col-auto">
                <label for="product_id" class="form-label fw-bold">Add Product:</label>
                <select name="product_id" id="product_id" class="form-select" required>
                    <option value="" disabled selected>--Select item--</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">
                            {{ $product->product_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-auto">
                <label for="quantity" class="form-label fw-bold">Qty:</label>
                <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control w-75"
                    required>
            </div>

            <div class="col-auto mt-5">
                <button type="submit" class="btn btn-primary">Add Order</button>
            </div>
        </form>



        <div class="table-responsive">
            <!-- Orders Table -->
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Product</th>
                        <th scope="col" class="text-center">Quantity</th>
                        <th scope="col" class="text-end">Price</th>
                        <th scope="col" class="text-end">Total</th>
                        <th>...</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($orders->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center text-muted">No orders yet.</td>
                        </tr>
                    @else
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->product->product_name }}</td>
                                <td class="text-center">{{ $order->quantity }}</td>
                                <td class="text-end">Rs. {{ $order->product->product_price }}</td>
                                <td class="text-end">
                                    {{ $order->quantity * $order->product->product_price }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal"
                                        data-url="{{ route('orders.delete') }}?id={{ $order->id }}&station_id={{ $stationInfo->id }}">
                                        Remove
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot class="table-light fw-bold">
                    <tr>
                        <td colspan="3" class="text-end">Total Amount:</td>
                        <td class="text-end">Rs. {{ $stationInfo->total_amount }}</td>
                    </tr>
                </tfoot>
            </table>

        </div>

        <!-- Checkout Button -->
        @if ($orders->isNotEmpty())
            <div class="d-flex justify-content-end mt-3">
                <form action="{{ route('billings.initiate', $billings->id) }}" method="GET">
                    @csrf
                    <button type="submit" class="btn btn-success btn-lg">Checkout</button>
                </form>
            </div>
        @endif
    </div>
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Remove</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to remove this item?
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Yes, Remove</button>
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
            const button = event.relatedTarget; // Button that opened the modal
            const url = button.getAttribute('data-url'); // Get the URL with query params
            const form = deleteModal.querySelector('#deleteForm');
            form.action = url; // Set the form action dynamically
        });
    </script>
@endpush
