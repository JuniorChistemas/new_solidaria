<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGuideRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'origin_local_id' => 'required|exists:locals,id',
            'destination_local_id' => 'required|exists:locals,id',
            'type_movement_id' => 'required|exists:type_movements,id',
            'code' => 'required|string|max:150',
            'status' => 'required|in:pending,completed,in_progress',
            'sent_at' => 'required|date',
        ];
    }
}
