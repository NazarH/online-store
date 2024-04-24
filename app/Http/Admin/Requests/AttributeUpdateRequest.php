<?php

namespace App\Http\Admin\Requests;

use App\Http\Requests\FormRequest;

class AttributeUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:30',
            'category_ids' => 'required|array',
            'value_ids' => 'nullable|array'
        ];
    }
}
