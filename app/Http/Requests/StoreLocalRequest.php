<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Aquí puedes agregar lógica para determinar si el usuario tiene permisos.
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
            'name'        => 'required|string|max:100',
            'address'     => 'required|string|max:255',
            'series'      => 'required|string|max:50',
            'series_note' => 'nullable|string',
            'status'      => 'required|string|in:activo,inactivo',
        ];
    }
}
