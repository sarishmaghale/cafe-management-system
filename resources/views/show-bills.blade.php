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

        .search-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 500;
            color: #475569;
            margin-bottom: 0.375rem;
        }

        .form-control {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 6px;
        }

        .btn-group-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .btn-sm-custom {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            border-radius: 6px;
        }

        .bills-table-wrapper {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
            font-size: 0.875rem;
        }

        .table thead th {
            background: #1e293b;
            color: white;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border-bottom: none;
            padding: 0.75rem;
        }

        .table tbody td {
            padding: 0.75rem;
            vertical-align: middle;
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
            font-weight: 700;
            padding: 0.875rem;
            border-top: 2px solid var(--border-color);
            font-size: 1rem;
        }

        .receipt-number {
            font-weight: 600;
            color: #3b82f6;
        }

        .amount-cell {
            font-weight: 600;
            color: #16a34a;
        }

        .station-badge {
            background: #e0e7ff;
            color: #4338ca;
            padding: 0.25rem 0.625rem;
            border-radius: 4px;
            font-weight: 500;
            font-size: 0.8rem;
            display: inline-block;
        }

        .date-cell {
            color: #64748b;
            font-size: 0.85rem;
        }

        .customer-name {
            font-weight: 500;
            color: var(--text-color);
        }

        .empty-state {
            padding: 3rem 1rem;
            text-align: center;
        }

        .empty-state i {
            font-size: 3rem;
            color: #cbd5e0;
            margin-bottom: 1rem;
        }

        .empty-state h5 {
            color: #64748b;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #94a3b8;
            margin: 0;
            font-size: 0.875rem;
        }

        .total-sales-row {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        }

        .total-sales-amount {
            color: #16a34a;
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 1.1rem;
            }

            .search-card {
                padding: 0.875rem;
            }

            .btn-group-actions {
                width: 100%;
            }

            .btn-group-actions .btn {
                flex: 1;
            }

            .table thead th,
            .table tbody td {
                padding: 0.625rem 0.5rem;
                font-size: 0.8rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="page-header">
            <h2 class="page-title">
                <i class="fas fa-file-invoice me-2 text-primary"></i>Bills History
            </h2>
            <span class="badge bg-primary">{{ $bills->count() }} Records</span>
        </div>

        <!-- Search Form -->
        <div class="search-card">
            <form action="{{ route('bills.search') }}" method="GET">
                @csrf
                <div class="row g-2 align-items-end">
                    <!-- From Date -->
                    <div class="col-md-2 col-sm-6">
                        <label for="fromDate" class="form-label">From Date</label>
                        <input type="date" id="fromDate" name="fromDate" class="form-control"
                            value="{{ request('fromDate') ?? '' }}">
                    </div>

                    <!-- To Date -->
                    <div class="col-md-2 col-sm-6">
                        <label for="toDate" class="form-label">To Date</label>
                        <input type="date" id="toDate" name="toDate" class="form-control"
                            value="{{ request('toDate') ?? '' }}">
                    </div>

                    <!-- Receipt Number -->
                    <div class="col-md-3 col-sm-6">
                        <label for="billNum" class="form-label">Receipt Number</label>
                        <input type="number" id="billNum" name="billNum" class="form-control no-spin"
                            placeholder="Enter receipt number" value="{{ request('billNum') ?? '' }}">
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-md-5 col-sm-6">
                        <label class="form-label d-none d-md-block">&nbsp;</label>
                        <div class="btn-group-actions">
                            <button type="submit" class="btn btn-primary btn-sm-custom">
                                <i class="fas fa-search me-1"></i>Search
                            </button>
                            <a href="{{ route('bills.show') }}" class="btn btn-secondary btn-sm-custom">
                                <i class="fas fa-redo me-1"></i>Reset
                            </a>
                            <button type="button" id="exportBtn" class="btn btn-success btn-sm-custom">
                                <i class="fas fa-file-export me-1"></i>Export
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Bills Table -->
        <div class="bills-table-wrapper">
            <div class="table-responsive">
                <table class="table" id="billsTable">
                    <thead>
                        <tr>
                            <th style="width: 120px;">Receipt #</th>
                            <th style="width: 120px;">Amount</th>
                            <th>Station</th>
                            <th style="width: 160px;">Date</th>
                            <th>Customer</th>
                            <th style="width: 80px;" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bills as $bill)
                            <tr>
                                <td class="receipt-number">#{{ $bill->bill_num }}</td>
                                <td class="amount-cell">Rs. {{ number_format($bill->total, 2) }}</td>
                                <td><span class="station-badge">{{ $bill->station->station_name }}</span></td>
                                <td class="date-cell">{{ $bill->created_at->format('M d, Y h:i A') }}</td>
                                <td class="customer-name">{{ $bill->customer_name }}</td>
                                <td class="text-center">
                                    <a href="{{ route('bills.detail', $bill->bill_num) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="fas fa-receipt"></i>
                                        <h5>No Bills Found</h5>
                                        <p>No bills match your search criteria</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if ($bills->isNotEmpty())
                        <tfoot>
                            <tr class="total-sales-row">
                                <td colspan="2" class="text-center total-sales-amount">
                                    <i class="fas fa-coins me-2"></i>Rs. {{ number_format($bills->sum('total'), 2) }}
                                </td>
                                <td colspan="4">
                                    <strong>Total Sales</strong>
                                    <span class="text-muted ms-2">({{ $bills->count() }} transactions)</span>
                                </td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('exportBtn').addEventListener('click', function() {
            let table = document.querySelector('#billsTable');
            let rows = table.querySelectorAll('tbody tr');
            let csvContent = 'Receipt Number,Amount,Station,Date,Customer\n';

            rows.forEach((row) => {
                let cols = row.querySelectorAll('td');
                if (cols.length > 1) { // Skip empty state row
                    let rowData = [];
                    for (let i = 0; i < 5; i++) { // First 5 columns only
                        if (cols[i]) {
                            let text = cols[i].innerText.replace(/,/g, '').trim();
                            rowData.push('"' + text + '"');
                        }
                    }
                    csvContent += rowData.join(',') + '\n';
                }
            });

            // Create blob and download
            let blob = new Blob([csvContent], {
                type: 'text/csv;charset=utf-8;'
            });
            let link = document.createElement('a');
            let url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', 'bills' + new Date().toISOString().split('T')[0] + '.csv');
            link.style.display = 'none';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    </script>
@endpush
