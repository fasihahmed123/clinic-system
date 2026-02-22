<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    // 🔹 Display list of patients with CNIC search and pagination
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->search) {
            $query->where('cnic', 'like', '%' . $request->search . '%');
        }

        $patients = $query->latest()->paginate(10)->withQueryString();

        return view('patients.index', compact('patients'));
    }

    // 🔹 Show create form
    public function create()
    {
        return view('patients.create');
    }

    // 🔹 Store new patient
    public function store(Request $request)
    {
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'cnic' => 'required|string|unique:patients,cnic',
            'email' => 'nullable|email|max:255',
            'age' => 'required|integer|min:0',
            'gender' => 'required|in:Male,Female',
            'doctor_name' => 'required|string',
            'prescription' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Patient::create($request->only([
            'patient_name',
            'cnic',
            'email',
            'age',
            'gender',
            'doctor_name',
            'prescription',
            'notes'
        ]));

        return redirect()->route('patients.index')->with('success', 'Patient Added Successfully');
    }

    // 🔹 Show edit form
    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        return view('patients.edit', compact('patient'));
    }

    // 🔹 Update patient
    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $request->validate([
            'patient_name' => 'required|string|max:255',
            'cnic' => 'required|string|unique:patients,cnic,' . $id,
            'email' => 'nullable|email|max:255',
            'age' => 'required|integer|min:0',
            'gender' => 'required|in:Male,Female',
            'doctor_name' => 'required|string',
            'prescription' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $patient->update($request->only([
            'patient_name',
            'cnic',
            'email',
            'age',
            'gender',
            'doctor_name',
            'prescription',
            'notes'
        ]));

        return redirect()->route('patients.index')->with('success', 'Patient Updated Successfully');
    }

    // 🔹 Delete patient
    public function destroy($id)
    {
        Patient::findOrFail($id)->delete();

        return redirect()->route('patients.index')->with('success', 'Patient Deleted Successfully');
    }
}