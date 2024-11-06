<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user' => [
                'required',
                'min:8',
                'regex:/^(0[7-9]|1[0-9]|2[0-' . date('y') . '])-\d{5}$/',
                'exists:users,user_name',
            ],
            'pass' => [
                'required',
                'min:8',
                'max:20',
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'user.required' => 'Please enter a username!',
            'user.min' => 'It must be at least :min characters.',
            'user.regex' => 'The username is invalid.',
            'user.exists' => 'This username does not exist.',

            'pass.required' => 'Please enter a password!',
            'pass.min' => 'It must be at least :min characters.',
            'pass.max' => 'It must not exceed :max characters.',
        ];
    }

    /**
     * Prepare/sanitize the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'user' => $this->input('user'),
            'pass' => $this->input('pass'),
        ]);
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ])
        );
    }
}
