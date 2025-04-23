<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * You can add auth logic here if needed.
     */
    public function authorize(): bool
    {
        return true; // Set to false if you want to restrict access
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'event_id' => 'required|exists:events,id',
            'attendee_id' => 'required|exists:attendees,id',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'message' => 'Validation failed'
        ], 422));
    }

    /**
     * Custom error messages (optional)
     */
    public function messages(): array
    {
        return [
            'event_id.required' => 'Event is required.',
            'event_id.exists' => 'The selected event does not exist.',
            'attendee_id.required' => 'Attendee is required.',
            'attendee_id.exists' => 'The selected attendee does not exist.',
        ];
    }
}
