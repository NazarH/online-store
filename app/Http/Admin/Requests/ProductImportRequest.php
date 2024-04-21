<?php

namespace App\Http\Admin\Requests;

use App\Http\Requests\FormRequest;

class ProductImportRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:xlsx,xls',
        ];
    }
}
