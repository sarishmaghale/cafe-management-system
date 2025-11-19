@extends('layout')

@section('content')
    <form action="{{ route('bills.detail') }}" method="GET">
        @csrf
        <div class="row mb-4">
            <div class="col-md-4">
                <input type="number"class="no-spin form-control" name="id" placeholder="Receipt num:" required>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100" type="submit">Search</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('bills.detail') }}" class="btn btn-secondary w-100">Reset
                </a>
            </div>
        </div>
    </form>
    @if ($bill)
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white text-center">
                        <h3 class="mb-0">Billing Receipt</h3>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <!-- Order Summary (Left) -->
                            <div class="col-lg-6">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-header bg-secondary text-white text-center">
                                        <h5 class="mb-0">Orders</h5>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="mb-3">
                                            <p><strong>Receipt Num:</strong> {{ $bill->bill_num }}</p>
                                            <p><strong>Date & Time:</strong> {{ $bill->created_at }}</p>
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
                                                    @foreach ($bill->orders as $order)
                                                        <tr>
                                                            <td>{{ $order->product->product_name }}</td>
                                                            <td>{{ $order->quantity }}</td>
                                                            <td>Rs. {{ $order->product->product_price }}</td>
                                                            <td>Rs.
                                                                {{ $order->quantity * $order->product->product_price }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot class="table-light">
                                                    <tr>
                                                        <th colspan="3" class="text-end">Total</th>
                                                        <th>Rs. {{ $bill->total }}</th>
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
                                        <div class="mb-3">
                                            <label for="Name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="Name" name="customer_name"
                                                placeholder="{{ $bill->customer_name }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <p><strong>Station/Table:</strong>{{ $bill->station->station_name }}
                                            </p>
                                            <p><strong>Checkout Date Time: </strong> {{ $bill->updated_at }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Billing Form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false
                });
            @elseif (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false
                });
            @endif
        });
    </script>
@endpush
