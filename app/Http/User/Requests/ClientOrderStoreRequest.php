<?php

namespace App\Http\User\Requests;

use App\Http\Requests\FormRequest;
use Illuminate\Validation\Rule;

class ClientOrderStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'location' => 'required|string',
            'number' => 'required|numeric',
            'payment' => [
                'required',
                Rule::in(['receiving', 'online']),
            ]
        ];
    }
}
