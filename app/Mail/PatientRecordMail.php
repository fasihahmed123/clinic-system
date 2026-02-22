<?php

namespace App\Mail;

use App\Models\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PatientRecordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $patient;

    public function __construct(Patient $patient)
    {
        $this->patient = $patient;
    }

    public function build()
    {
        return $this->subject('Your Medical Record - Kahut Clinic')
                    ->view('emails.patient_record');
    }
}