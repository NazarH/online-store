<?php

namespace App\Http\User\Requests;

use App\Http\Requests\FormRequest;

class ReviewStoreRequest extends FormRequest
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
            'email' => 'required|string',
            'text' => 'required|string|max:255'
        ];
    }
}
