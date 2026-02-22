<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Patient Medical Record</title>
</head>
<body style="font-family: Arial, sans-serif; background-color:#f4f4f4; padding:20px;">

<div style="max-width:600px; margin:auto; background:white; padding:30px; border-radius:8px;">

    <h2 style="color:#2c3e50;">Kahut Clinic</h2>
    <hr>

    <p>Dear <strong>{{ $patient->patient_name }}</strong>,</p>

    <p>
        We hope you are doing well. Please find below your medical record details
        registered at <strong>Kahut Clinic</strong>.
    </p>

    <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse;">
        <tr><td><strong>PR Number:</strong></td><td>{{ $patient->pr_no }}</td></tr>
        <tr><td><strong>CNIC:</strong></td><td>{{ $patient->cnic }}</td></tr>
        <tr><td><strong>Mobile:</strong></td><td>{{ $patient->mobile }}</td></tr>
        <tr><td><strong>Age:</strong></td><td>{{ $patient->age }}</td></tr>
        <tr><td><strong>Gender:</strong></td><td>{{ $patient->gender }}</td></tr>
        <tr><td><strong>Doctor:</strong></td><td>{{ $patient->doctor_name }}</td></tr>
        <tr><td><strong>Prescription:</strong></td><td>{{ $patient->prescription ?? 'N/A' }}</td></tr>
        <tr><td><strong>Notes:</strong></td><td>{{ $patient->notes ?? 'N/A' }}</td></tr>
    </table>

    <br>

    <p>
        If you have any questions regarding your medical record,
        please feel free to contact us.
    </p>

    <p style="margin-top:30px;">
        Best Regards,<br>
        <strong>Kahut Clinic Team</strong><br>
        Email: kahutclinic@gmail.com
    </p>

</div>

</body>
</html>