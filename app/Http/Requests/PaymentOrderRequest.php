<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class PaymentOrderRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'reciver' => 'required|string',
            'phone' => 'required|numeric|digits:10',
            'address' => 'required|string',
            'method_payment' => 'required|string',
        ];
    }

    public function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json(
            [
                'status' => false,
                'error' => $validator->errors()
            ], 422));
    }
}
