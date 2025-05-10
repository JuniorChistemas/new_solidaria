<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'customer_id' => 'nullable|exists:customers,id',
            'local_id' => 'required|exists:locals,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'type_voucher_id' => 'required|exists:type_vouchers,id',
            'type_payment_id' => 'required|exists:type_payments,id',
            'code' => 'required|string|max:255|unique:sales,code',
            'code_card' => 'nullable|string|max:255|unique:sales,code_card',
            'op_gravada' => 'required|numeric|min:0',
            'op_exonerada' => 'nullable|numeric|min:0',
            'op_inafecta' => 'nullable|numeric|min:0',
            'igv' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'status_sale' => 'nullable|boolean',
            'state_sunat' => 'nullable|boolean',
        ];
    }
}
