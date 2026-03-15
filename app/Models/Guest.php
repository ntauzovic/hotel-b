<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guest extends Model
{
    use HasFactory, SoftDeletes;

    // Kolone koje se mogu masovno popunjavati
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'nationality',
        'passport_number',
        'address',
        'city',
        'country',
        'notes',
    ];

    // Automatsko kastovanje tipova
    protected $casts = [
        'date_of_birth' => 'date',
    ];
}
