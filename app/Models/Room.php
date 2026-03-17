<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    // Kolone koje se mogu masovno popunjavati
    protected $fillable = [
        'name',
        'type',
        'description',
        'price_per_night',
        'capacity',
        'floor',
        'is_available',
        'amenities',
        'images',
    ];

    // Automatsko kastovanje tipova
    protected $casts = [
        'price_per_night' => 'decimal:2',
        'is_available'    => 'boolean',
        'amenities'       => 'array',
        'images'          => 'array',
    ];
}
