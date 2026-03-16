<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'guest_id'         => 'sometimes|required|integer|exists:guests,id',
            'room_id'          => 'sometimes|required|integer|exists:rooms,id',
            'check_in_date'    => 'sometimes|required|date',
            'check_out_date'   => 'sometimes|required|date|after:check_in_date',
            'status'           => 'sometimes|in:pending,confirmed,checked_in,checked_out,cancelled',
            'number_of_guests' => 'sometimes|required|integer|min:1|max:20',
            'total_price'      => 'sometimes|required|numeric|min:0',
            'notes'            => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'guest_id.exists'       => 'Selected guest does not exist.',
            'room_id.exists'        => 'Selected room does not exist.',
            'check_out_date.after'  => 'Check-out date must be after check-in date.',
            'status.in'             => 'Status must be: pending, confirmed, checked_in, checked_out or cancelled.',
        ];
    }
}
