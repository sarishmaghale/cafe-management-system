@extends('layout')

@push('styles')
    <style>
        body {
            background: #f5f6fa;
        }

        /* Center the container */
        .create-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1rem;
        }

        /* Card styling */
        .create-card {
            width: 100%;
            max-width: 500px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .create-card-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 1rem 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
            text-align: center;
        }

        .create-card-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-control,
        .form-select {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            border-radius: 8px;
            border: 2px solid #d1d5db;
            transition: all 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        .action-buttons {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .btn-action {
            flex: 1;
            padding: 0.75rem;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .btn-cancel {
            background: white;
            border: 2px solid #d1d5db;
            color: #64748b;
        }

        .btn-cancel:hover {
            background: #f8f9fa;
            border-color: #94a3b8;
            color: #475569;
        }

        .btn-update {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
        }

        .btn-update:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.35);
        }

        @media (max-width: 576px) {
            .action-buttons {
                flex-direction: column;
            }

            .btn-action {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')
    <div class="create-container">
        <div class="create-card">
            <div class="create-card-header">
                <i class="fas fa-user-plus me-2"></i> Add New User
            </div>

            <div class="create-card-body">
                <form action=".." method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="fas fa-user"></i> Full Name
                        </label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter full name" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i> Email
                        </label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock"></i> Password
                        </label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Enter password" required>
                    </div>

                    <div class="form-group">
                        <label for="roles" class="form-label">
                            <i class="fas fa-user-tag"></i> Role
                        </label>
                        <select name="roles[]" id="roles" class="form-select" multiple required>
                            @foreach (getRoles() as $role)
                                <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="action-buttons">
                        <a href="{{ route('users.index') }}" class="btn btn-cancel btn-action">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-update btn-action">
                            <i class="fas fa-save me-1"></i> Create
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
