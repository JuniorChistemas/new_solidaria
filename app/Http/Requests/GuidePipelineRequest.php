<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuidePipelineRequest extends FormRequest
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
            'code' => 'required|string|max:150|unique:guides,code',
            'status' => 'required|in:pending,completed,in_progress',
            'sent_at' => 'required|date',
            'products' => 'required|array|min:1',
            'products.*.product_local_id' => 'required|exists:products,id',
            'products.*.quantity_box' => 'required|integer|min:0',
            'products.*.quantity_fraction' => 'required|integer|min:0',
        ];
    }
}
