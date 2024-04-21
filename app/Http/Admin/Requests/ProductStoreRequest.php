<?php

namespace App\Http\Admin\Requests;

use App\Http\Requests\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'brand_id' => 'required|numeric',
            'properties' => 'required|array',
            'price' => 'required|numeric',
            'old_price' => 'required|numeric',
            'count' => 'required|numeric',
            'category_id' => 'required|numeric',
            'seo.*' => 'nullable|string',
        ];
    }
}
