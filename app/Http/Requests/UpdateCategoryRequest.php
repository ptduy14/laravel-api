<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCategoryRequest extends FormRequest
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
            'category_name' => 'required | unique:tbl_categories,category_name,' . $this->id . ',category_id',
            'category_desc' => 'required',
            'category_status' => 'required | boolean'
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
