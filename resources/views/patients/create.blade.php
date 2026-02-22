@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Add Patient</h2>

    <form action="{{ route('patients.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Patient Name</label>
            <input type="text" name="patient_name" class="form-control" value="{{ old('patient_name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">CNIC</label>
            <input type="text" name="cnic" class="form-control" value="{{ old('cnic') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
        </div>

        <div class="mb-3">
        <label class="form-label">Mobile Number</label>
        <input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}" placeholder="+92300xxxxxxx" required>
    </div>

        <div class="mb-3">
            <label class="form-label">Age</label>
            <input type="number" name="age" class="form-control" value="{{ old('age') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Gender</label>
            <select name="gender" class="form-select" required>
                <option value="">Select Gender</option>
                <option value="Male" {{ old('gender')=='Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender')=='Female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Doctor</label>
            <select name="doctor_name" class="form-select" required>
                <option value="Dr. Ishaq Kahut" {{ old('doctor_name')=='Dr. Ishaq Kahut' ? 'selected' : '' }}>Dr. Ishaq Kahut</option>
                <option value="Dr. Naheed Naseem" {{ old('doctor_name')=='Dr. Naheed Naseem' ? 'selected' : '' }}>Dr. Naheed Naseem</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Prescription</label>
            <textarea name="prescription" class="form-control" rows="3">{{ old('prescription') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Notes</label>
            <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('patients.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary">Save Patient</button>
        </div>
    </form>
</div>
@endsection