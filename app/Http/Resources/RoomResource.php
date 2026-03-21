<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    // Ovo definise sta ce biti u JSON odgovoru
    // Nikad ne vraces sve kolone direktno - kontrolises sta frontend vidi
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'type'            => $this->type,
            'description'     => $this->description,
            'price_per_night' => (float) $this->price_per_night,
            'capacity'        => $this->capacity,
            'floor'           => $this->floor,
            'is_available'    => $this->is_available,
            'status'          => $this->is_available ? 'available' : 'occupied',
            'amenities'       => $this->amenities ?? [],
            'images'          => $this->images ?? [],
            'created_at'      => $this->created_at?->toDateTimeString(),
            'updated_at'      => $this->updated_at?->toDateTimeString(),
        ];
    }
}
