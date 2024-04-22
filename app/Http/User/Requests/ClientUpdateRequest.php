<?php

namespace App\Http\User\Requests;

use App\Http\Requests\FormRequest;
use Illuminate\Validation\Rule;

class ClientUpdateRequest extends FormRequest
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
            'email' => [ 'required',  'string',  'email', Rule::unique('users')->ignore($id) ],
            'phone' => ['required', 'string', 'min:13', 'max:13', Rule::unique('users')->ignore($id)],
            'address' => 'nullable|string',
            'password' =>  [ $available, 'string',  'min:8', 'max:16', 'required_with:password_confirmation', 'same:password_confirmation' ]
        ];
    }
}
