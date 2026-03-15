<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // 'sometimes' znaci - validiraj SAMO ako je polje poslano
        // Ovo omogucava PATCH (parcijalni update)
        return [
            'name'            => 'sometimes|required|string|max:255|unique:rooms,name,' . $this->room->id,
            'type'            => 'sometimes|required|in:single,double,suite,apartment',
            'description'     => 'nullable|string',
            'price_per_night' => 'sometimes|required|numeric|min:0',
            'capacity'        => 'sometimes|required|integer|min:1|max:20',
            'floor'           => 'nullable|integer|min:0',
            'is_available'    => 'boolean',
            'amenities'       => 'nullable|array',
            'amenities.*'     => 'string',
        ];
    }
}
