@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Patient Details</h2>
        <a href="{{ route('patients.index') }}" class="btn btn-secondary">Back to Patients</a>
    </div>

    <div class="card shadow-sm p-4">
        <div class="mb-3">
            <strong>Patient Name:</strong> {{ $patient->patient_name }}
        </div>
        <div class="mb-3">
            <strong>Email:</strong> {{ $patient->email }}
        </div>
        <div class="mb-3">
            <strong>CNIC:</strong> {{ $patient->cnic }}
        </div>
        <div class="mb-3">
            <strong>Age:</strong> {{ $patient->age }}
        </div>
        <div class="mb-3">
            <strong>Gender:</strong> {{ ucfirst($patient->gender) }}
        </div>
        <div class="mb-3">
            <strong>Doctor:</strong> {{ $patient->doctor_name }}
        </div>
        <div class="mb-3">
            <strong>Prescription:</strong>
            <p>{{ $patient->prescription }}</p>
        </div>
        <div class="mb-3">
            <strong>Notes:</strong>
            <p>{{ $patient->notes }}</p>
        </div>

        <div class="mt-4">
            <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-primary">Edit Patient</a>
            <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="d-inline delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete Patient</button>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert for delete confirmation -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to delete this patient?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endsection