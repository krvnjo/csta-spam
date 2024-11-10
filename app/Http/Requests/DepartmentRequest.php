<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;

class DepartmentRequest extends FormRequest
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
            'department' => $this->input('department'),
            'code' => $this->input('code'),
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
            'department' => [
                'required',
                'regex:/^(?!.*([ .&\'-])\1)[a-zA-Z0-9][a-zA-Z0-9 .&\'-]*$/',
                'min:5',
                'max:50',
                Rule::unique('departments', 'name')->ignore($this->id),
            ],
            'code' => [
                'required',
                'regex:/^(?!.*([- ])\1)[a-zA-Z]+([a-zA-Z- ]*[a-zA-Z])?$/',
                'min:3',
                'max:15',
                Rule::unique('departments', 'code')->ignore($this->id),
            ],
        ];

        $idRule = ['id' => 'required|exists:departments,id'];

        if ($this->routeIs('department.create')) {
            return $rules;
        } elseif ($this->routeIs('department.update')) {
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
            'department.required' => 'Please enter a department name!',
            'department.regex' => 'No consecutive spaces and special symbols allowed. Allowed: (. & \' -)',
            'department.min' => 'It must be at least :min characters.',
            'department.max' => 'It must not exceed :max characters.',
            'department.unique' => 'This department name already exists.',

            'code.required' => 'Please enter a department code!',
            'code.regex' => 'No consecutive spaces and special symbols allowed. Allowed: (-)',
            'code.min' => 'It must be at least :min characters.',
            'code.max' => 'It must not exceed :max characters.',
            'code.unique' => 'This department code already exists.',
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
