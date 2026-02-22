@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Patient Records</h2>
        <a href="{{ route('patients.create') }}" class="btn btn-primary btn-lg">+ Add Patient</a>
    </div>

    <!-- Search Bar -->
    <form method="GET" action="{{ route('patients.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by PR-No or CNIC..." value="{{ request('search') }}">
            <button class="btn btn-outline-primary" type="submit">Search</button>
            <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    <!-- Patient Table -->
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>PR-No</th>
                        <th>Patient Name</th>
                        <th>E-mail</th>
                        <th>CNIC</th>
                        <th>Mobile</th>
                        <th>Doctor</th>
                        <th>Prescription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($patients as $patient)
                    <tr>
                        <td>{{ $patient->pr_no }}</td>
                        <td>
                            <a href="{{ route('patients.show', $patient->id) }}" class="text-decoration-none text-primary">
                                {{ $patient->patient_name }}
                            </a>
                        </td>
                        <td>{{ $patient->email }}</td>
                        <td>{{ $patient->cnic }}</td>
                        <td>{{ $patient->mobile }}</td>
                        <td>{{ $patient->doctor_name }}</td>
                        <td>{{ Str::limit($patient->prescription, 30) }}</td>
                        <td>
                            <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" style="display:inline;" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">No patients found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-3">
            {{ $patients->withQueryString()->links() }}
        </div>
    </div>

</div>

<!-- SweetAlert Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Delete confirmation
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

    // Success popups (Laravel session flash)
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false
        });
    @endif
});
</script>
@endsection