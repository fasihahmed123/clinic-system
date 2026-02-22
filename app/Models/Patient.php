<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
   protected $fillable = [
        'pr_no',
        'patient_name',
        'cnic',
        'email',           
        'age',
        'gender',
        'doctor_name',
        'prescription',
        'notes',
        'mobile'
   ];
}