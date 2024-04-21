<?php

namespace App\Http\Admin\Requests;

use App\Http\Requests\FormRequest;

class NotificationStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'required|string',
            'topic' => 'required|string',
            'text' => 'required|string',
            'notification_date' => 'required|string'
        ];
    }
}
