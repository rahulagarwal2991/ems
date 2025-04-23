<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'date' => 'sometimes|required|date',
            'country' => 'sometimes|required|string',
            'capacity' => 'sometimes|required|integer|min:1',
        ];
    }
}
