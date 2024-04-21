<?php

namespace App\Http\User\Requests;

use App\Http\Requests\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = optional($this->route('user'))->id;

        return [
            'name' => [
                'nullable',
                'string',
                'max:30',
            ],
            'email' => [
                'nullable',
                'string',
                'email',
                Rule::unique('users')->ignore($id)
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'max:16',
                'required_with:password_confirmation',
                'same:password_confirmation'
            ],
            'phone' => [
                'nullable',
                'string',
                'unique:users,phone',
            ],
            'role' => [
                Rule::in(['admin', 'client'])
            ]
        ];
    }
}
