<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuestResource extends JsonResource
{
    // Ovo definise sta ce biti u JSON odgovoru
    // Nikad ne vraces sve kolone direktno - kontrolises sta frontend vidi
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'first_name'      => $this->first_name,
            'last_name'       => $this->last_name,
            'email'           => $this->email,
            'phone'           => $this->phone,
            'date_of_birth'   => $this->date_of_birth?->toDateString(),
            'nationality'     => $this->nationality,
            'passport_number' => $this->passport_number,
            'address'         => $this->address,
            'city'            => $this->city,
            'country'         => $this->country,
            'notes'           => $this->notes,
            'created_at'      => $this->created_at?->toDateTimeString(),
            'updated_at'      => $this->updated_at?->toDateTimeString(),
        ];
    }
}
