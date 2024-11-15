<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;

class RequesterRequest extends FormRequest
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
            'id' => $this->has('id') ? Crypt::decryptString($this->input('id')) : null,
            'requester' => $this->input('requester'),
            'fname' => $this->input('fname'),
            'mname' => $this->input('mname'),
            'lname' => $this->input('lname'),
            'department' => $this->input('department'),
            'email' => $this->input('email'),
            'phone' => $this->input('phone'),
            'status' => $this->input('status'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'requester' => [
                'required',
                'size:8',
                'regex:/^(0[7-9]|1[0-9]|2[0-' . date('y')[1] . '])-\d{5}$/',
                Rule::unique('requesters', 'req_num')->ignore($this->id),
            ],
            'fname' => [
                'required',
                'regex:/^(?!.*([ \'\-])\1)[a-zA-ZÀ-ÖØ-öø-ÿ\']+(?:[ \'\-][a-zA-ZÀ-ÖØ-öø-ÿ\']+)*$/',
                'min:2',
                'max:50',
            ],
            'mname' => [
                'nullable',
                'regex:/^(?!.*([ \'\-])\1)[a-zA-ZÀ-ÖØ-öø-ÿ\']+(?:[ \'\-][a-zA-ZÀ-ÖØ-öø-ÿ\']+)*$/',
                'min:2',
                'max:50',
            ],
            'lname' => [
                'required',
                'regex:/^(?!.*([ \'\-])\1)[a-zA-ZÀ-ÖØ-öø-ÿ\']+(?:[ \'\-][a-zA-ZÀ-ÖØ-öø-ÿ\']+)*$/',
                'min:2',
                'max:50',
            ],
            'department' => [
                'required',
            ],
            'email' => [
                'required',
                'min:8',
                'max:50',
                'email',
                Rule::unique('requesters', 'email')->ignore($this->id),
            ],
            'phone' => [
                'nullable',
                'size:13',
                'regex:/^(09)\d{2}-\d{3}-\d{4}$/',
                Rule::unique('requesters', 'phone_num')->ignore($this->id),
            ],
        ];

        $idRule = ['id' => 'required|exists:requesters,id'];

        if ($this->routeIs('requester.create')) {
            return $rules;
        } elseif ($this->routeIs('requester.update')) {
            return !isset($this->status) ? $idRule + $rules : $idRule + ['status' => 'required|in:0,1'];
        } else {
            return $idRule;
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'requester.required' => 'Please enter requester ID!',
            'requester.size' => 'The requester ID must be exactly :size characters.',
            'requester.regex' => 'The requester ID is invalid.',
            'requester.unique' => 'This requester ID is already taken!',

            'fname.required' => 'Please enter your first name!',
            'fname.regex' => 'It must not contain numbers, special symbols, and multiple spaces.',
            'fname.min' => 'The first name must be at least :min characters.',
            'fname.max' => 'The first name may not be greater than :max characters.',

            'mname.regex' => 'It must not contain numbers, special symbols, and multiple spaces.',
            'mname.min' => 'The middle name must be at least :min characters.',
            'mname.max' => 'The middle name may not be greater than :max characters.',

            'lname.required' => 'Please enter your last name!',
            'lname.regex' => 'It must not contain numbers, special symbols, and multiple spaces.',
            'lname.min' => 'The last name must be at least :min characters.',
            'lname.max' => 'The last name may not be greater than :max characters.',

            'email.required' => 'Please enter your email address!',
            'email.min' => 'It must be at least :min characters',
            'email.max' => 'It must not exceed :max characters.',
            'email.email' => 'This email is invalid!',
            'email.unique' => 'This email is already taken!',

            'phone.size' => 'The phone number must be exactly 11 characters.',
            'phone.regex' => 'The phone number must follow the format: 09##-###-####.',
            'phone.unique' => 'This phone number is already taken!',
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
                'errors' => $validator->errors()
            ])
        );
    }
}
