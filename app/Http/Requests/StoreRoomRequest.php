<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
{
    // Ko smije da kreira sobu (za sad svi, kasnije dodamo auth)
    public function authorize(): bool
    {
        return true;
    }

    // Validacijska pravila
    public function rules(): array
    {
        return [
            'name'            => 'required|string|max:255|unique:rooms,name',
            'type'            => 'required|in:single,double,suite,apartment',
            'description'     => 'nullable|string',
            'price_per_night' => 'required|numeric|min:0',
            'capacity'        => 'required|integer|min:1|max:20',
            'floor'           => 'nullable|integer|min:0',
            'is_available'    => 'boolean',
            'amenities'       => 'nullable|array',
            'amenities.*'     => 'string',
        ];
    }

    // Poruke gresaka na engleskom (mozes i na bs/hr/sr)
    public function messages(): array
    {
        return [
            'name.required'            => 'Room name is required.',
            'name.unique'              => 'A room with this name already exists.',
            'type.required'            => 'Room type is required.',
            'type.in'                  => 'Room type must be: single, double, suite or apartment.',
            'price_per_night.required' => 'Price per night is required.',
            'price_per_night.min'      => 'Price cannot be negative.',
            'capacity.required'        => 'Capacity is required.',
            'capacity.min'             => 'Capacity must be at least 1.',
        ];
    }
}
