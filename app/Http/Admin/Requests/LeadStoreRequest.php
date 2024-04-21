<?php

namespace App\Http\Admin\Requests;

use App\Http\Requests\FormRequest;
use Illuminate\Validation\Rule;

class LeadStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => [
                'required',
                'string',
                Rule::in(['feedback', 'subscription', 'callback']),
            ],
            'user_id' => 'required|numeric',
        ];
    }
}
