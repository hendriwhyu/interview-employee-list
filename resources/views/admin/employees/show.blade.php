@extends('layouts.dashboard')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">
        <span class="text-muted fw-light">Employees / </span>Employee Details
    </h4>

    <!-- Notification for Success -->
    <div id="notification-alert" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
        <strong id="notification-message"></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Employee Details</h5>
            <!-- Button to edit employee -->
            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary">
                <i class="bx bx-edit-alt me-1"></i> Edit
            </a>
        </div>
        <div class="card-body">
            <!-- Display Fields -->

            <!-- Display photo if exists -->
            <div class="mb-3 mx-auto w-25">
                @if(Str::startsWith($employee->photo, 'http'))
                    <img src="{{ $employee->photo }}" class="img-fluid" alt="Employee Photo" />
                @else
                    <img src="{{ asset('storage/' . $employee->photo) }}" class="img-fluid" alt="Employee Photo" />
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label" for="name">Full Name</label>
                <p id="name" class="form-control">{{ $employee->name }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <p id="email" class="form-control">{{ $employee->email }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label" for="position">Position</label>
                <p id="position" class="form-control">{{ $employee->position }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label" for="entry-date">Entry Date</label>
                <p id="entry-date" class="form-control">{{ $employee->entry_date }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label" for="phone">Phone</label>
                <p id="phone" class="form-control">{{ $employee->phone_number }}</p>
            </div>

            <!-- Display documents if exists -->
            @if($employee->documents && count($employee->documents) > 0)
                <div class="mb-3">
                    <label class="form-label" for="documents">Appointment Documents</label>
                    <ul class="list-group">
                        @foreach($employee->documents as $document)
                            <li class="list-group-item">
                                <a href="{{ asset('storage/' . $document->path) }}" target="_blank">
                                    {{ $document->filename }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
