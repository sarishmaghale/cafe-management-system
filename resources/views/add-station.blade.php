@extends('layout')

@push('styles')
    <style>
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

        .add-station-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .card-title-small {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-title-small i {
            color: #3b82f6;
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }

        .form-control {
            padding: 0.625rem 0.875rem;
            font-size: 0.875rem;
            border-radius: 6px;
            border: 2px solid var(--border-color);
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        .btn-add {
            padding: 0.625rem 1.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: 6px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
            transition: all 0.2s ease;
        }

        .btn-add:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        .stations-table-wrapper {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .table-header {
            background: #f8f9fa;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-header h6 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .table-header .badge {
            font-size: 0.75rem;
            padding: 0.375rem 0.625rem;
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
            padding: 0.875rem 0.75rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr:hover {
            background: #f8fafc;
        }

        .station-number {
            font-weight: 600;
            color: #64748b;
        }

        .station-name {
            font-weight: 600;
            color: var(--text-color);
        }

        .status-badge {
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
        }

        .status-badge.available {
            background: #dcfce7;
            color: #16a34a;
        }

        .status-badge.occupied {
            background: #fee2e2;
            color: #dc2626;
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

        @media (max-width: 768px) {
            .add-station-card {
                padding: 1rem;
            }

            .table-header {
                padding: 0.875rem 1rem;
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
                <i class="fas fa-building me-2 text-primary"></i>Manage Stations
            </h2>
        </div>

        <!-- Add Station Form -->
        <div class="add-station-card">
            <h5 class="card-title-small">
                <i class="fas fa-plus-circle"></i>Add New Station
            </h5>
            <form action="{{ route('stations.store') }}" method="POST">
                @csrf
                <div class="row g-2 align-items-end">
                    <div class="col-md-8">
                        <label for="name" class="form-label">Station / Table Name</label>
                        <input type="text" name="name" id="name" class="form-control"
                            placeholder="e.g., Table 1, Station A" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary btn-add w-100">
                            <i class="fas fa-plus me-1"></i>Add Station
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Stations List -->
        <div class="stations-table-wrapper">
            <div class="table-header">
                <h6>
                    <i class="fas fa-list"></i>All Stations
                </h6>
                <span class="badge bg-primary">{{ count($stations) }} Total</span>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">#</th>
                            <th>Station / Table Name</th>
                            <th style="width: 150px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stations as $index => $station)
                            <tr>
                                <td class="station-number">{{ $index + 1 }}</td>
                                <td class="station-name">{{ $station->station_name }}</td>
                                <td>
                                    @if ($station->status == 0)
                                        <span class="status-badge available">
                                            <i class="fas fa-check-circle"></i>Available
                                        </span>
                                    @else
                                        <span class="status-badge occupied">
                                            <i class="fas fa-clock"></i>Occupied
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <div class="empty-state">
                                        <i class="fas fa-building"></i>
                                        <h5>No Stations Yet</h5>
                                        <p>Add your first station to get started</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
