<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

   // En tu StoreMovementRequest.php
    public function rules()
    {
        return [
            'code' => 'required|string|max:15',
            'issue_date' => 'required|date',
            'credit_date' => 'nullable|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'user_id' => 'required|exists:users,id',
            'type_movement_id' => 'required|integer',
            'status' => 'required|integer',
            'igv_status' => 'required|integer',
            'payment_type' => 'required|in:contado,credito',
        ];
    }

    // Agrega este método para asegurarte de que tipoPago sea tratado como string
    protected function prepareForValidation()
    {
        $this->merge([
            'payment_type' => (string) $this->payment_type,
        ]);
    }
}
