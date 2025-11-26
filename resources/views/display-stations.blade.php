@extends('layout')

@push('styles')
    <style>
        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.25rem;
        }

        .page-subtitle {
            color: #64748b;
            font-size: 0.875rem;
        }

        .table-card {
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid var(--border-color);
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .table-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: #3b82f6;
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .table-card:hover::before {
            transform: scaleX(1);
        }

        .table-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border-color: #3b82f6;
        }

        .table-card.occupied {
            background: linear-gradient(to bottom, #ffffff, #fef2f2);
        }

        .table-card.available {
            background: linear-gradient(to bottom, #ffffff, #f0fdf4);
        }

        .table-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 0.75rem;
        }

        .table-icon.available {
            background: #dcfce7;
            color: #16a34a;
        }

        .table-icon.occupied {
            background: #fee2e2;
            color: #dc2626;
        }

        .table-number {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }

        .table-status {
            font-size: 0.8rem;
            font-weight: 500;
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            display: inline-block;
        }

        .table-status.available {
            background: #dcfce7;
            color: #16a34a;
        }

        .table-status.occupied {
            background: #fee2e2;
            color: #dc2626;
        }

        .stats-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            background: var(--bg-color);
            border: 1px solid var(--border-color);
        }

        .stats-badge i {
            font-size: 1rem;
        }

        .stats-badge.total {
            background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
            color: #374151;
        }

        .stats-badge.available {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            color: #16a34a;
        }

        .stats-badge.occupied {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #dc2626;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 1.25rem;
            }

            .stats-badge {
                font-size: 0.75rem;
                padding: 0.375rem 0.75rem;
            }

            .table-icon {
                width: 40px;
                height: 40px;
                font-size: 1.25rem;
            }

            .table-number {
                font-size: 1.1rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Header with Stats -->
        <div class="d-flex flex-wrap justify-content-between align-items-center page-header mb-3">
            <div>
                <h2 class="page-title mb-1">Stations</h2>
                <p class="page-subtitle mb-0">Select a station to continue</p>
            </div>
            <div class="d-flex flex-wrap gap-2 mt-2 mt-md-0">
                <span class="stats-badge total">
                    <i class="fas fa-table"></i>
                    <span>{{ count($stations) }} Total</span>
                </span>
                <span class="stats-badge available">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ $stations->where('status', 0)->count() }} Available</span>
                </span>
                <span class="stats-badge occupied">
                    <i class="fas fa-clock"></i>
                    <span>{{ $stations->where('status', 1)->count() }} Occupied</span>
                </span>
            </div>
        </div>

        <!-- Station Cards Grid -->
        <div class="row g-3">
            @forelse ($stations as $station)
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                    <a href="{{ route('stations.show', $station->id) }}" style="text-decoration: none; color: inherit;">
                        <div class="card table-card {{ $station->status == 0 ? 'available' : 'occupied' }}">
                            <div class="card-body text-center p-3">
                                <div class="table-icon {{ $station->status == 0 ? 'available' : 'occupied' }}">
                                    <i class="fas {{ $station->status == 0 ? 'fa-chair' : 'fa-utensils' }}"></i>
                                </div>
                                <div class="table-number">{{ $station->station_name }}</div>
                                <span class="table-status {{ $station->status == 0 ? 'available' : 'occupied' }}">
                                    {{ $station->status == 0 ? 'Available' : 'Occupied' }}
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-inbox text-muted" style="font-size: 3rem; opacity: 0.5;"></i>
                        <h5 class="mt-3 text-muted">No Stations Found</h5>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
