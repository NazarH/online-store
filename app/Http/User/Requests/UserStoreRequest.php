<?php

namespace App\Http\User\Requests;

use App\Http\Requests\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = optional($this->route('user'))->id;
        $available = $id ? 'nullable' : 'required';

        return [
            'name' => 'required|string|max:30',
            'phone' => 'required|string|unique:users,phone|min:13',
            'role' => [ Rule::in(['admin', 'client']) ],
            'email' => [ 'required',  'string',  'email', Rule::unique('users')->ignore($id) ],
            'password' =>  [ $available, 'string',  'min:8', 'max:16', 'required_with:password_confirmation', 'same:password_confirmation' ]
        ];
    }
}
