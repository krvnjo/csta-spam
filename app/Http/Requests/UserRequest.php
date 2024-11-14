<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'user' => $this->input('user'),
            'pass' => $this->input('pass'),
            'confirm' => $this->input('confirm'),
            'fname' => $this->input('fname'),
            'mname' => $this->input('mname'),
            'lname' => $this->input('lname'),
            'role' => $this->input('role'),
            'department' => $this->input('department'),
            'email' => $this->input('email'),
            'phone' => $this->input('phone'),
            'image' => $this->file('image'),
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
            'user' => [
                'required',
                'size:8',
                'regex:/^(0[7-9]|1[0-9]|2[0-' . date('y')[1] . '])-\d{5}$/',
                Rule::unique('users', 'user_name')->ignore($this->id),
            ],
            'pass' => [
                $this->routeIs('user.create') ? 'required' : 'nullable',
                'min:8',
                'max:20',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[\W_]/',
            ],
            'confirm' => [
                'same:pass',
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
            'role' => [
                'required',
            ],
            'department' => [
                'required',
            ],
            'email' => [
                'required',
                'min:8',
                'max:50',
                'email',
                Rule::unique('users', 'email')->ignore($this->id),
            ],
            'phone' => [
                'nullable',
                'size:13',
                'regex:/^(09)\d{2}-\d{3}-\d{4}$/',
                Rule::unique('users', 'phone_num')->ignore($this->id),
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048'
            ],
        ];

        $idRule = ['id' => 'required|exists:users,id'];

        if ($this->routeIs('user.create')) {
            return $rules;
        } elseif ($this->routeIs('user.update')) {
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
            'user.required' => 'Please enter your username!',
            'user.size' => 'The username must be exactly :size characters.',
            'user.regex' => 'The username is invalid.',
            'user.unique' => 'This username is already taken!',

            'pass.required' => 'Please enter your password!',
            'pass.min' => 'It must be at least :min characters',
            'pass.max' => 'It must not exceed :max characters.',
            'pass.regex' => 'Your password must contain at least one uppercase letter, one lowercase letter, one number, and one special character!',

            'confirm.same' => 'The password confirmation does not match the password!',

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

            'role.required' => 'Please select your role!',
            'department.required' => 'Please select a department!',

            'email.required' => 'Please enter your email address!',
            'email.min' => 'It must be at least :min characters',
            'email.max' => 'It must not exceed :max characters.',
            'email.email' => 'This email is invalid!',
            'email.unique' => 'This email is already taken!',

            'phone.size' => 'The phone number must be exactly 11 characters.',
            'phone.regex' => 'The phone number must follow the format: 09##-###-####.',
            'phone.unique' => 'This phone number is already taken!',

            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Only jpeg, png, jpg formats are allowed.',
            'image.max' => 'Image size must not exceed 2MB.',
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
