@extends('layouts.dashboard')

@section('content')
<!-- Add DataTables and Bootstrap 5 -->

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex mb-4 align-items-center">
        <h4 class="fw-bold">
            <span class="text-muted fw-light">Employees / </span>List Employee
        </h4>
        <button type="button" class="btn btn-outline-primary ms-auto" onclick="window.location='{{ route('employees.create') }}'">
            <span class="tf-icons bx bx-plus"></span>&nbsp; Create
        </button>
    </div>
    <!-- Notification for Success -->
    <div id="notification-alert" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
        <strong id="notification-message"></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <!-- Notification for Errors -->
    <div id="notification-error" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
        <strong>Error!</strong>
        <ol id="error-list" class="mb-0"></ol>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <!-- Table card -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0 text-white">Employees Table</h5>
        </div>
        <div class="table-responsive text-nowrap p-3">
            <table class="table table-striped table-bordered align-middle" id="employeeTable">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Position</th>
                        <th>Phone</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be populated using jQuery -->
                </tbody>
            </table>
        </div>
    </div>
    <!-- /Table card -->
</div>
<!-- / Content -->

<!-- Modal for Delete Confirmation -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this employee?
            </div>
            <div class="modal-footer">
                <form id="delete-form" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Fetch employee data from API
        $.ajax({
            url: '/api/employees', // Ensure this is the correct API URL
            method: 'GET',
            success: function(response) {
                const data = response.data;
                if (data.length > 0 && response.status === 'success') {
                    showNotification(response.message, 'success'); // Show success notification
                    // Iterate over each employee and add them to the table
                    $.each(data, function(index, employee) {
                        $('#employeeTable tbody').append(`
                            <tr>
                                <td class="text-center">${index + 1}</td>
                                <td><strong>${employee.name}</strong></td>
                                <td>${employee.email}</td>
                                <td>${employee.position}</td>
                                <td>${employee.phone_number}</td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm btn-light p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ url('admin/employees') }}/${employee.id}">
                                                    <i class="bx bx-user-pin me-1"></i> Views
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item delete-button" href="#" data-id="${employee.id}" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                    <i class="bx bx-trash me-1"></i> Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    $('#employeeTable tbody').append('<tr><td colspan="6" class="text-center">No Data Found...</td></tr>');
                }

                // Initialize DataTable after populating data
                $('#employeeTable').DataTable({
                    "paging": true,
                    "searching": true,
                    "info": true,
                    "ordering": true,
                    "columnDefs": [
                        { "orderable": false, "targets": 5 } // Disable ordering on the "Actions" column
                    ]
                });
            },
            error: function(xhr) {
                console.error('Error fetching data:', xhr);
                $('#employeeTable tbody').append('<tr><td colspan="6" class="text-center">Failed to load data...</td></tr>');
                showNotification(xhr.responseJSON.message, 'danger'); // Show error notification
            }
        });

        // Set delete action URL when delete button is clicked
        $(document).on('click', '.delete-button', function() {
            var employeeId = $(this).data('id'); // Get employee ID
            var actionUrl = "{{ route('employees.destroy', '') }}"; // Base URL
            $('#delete-form').attr('action', actionUrl + '/' + employeeId); // Set action URL
        });
    });

    // Function to show notification
    function showNotification(message, type) {
        const alertBox = $('#notification-alert');
        const messageText = $('#notification-message');

        messageText.text(message);
        alertBox.removeClass('alert-success alert-danger').addClass(`alert-${type}`);
        alertBox.show();

        // Auto-hide notification after 3 seconds
        setTimeout(() => {
            alertBox.fadeOut();
        }, 3000);
    }
</script>
@endsection
