<?php

namespace App\Http\Requests\Users;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

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
            ],
            'role' => [
                Rule::in(['admin', 'client'])
            ]
        ];
    }
}
