@extends('layout')

@push('styles')
    <style>
        .table-card {
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .table-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .table-number {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .table-status {
            font-size: 0.9rem;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-3">
        <h2 class="mb-4 text-center">Cafe Tables</h2>
        <div class="row g-4">

            @foreach ($stations as $station)
                <!-- Table Cards -->
                <div class="col-md-3 col-sm-6">
                    <div class="card text-center table-card">
                        <a href="{{ route('stations.show', $station->id) }}" style="text-decoration: none; color:inherit;s">

                            <div class="card-body">
                                <div class="table-number">{{ $station->station_name }}</div>
                                @if ($station->status == 0)
                                    <div class="table-status text-success">Available</div>
                                @else
                                    <div class="table-status text-danger">Occupied</div>
                                @endif
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
