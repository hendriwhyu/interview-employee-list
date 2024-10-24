@extends('layouts.dashboard')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <!-- Employee Overview Card -->
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Employees Overview</h5>
                            <p class="mb-4">
                                You currently have <span class="fw-bold">{{ $totalEmployees }}</span> employees, and there are <span class="fw-bold">{{ $totalDocuments }}</span> documents stored.
                            </p>
                            <a href="{{ route('employees.index') }}" class="btn btn-sm btn-outline-primary">Manage Employees</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img
                                src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}"
                                height="140"
                                alt="Employee Overview"
                                data-app-dark-img="illustrations/employees-overview-dark.png"
                                data-app-light-img="illustrations/employees-overview.png"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection
