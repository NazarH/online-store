<?php

namespace App\Http\User\Requests;

use App\Http\Requests\FormRequest;
use Illuminate\Validation\Rule;

class ClientOrderUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
            ],
            'email' => [
                'required',
                'string',
            ],
            'phone' => [
                'required',
                'string'
            ],
            'number' => [
                'required',
                'numeric'
            ],
            'location' => [
                'required',
                'string'
            ],
            'type' => [
                Rule::in(['basket', 'order']),
            ],
            'status' => [
                Rule::in(['expected', 'paid']),
            ],
            'payment' => [
                Rule::in(['receiving', 'online']),
            ]
        ];
    }
}
