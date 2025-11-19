@extends('layout')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white text-center">
                        <h3 class="mb-0">Billing & Checkout</h3>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <!-- Order Summary (Left) -->
                            <div class="col-lg-6">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-header bg-secondary text-white text-center">
                                        <h5 class="mb-0">Your Orders</h5>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="mb-3">
                                            <p><strong>Station/Table:</strong> {{ $billings->station->station_name }}</p>
                                            <p><strong>Date & Time:</strong> {{ $billings->created_at }}</p>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Item</th>
                                                        <th>Qty</th>
                                                        <th>Price</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($billings->orders as $order)
                                                        <tr>
                                                            <td>{{ $order->product->product_name }}</td>
                                                            <td>{{ $order->quantity }}</td>
                                                            <td>Rs. {{ $order->product->product_price }}</td>
                                                            <td>Rs. {{ $order->quantity * $order->product->product_price }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot class="table-light">
                                                    <tr>
                                                        <th colspan="3" class="text-end">Total</th>
                                                        <th>Rs. {{ $billings->total }}</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Billing Form (Right) -->
                            <div class="col-lg-6">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-header bg-primary text-white text-center">
                                        <h5 class="mb-0">Customer Details</h5>
                                    </div>
                                    <div class="card-body p-4">
                                        <form action="{{ route('billings.update', $billings->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="Name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="Name"
                                                    name="customer_name" placeholder="Full Name" required>
                                            </div>
                                            <input type="hidden" name="id" value="{{ $billings->id }}">
                                            <input type="hidden" name="total" value="{{ $billings->total }}">
                                            <div class="mb-3">
                                                <p><strong>Station/Table:</strong> {{ $billings->station->station_name }}
                                                </p>
                                                <p><strong>Date & Time:</strong> {{ $billings->created_at }}</p>
                                            </div>

                                            <button type="submit" class="btn btn-success w-100 mt-3">Pay</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End Billing Form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
