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
            'short_text' => 'required|string|max:50',
            'text' => 'required|string',
            'template' => [
                Rule::in(['standard', 'tech'])
            ],
            'published_at' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'seo.*' => 'nullable|string',
        ];
    }
}
