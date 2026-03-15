<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGuestRequest extends FormRequest
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
            'first_name'      => 'sometimes|required|string|max:100',
            'last_name'       => 'sometimes|required|string|max:100',
            'email'           => 'sometimes|required|email|max:255|unique:guests,email,' . $this->guest->id,
            'phone'           => 'nullable|string|max:30',
            'date_of_birth'   => 'nullable|date|before:today',
            'nationality'     => 'nullable|string|max:100',
            'passport_number' => 'nullable|string|max:50|unique:guests,passport_number,' . $this->guest->id,
            'address'         => 'nullable|string',
            'city'            => 'nullable|string|max:100',
            'country'         => 'nullable|string|max:100',
            'notes'           => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required'    => 'First name is required.',
            'last_name.required'     => 'Last name is required.',
            'email.required'         => 'Email is required.',
            'email.email'            => 'Email must be a valid email address.',
            'email.unique'           => 'A guest with this email already exists.',
            'date_of_birth.before'   => 'Date of birth must be in the past.',
            'passport_number.unique' => 'A guest with this passport number already exists.',
        ];
    }
}
