<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\PatientRecordMail;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{
    // 🔹 Display list of patients with CNIC search and pagination
    public function index(Request $request)
{
    $query = Patient::query();

    if ($request->search) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('pr_no', 'like', "%{$search}%")
              ->orWhere('cnic', 'like', "%{$search}%");
        });
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
    try {
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'cnic' => 'required|string|unique:patients,cnic',
            'email' => 'nullable|email|max:255',
            'age' => 'required|integer|min:0',
            'gender' => 'required|in:Male,Female',
            'doctor_name' => 'required|string',
            'prescription' => 'nullable|string',
            'notes' => 'nullable|string',
            'mobile' => 'nullable|string|max:20',
        ]);

        do {
            $pr_no = mt_rand(100000, 999999);
        } while (Patient::where('pr_no', $pr_no)->exists());

        $patient = Patient::create(array_merge(
            $request->only([
                'patient_name',
                'cnic',
                'email',
                'age',
                'gender',
                'doctor_name',
                'prescription',
                'notes',
                'mobile'
            ]),
            ['pr_no' => $pr_no]
        ));

        if ($patient->email) {
            Mail::to($patient->email)->send(new PatientRecordMail($patient));
        }

        return redirect()->route('patients.index')
            ->with('success', 'Patient Added and Email Sent Successfully');

    } catch (\Exception $e) {
        // Directly show error in browser (for debug only)
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
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

    $messages = [
        'patient_name.required' => 'Patient Name is required.',
        'cnic.required'         => 'CNIC is required.',
        'cnic.unique'           => 'This CNIC is already registered.',
        'email.email'           => 'Please enter a valid email address.',
        'age.required'          => 'Age is required.',
        'age.integer'           => 'Age must be a number.',
        'age.min'               => 'Age cannot be negative.',
        'gender.required'       => 'Please select a gender.',
        'gender.in'             => 'Gender must be Male or Female.',
        'doctor_name.required'  => 'Doctor selection is required.',
        'mobile.max'            => 'Mobile number cannot exceed 20 characters.',
    ];

    $request->validate([
        'patient_name' => 'required|string|max:255',
        'cnic'         => 'required|string|unique:patients,cnic,' . $id,
        'email'        => 'nullable|email|max:255',
        'age'          => 'required|integer|min:0',
        'gender'       => 'required|in:Male,Female',
        'doctor_name'  => 'required|string',
        'prescription' => 'nullable|string',
        'notes'        => 'nullable|string',
        'mobile'       => 'nullable|string|max:20',
    ], $messages);

    $patient->update($request->only([
        'patient_name',
        'cnic',
        'email',
        'age',
        'gender',
        'doctor_name',
        'prescription',
        'notes',
        'mobile'
    ]));

    // ✅ Send Email Automatically on Update
    if ($patient->email) {
        Mail::to($patient->email)->send(new PatientRecordMail($patient));
    }

    return redirect()->route('patients.index')
        ->with('success', 'Patient Updated and Email Sent Successfully');
}

    // 🔹 Delete patient
    public function destroy($id)
    {
        Patient::findOrFail($id)->delete();

        return redirect()->route('patients.index')->with('success', 'Patient Deleted Successfully');
    }

    // 🔹 Show single patient details
    public function show($id)
    {
        $patient = Patient::findOrFail($id);
        return view('patients.show', compact('patient'));
    }

    public function export()
{
    $patients = Patient::all();

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="Patient Records.csv"',
    ];

    $columns = [
        'pr_no', 'patient_name', 'email', 'cnic', 'mobile', 'doctor_name', 'prescription', 'notes', 'age', 'gender'
    ];

    $callback = function() use ($patients, $columns) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);

        foreach ($patients as $patient) {
            $row = [];
            foreach ($columns as $col) {
                $row[] = $patient->$col;
            }
            fputcsv($file, $row);
        }

        fclose($file);
    };

    return Response::stream($callback, 200, $headers);
}

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:csv,txt',
    ]);

    $file = $request->file('file');
    $path = $file->getRealPath();
    $data = array_map('str_getcsv', file($path));

    $header = array_map('trim', $data[0]); // First row as header
    unset($data[0]);

    foreach ($data as $row) {
        $rowData = array_combine($header, $row);

        // Update if pr_no exists, else create new
        \App\Models\Patient::updateOrCreate(
            ['pr_no' => $rowData['pr_no']],
            $rowData
        );
    }

    return redirect()->route('patients.index')->with('success', 'CSV Imported Successfully');
}
}