@extends('layout')

@section('content')
    <div class="container my-3">
        <h2 class="mb-4 text-center">Bills History</h2>
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
        <!-- Search Form -->
        <form action="{{ route('bills.show') }}" method="GET">
            @csrf
            <div class="row mb-4">
                <div class="col-md-4">
                    <input type="date" id="searchDate" class="form-control" name="searchDate" placeholder="Select Date">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit">Search</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('bills.show') }}" class="btn btn-secondary w-100">Reset
                    </a>
                </div>
            </div>
        </form>

        <!-- Bills Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="billsTable">
                <thead class="table-dark">
                    <tr>
                        <th>Receipt Num</th>
                        <th>Total Amount</th>
                        <th>Station/Table</th>
                        <th>Billing Date</th>
                        <th>Customer Name</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($bills as $bill)
                        <!-- Sample Data -->
                        <tr>
                            <td>{{ $bill->bill_num }}</td>
                            <td>Rs.{{ $bill->total }}</td>
                            <td>{{ $bill->station->station_name }}</td>
                            <td>{{ $bill->created_at }}</td>
                            <td>{{ $bill->customer_name }}</td>
                        </tr>
                    @endforeach

                </tbody>
                <tfoot class="table-light fw-bold">
                    <tr>
                        <td colspan="2" class="text-center">Rs. {{ $bills->sum('total') }}</td>

                        <td colspan="3" class="text-start">: Total Sales</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
