<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo' => 'required|string|max:15',
            'fechaEmision' => 'required|date',
            'fechaEjecucion' => 'required|date',
            'fechaCredito' => 'nullable|date',
            'idProveedor' => 'required|integer|exists:suppliers,id',
            'idLocal' => 'required|integer|exists:locals,id',
            'idUser' => 'required|integer|exists:users,id',
            'idTipoMovimiento' => 'required|integer|in:1,2,3,4',
            'estado' => 'required|integer|in:0,1,2',
            'estadoIgv' => 'required|integer|in:1,2',
            'estadoIngreso' => 'required|integer|in:0,1',
            'tipoPago' => 'required|in:Contado',
        ];
    }
}
