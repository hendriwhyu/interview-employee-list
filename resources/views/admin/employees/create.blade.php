@extends('layouts.dashboard')
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <style>
        .toast-top-end {
        position: fixed;
        top: 1rem;
        right: 1rem;
        z-index: 1050;
        }

        /* Kustomisasi Dropzone */
        .dropzone {
            background-color: #f8f9fa; /* Warna latar belakang Dropzone */
            border: 2px dashed #ced4da; /* Warna border Dropzone */
            color: #495057; /* Warna teks Dropzone */
            padding: 20px; /* Padding untuk Dropzone */
            border-radius: 5px; /* Border radius Dropzone */
        }

        .dropzone.dz-drag-hover {
            background-color: #e2e6ea; /* Warna latar belakang saat drag hover */
        }
    </style>
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">
        <span class="text-muted fw-light">Employees / </span>Create Employee
    </h4>

    <div
        id="sneat-toast"
        class="bs-toast toast toast-placement-ex toast-top-end m-2"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
        data-delay="3000"
        style="display: none;"
    >
        <div class="toast-header">
            <i class="bx bx-bell me-2" id="toast-icon"></i>
            <div class="me-auto fw-semibold" id="toast-title">Notification</div>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toast-message">This is a notification message.</div>
    </div>


    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Form Employee</h5>
        </div>
        <div class="card-body">
            <form id="employee-form" action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Form Fields -->
                <div class="mb-3">
                    <label class="form-label" for="basic-icon-default-fullname">Full Name</label>
                    <input type="text" name="name" class="form-control" id="basic-icon-default-fullname" placeholder="John Doe" required />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-icon-default-email">Email</label>
                    <input type="email" name="email" class="form-control" id="basic-icon-default-email" placeholder="john.doe@example.com" required />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="position">Position</label>
                    <select name="position" class="form-control select2" id="position" required>
                        <option value="">Select Position</option>
                        <option value="Web Developer">Web Developer</option>
                        <option value="Software Engineer">Software Engineer</option>
                        <option value="Data Analyst">Data Analyst</option>
                        <option value="System Administrator">System Administrator</option>
                        <option value="DevOps Engineer">DevOps Engineer</option>
                        <option value="Project Manager">Project Manager</option>
                        <option value="UI/UX Designer">UI/UX Designer</option>
                        <option value="Mobile App Developer">Mobile App Developer</option>
                        <option value="IT Support Specialist">IT Support Specialist</option>
                        <option value="Database Administrator">Database Administrator</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="entry-date">Entry Date</label>
                    <input type="date" name="entry_date" class="form-control" id="entry-date" required />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="basic-icon-default-phone">Phone</label>
                    <input type="text" name="phone_number" class="form-control" id="basic-icon-default-phone" placeholder="08X XXX XXXX" required />
                </div>

                <!-- Dropzone Upload Section -->
                <div class="mb-3">
                    <label class="form-label" for="photo">Upload Photo</label>
                    <div class="dropzone" id="photo-dropzone"></div>
                </div>

                <!-- File Upload Section -->
                <div class="mb-3">
                    <label class="form-label" for="photo">Appointment Document</label>
                    <input id="appointmentDocument" name="documents[]" type="file" class="file" multiple data-show-upload="true" data-show-caption="true">
                </div>

                <button type="submit" class="btn btn-primary">Send</button>
            </form>
        </div>
      </div>
</div>

<!-- Notifikasi Bootstrap -->
<div id="notification" class="position-fixed top-0 end-0 p-3" style="z-index: 11">

</div>

<script>
    Dropzone.autoDiscover = false;

    let today = new Date().toISOString().split('T')[0];
    // Setel atribut max pada input date agar maksimal hari ini
    $('#entry-date').attr('max', today);

    const maxFiles = 1; // Batas maksimum file yang dapat diupload

    // Inisialisasi Select2 untuk posisi
    $('#position').select2({
        theme: 'bootstrap-5', // Gunakan tema Bootstrap 5
        placeholder: "Select Position",
        allowClear: true, // Mengizinkan opsi untuk membersihkan pilihan
    });

    const photoDropzone = new Dropzone("#photo-dropzone", {
        url: "{{ route('employees.upload') }}", // URL untuk upload foto
        maxFiles: maxFiles,
        acceptedFiles: "image/*",
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        init: function() {
            const myDropzone = this;

            // Mengirim form ketika tombol submit ditekan
            $("#employee-form").on("submit", function(e) {
                e.preventDefault(); // Mencegah pengiriman form default

                // Validasi jumlah file yang diupload
                if (myDropzone.files.length > maxFiles) {
                    showSneatToast({ photo: [`You can only upload up to ${maxFiles} files.`] }, 'warning');
                    return;
                }

                const formData = new FormData(this);
                myDropzone.files.forEach(file => {
                    formData.append("photo", file); // Menambahkan file ke formData
                });

                // Kirim form data ke route employees.store
                $.ajax({
                    url: $(this).attr('action'),
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        myDropzone.removeAllFiles();
                        $("#employee-form")[0].reset();
                        // Menampilkan notifikasi sukses
                        showSneatToast('Employee created successfully!', 'success');
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText); // Log error
                        const errors = xhr.responseJSON.errors; // Ambil error dari response
                        showSneatToast(errors, 'danger'); // Tampilkan notifikasi error
                    }
                });
            });
        }
    });

    $("#appointmentDocument").fileinput('destroy').fileinput({
        allowedFileExtensions: ['jpg', 'png', 'gif', 'pdf', 'doc', 'docx'],
        maxFileCount: 10,
        maxFileSize: 2048,
        showUpload: false,
        browseClass: "btn btn-primary",
        dropZoneEnabled: true,
    });


    function showSneatToast(message, type) {
        const toast = new bootstrap.Toast(document.getElementById('sneat-toast'));
        const toastElement = $('#sneat-toast');
        const toastTitle = $('#toast-title');
        const toastMessage = $('#toast-message');
        const toastIcon = $('#toast-icon');

        // Atur pesan dan tipe notifikasi
        toastTitle.text(type.charAt(0).toUpperCase() + type.slice(1));

        // Periksa apakah message adalah objek Laravel
        if (typeof message === 'object') {
            const listItems = Object.values(message).flat().map(item => `<li>${item}</li>`).join('');
            toastMessage.html(`<ul>${listItems}</ul>`);
        } else {
            toastMessage.text(message);
        }

        // Bersihkan dan tambahkan kelas sesuai tipe
        toastElement.removeClass('bg-success bg-danger bg-info bg-warning');
        toastIcon.removeClass('bx-check-circle bx-x-circle bx-info-circle bx-error');

        switch(type) {
            case 'success':
                toastElement.addClass('bg-success');
                toastIcon.addClass('bx-check-circle');
                break;
            case 'danger':
                toastElement.addClass('bg-danger');
                toastIcon.addClass('bx-x-circle');
                break;
            case 'info':
                toastElement.addClass('bg-info');
                toastIcon.addClass('bx-info-circle');
                break;
            case 'warning':
                toastElement.addClass('bg-warning');
                toastIcon.addClass('bx-error');
                break;
            default:
                toastElement.addClass('bg-secondary');
                toastIcon.addClass('bx-bell');
        }

        // Tampilkan toast
        toastElement.show();
        toast.show();
    }



</script>
@endsection


