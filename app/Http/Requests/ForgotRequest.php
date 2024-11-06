<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ForgotRequest extends FormRequest
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
            'email' => [
                'required',
                'min:8',
                'max:50',
                'email',
                'exists:users,email',
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Please enter an email address!',
            'email.min' => 'It must be at least :min characters.',
            'email.max' => 'It must not exceed :max characters.',
            'email.email' => 'Please enter a valid email address!',
            'email.exists' => 'This email does not exist.',
        ];
    }

    /**
     * Prepare/sanitize the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => $this->input('email'),
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
