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
            'codigo' => 'required|string|max:15',
            'fechaEmision' => 'required|date',
            'fechaCredito' => 'nullable|date',
            'idProveedor' => 'required|exists:suppliers,id',
            'idUser' => 'required|exists:users,id',
            'idTipoMovimiento' => 'required|integer',
            'estado' => 'required|integer',
            'estadoIgv' => 'required|integer',
            'tipoPago' => 'required|in:contado,credito',
        ];
    }

    // Agrega este método para asegurarte de que tipoPago sea tratado como string
    protected function prepareForValidation()
    {
        $this->merge([
            'tipoPago' => (string) $this->tipoPago,
        ]);
    }
}
