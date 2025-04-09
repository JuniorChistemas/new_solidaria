<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLocalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Aquí puedes agregar la lógica para verificar los permisos del usuario
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
