<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'composition' => 'required|string|max:255',
            'presentation' => 'required|string|max:100',
            'form_farm' => 'required|string|max:100',
            'barcode' => 'required|string|size:8|unique:products,barcode,'. $this->product->id,     
            'laboratory_id' => 'required|exists:laboratories,id',
            'category_id' => 'required|exists:categories,id',
            'state_fraction' => 'required|boolean',
            'fraction' => 'required|integer',
            'state_igv' => 'required|boolean',
            'state' => 'required|boolean',
        ];
    }
}
