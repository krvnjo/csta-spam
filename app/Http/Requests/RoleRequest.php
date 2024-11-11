<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
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
            'role' => $this->input('role'),
            'description' => $this->input('description'),
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
            'role' => [
                'required',
                'regex:/^(?!.*([ .&\'-])\1)[a-zA-Z0-9][a-zA-Z0-9 .&\'-]*$/',
                'min:5',
                'max:50',
                Rule::unique('roles', 'name')->ignore($this->id),
            ],
            'permission' => [
                'required',
                'regex:/^(?!.*([- ])\1)[a-zA-Z]+([a-zA-Z- ]*[a-zA-Z])?$/',
                'min:3',
                'max:15',
                Rule::unique('roles', 'permission')->ignore($this->id),
            ],
        ];

        $idRule = ['id' => 'required|exists:roles,id'];

        if ($this->routeIs('role.create')) {
            return $rules;
        } elseif ($this->routeIs('role.update')) {
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
            'role.required' => 'Please enter a role name!',
            'role.regex' => 'No consecutive spaces and special symbols allowed. Allowed: (. & \' -)',
            'role.min' => 'It must be at least :min characters.',
            'role.max' => 'It must not exceed :max characters.',
            'role.unique' => 'This role name already exists.',

            'permission.required' => 'Please enter a role permission!',
            'permission.regex' => 'No consecutive spaces and special symbols allowed. Allowed: (-)',
            'permission.min' => 'It must be at least :min characters.',
            'permission.max' => 'It must not exceed :max characters.',
            'permission.unique' => 'This role permission already exists.',
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
