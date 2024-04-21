<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\FormRequest;

class ShipmentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'location' => 'required|string',
            'number' => 'required|string',
        ];
    }
}
