<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ChangeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare/sanitize the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'user' => $this->input('user'),
            'current' => $this->input('current'),
            'new' => $this->input('new'),
            'confirm' => $this->input('confirm'),
        ]);
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
                'size:8',
                'regex:/^(0[7-9]|1[0-9]|2[0-' . date('y') . '])-\d{5}$/',
                'exists:users,user_name',
            ],
            'current' => [
                'required',
                'min:8',
                'max:20',
            ],
            'new' => [
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
                'same:new',
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
            'user.size' => 'The username must be exactly :size characters.',
            'user.regex' => 'The username is invalid.',
            'user.exists' => 'The username does not exist.',

            'current.required' => 'Please enter your current password!',
            'current.min' => 'It must be at least :min characters.',
            'current.max' => 'It must not exceed :max characters.',

            'new.required' => 'Please enter your new password!',
            'new.min' => 'It must be at least :min characters',
            'new.max' => 'It must not exceed :max characters.',
            'new.regex' => 'Your new password must contain at least one uppercase letter, one lowercase letter, one number, and one special character!',

            'confirm.required' => 'Please confirm your new password!',
            'confirm.same' => 'The password confirmation does not match the new password!',
        ];
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
