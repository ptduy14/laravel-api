<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateProductDetailRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'product_detail_intro' => 'required|string',
            'product_detail_desc' => 'required|string',
            'product_detail_weight' => 'required|integer',
            'product_detail_mfg' => 'required|string',
            'product_detail_exp' => 'required|integer',
            'product_detail_origin' => 'required|string',
            'product_detail_manual' => 'required|string',
            'product_id' => 'required|integer'
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
