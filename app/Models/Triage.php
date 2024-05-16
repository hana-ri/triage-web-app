<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Triage extends Model
{
    protected $guarded = [
        'id',
    ];
    // protected $fillable = [
    //    'patient_number_per_hour', 'name', 'age', 'gender', 'sbp', 'dbp', 'hr', 'rr', 'bt', 'saturation', 'arrival_mode','mental', 'injury',
    // ];
}
