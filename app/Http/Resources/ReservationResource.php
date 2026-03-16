<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'guest'            => [
                'id'         => $this->guest->id,
                'first_name' => $this->guest->first_name,
                'last_name'  => $this->guest->last_name,
                'email'      => $this->guest->email,
            ],
            'room'             => [
                'id'   => $this->room->id,
                'name' => $this->room->name,
                'type' => $this->room->type,
            ],
            'check_in_date'    => $this->check_in_date?->toDateString(),
            'check_out_date'   => $this->check_out_date?->toDateString(),
            'status'           => $this->status,
            'number_of_guests' => $this->number_of_guests,
            'total_price'      => (float) $this->total_price,
            'notes'            => $this->notes,
            'created_at'       => $this->created_at?->toDateTimeString(),
            'updated_at'       => $this->updated_at?->toDateTimeString(),
        ];
    }
}
