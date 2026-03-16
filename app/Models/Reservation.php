<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'guest_id',
        'room_id',
        'check_in_date',
        'check_out_date',
        'status',
        'number_of_guests',
        'total_price',
        'notes',
    ];

    protected $casts = [
        'check_in_date'  => 'date',
        'check_out_date' => 'date',
        'total_price'    => 'decimal:2',
    ];

    // Rezervacija pripada jednom gostu
    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    // Rezervacija pripada jednoj sobi
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
