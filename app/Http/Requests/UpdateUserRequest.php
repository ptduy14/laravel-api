<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required',
            'phone' => 'required|numeric|digits:10',
            'address' => 'required',
            'gender' => 'required|boolean',
            // 'role' => 'required|boolean',
            // 'verify' => 'required|boolean',
            // 'password' => 'required | confirmed'
        ];
    }

    public function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json(
            [
                'status' => 422,
                'message' => 'Validation errors in your request',
                'errors' => $validator->errors()
            ], 422));
    }
}
