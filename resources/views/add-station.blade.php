@extends('layout')


@section('content')
    <div class="container">
        <h2>Add Station / Table</h2>
        <!-- Form to add station -->
        <form action="{{ route('stations.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Station / Table Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter name" required>
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>

        <hr>
        <!-- Include the station list Blade -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Station/Table Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stations as $index => $station)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $station->station_name }}</td>
                            <td>
                                {{-- Option 1: Badge with icon --}}
                                @if ($station->status == 0)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i> Available
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle me-1"></i> Occupied
                                    </span>
                                @endif

                                {{-- Option 2: Circle indicator --}}
                                {{-- 
                            <span class="status-dot rounded-circle" 
                                  style="width: 15px; height: 15px; display:inline-block; 
                                  background-color: {{ $station->status == 0 ? 'green' : 'red' }};">
                            </span> 
                            --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
