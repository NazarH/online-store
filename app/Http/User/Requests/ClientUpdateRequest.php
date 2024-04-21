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

        return [
            'email' => [ 'required',  'string',  'email', Rule::unique('users')->ignore($id) ],
            'phone' => 'required|string',
            'address' => 'nullable|string'
        ];
    }
}
