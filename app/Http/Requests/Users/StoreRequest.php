<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
        $available = $id ? 'nullable' : 'required';

        return [
            'name' => 'required|string|max:30',
            'phone' => 'required|string',
            'role' => [ Rule::in(['admin', 'client']) ],
            'email' => [ 'required',  'string',  'email', Rule::unique('users')->ignore($id) ],
            'password' =>  [ $available, 'string',  'min:8', 'max:16', 'required_with:password_confirmation', 'same:password_confirmation' ]
        ];
    }
}
