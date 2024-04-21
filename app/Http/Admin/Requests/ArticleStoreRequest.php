<?php

namespace App\Http\Admin\Requests;

use App\Http\Requests\FormRequest;
use Illuminate\Validation\Rule;

class ArticleStoreRequest extends FormRequest
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
            'text' => 'required|string',
            'template' => [
                Rule::in(['standard', 'tech'])
            ],
            'seo.*' => 'nullable|string',
        ];
    }
}
