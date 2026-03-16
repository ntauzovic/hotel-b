<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'guest_id'         => 'required|integer|exists:guests,id',
            'room_id'          => 'required|integer|exists:rooms,id',
            'check_in_date'    => 'required|date|after_or_equal:today',
            'check_out_date'   => 'required|date|after:check_in_date',
            'status'           => 'in:pending,confirmed,checked_in,checked_out,cancelled',
            'number_of_guests' => 'required|integer|min:1|max:20',
            'total_price'      => 'required|numeric|min:0',
            'notes'            => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'guest_id.required'       => 'Guest is required.',
            'guest_id.exists'         => 'Selected guest does not exist.',
            'room_id.required'        => 'Room is required.',
            'room_id.exists'          => 'Selected room does not exist.',
            'check_in_date.required'  => 'Check-in date is required.',
            'check_in_date.after_or_equal' => 'Check-in date cannot be in the past.',
            'check_out_date.required' => 'Check-out date is required.',
            'check_out_date.after'    => 'Check-out date must be after check-in date.',
            'total_price.required'    => 'Total price is required.',
            'number_of_guests.required' => 'Number of guests is required.',
            'number_of_guests.min'    => 'At least 1 guest is required.',
        ];
    }
}
