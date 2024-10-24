@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">
        <span class="text-muted fw-light">Employees / </span>Employee Details
    </h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <!-- Display Photo -->
            <div class="text-center mb-4">
                @if(Str::startsWith($employee->photo, 'http'))
                    <img src="{{ $employee->photo }}" class="img-fluid rounded-circle shadow-sm" alt="Employee Photo" style="width: 150px; height: 150px; object-fit: cover;" />
                @else
                    <img src="{{ asset('storage/' . $employee->photo) }}" class="img-fluid rounded-circle shadow-sm" alt="Employee Photo" style="width: 150px; height: 150px; object-fit: cover;" />
                @endif

                <h5 class="mt-3 mb-1">{{ $employee->name }}</h5>
            </div>


            <div class="container pt-3">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="name"><strong>Full Name</strong></label>
                        <p class="form-control-plaintext" id="name">{{ $employee->name ?? '-' }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="email"><strong>Email</strong></label>
                        <p class="form-control-plaintext" id="email">{{ $employee->email ?? '-' }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="position"><strong>Position</strong></label>
                        <p class="form-control-plaintext" id="position">{{ $employee->position ?? '-' }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="entry-date"><strong>Entry Date</strong></label>
                        <p class="form-control-plaintext" id="entry-date">{{ $employee->entry_date ?? '-' }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="phone"><strong>Phone</strong></label>
                        <p class="form-control-plaintext" id="phone">{{ $employee->phone_number ?? '-' }}</p>
                    </div>
                </div>

                <!-- Display documents if exists -->
                @if($employee->documents && count($employee->documents) > 0)
                    <div class="mt-4">
                        <label class="form-label" for="documents"><strong>Appointment Documents</strong></label>
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
                @else
                    <p class="text-muted mt-3">No documents available.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
