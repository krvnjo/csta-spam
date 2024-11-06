<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PasswordRequest extends FormRequest
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
            'email' => [
                'required',
                'min:8',
                'max:50',
                'email',
                'exists:users,email',
            ],
            'pass' => [
                'required',
                'min:8',
                'max:20',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[\W_]/',
            ],
            'confirm' => [
                'required',
                'same:pass',
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

            'email.required' => 'Please enter an email address!',
            'email.min' => 'It must be at least :min characters.',
            'email.max' => 'It must not exceed :max characters.',
            'email.email' => 'Please enter a valid email address!',
            'email.exists' => 'This email does not exist.',

            'pass.required' => 'Please enter your new password!',
            'pass.min' => 'It must be at least :min characters',
            'pass.max' => 'It must not exceed :max characters.',
            'pass.regex' => 'Your new password must contain at least one uppercase letter, one lowercase letter, one number, and one special character!',

            'confirm.required' => 'Please confirm your new password!',
            'confirm.same' => 'The password confirmation does not match the new password!',
        ];
    }

    /**
     * Prepare/sanitize the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'user' => $this->input('user'),
            'email' => $this->input('email'),
            'pass' => $this->input('pass'),
            'confirm' => $this->input('confirm'),
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
                'errors' => $validator->errors(),
            ])
        );
    }
}
