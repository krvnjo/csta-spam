<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
            'category' => $this->input('category'),
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
            'category' => [
                'required',
                'regex:/^(?!.*([ .&\'-])\1)[a-zA-Z0-9][a-zA-Z0-9 .&\'-]*$/',
                'min:2',
                'max:30',
                Rule::unique('categories', 'name')->ignore($this->id),
            ],
        ];

        $idRule = ['id' => 'required|exists:categories,id'];

        if ($this->routeIs('category.create')) {
            return $rules;
        } elseif ($this->routeIs('category.update')) {
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
            'category.required' => 'Please enter a category name!',
            'category.regex' => 'No consecutive spaces and special symbols allowed. Allowed: (. & \' -)',
            'category.min' => 'It must be at least :min characters.',
            'category.max' => 'It must not exceed :max characters.',
            'category.unique' => 'This category name already exists.',
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
