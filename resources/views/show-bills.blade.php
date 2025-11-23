@extends('layout')

@section('content')
    <div class="container my-3">
        <h2 class="mb-4 text-center">Bills History</h2>
        <!-- Search Form -->
        <form action="{{ route('bills.search') }}" method="GET">
            @csrf
            <div class="row mb-2 g-3 align-items-end">
                <!-- From Date -->
                <div class="col-auto d-flex flex-column">
                    <label for="fromDate" class="form-label mb-1">From</label>
                    <input type="date" id="fromDate" name="fromDate" class="form-control"
                        value="{{ request('fromDate') ?? '' }}">
                </div>

                <!-- To Date -->
                <div class="col-auto d-flex flex-column">
                    <label for="toDate" class="form-label mb-1">To</label>
                    <input type="date" id="toDate" name="toDate" class="form-control"
                        value="{{ request('toDate') ?? '' }}">
                </div>

                <!-- Receipt Number -->
                <div class="col-auto d-flex flex-column">
                    <label for="billNum" class="form-label mb-1">Receipt Number</label>
                    <input type="number" id="billNum" name="billNum" class="form-control no-spin"
                        placeholder="Enter number" value="{{ request('billNum') ?? '' }}">
                </div>

                <!-- Search Button -->
                <div class="col-auto d-flex flex-column mt-2">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>

                <!-- Reset Button -->
                <div class="col-auto d-flex flex-column mt-2">
                    <a href="{{ route('bills.show') }}" class="btn btn-secondary">Reset</a>
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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bills as $bill)
                        <!-- Sample Data -->
                        <tr>
                            <td>{{ $bill->bill_num }}</td>
                            <td>Rs.{{ $bill->total }}</td>
                            <td>{{ $bill->station->station_name }}</td>
                            <td>{{ $bill->created_at }}</td>
                            <td>{{ $bill->customer_name }}</td>
                            <td>
                                <a href="{{ route('bills.detail', $bill->bill_num) }}" class="btn btn-sm btn-primary">
                                    View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert"> No data found
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if ($bills->isNotEmpty())
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td colspan="2" class="text-center">Rs. {{ $bills->sum('total') }}</td>
                            <td colspan="3" class="text-start">: Total Sales</td>
                        </tr>
                    </tfoot>
                @endif

            </table>
        </div>
    </div>
@endsection
