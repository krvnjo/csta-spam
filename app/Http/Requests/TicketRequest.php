<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;

class TicketRequest extends FormRequest
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
            'ticket' => $this->input('ticket'),
            'description' => $this->input('description'),
            'cost' => $this->input('cost'),
            'priority' => $this->input('priority'),
            'progress' => $this->input('status'),
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
            'ticket' => [
                'required',
                'regex:/^(?!.*([ .&\'-])\1)[a-zA-Z0-9][a-zA-Z0-9 .&\'-]*$/',
                'min:5',
                'max:30',
                Rule::unique('tickets', 'name')->ignore($this->id),
            ],
            'description' => [
                'required',
                'min:10',
                'max:255',
            ],
            'cost' => [
                'required',
                'numeric',
                'regex:/^\d+(\.\d{1,2})?$/',
                'min:1'],
            'priority' => [
                'required',
            ],
        ];

        $idRule = ['id' => 'required|exists:tickets,id'];

        if ($this->routeIs('request.create')) {
            return $rules;
        } elseif ($this->routeIs('request.update')) {
            return !isset($this->status) ? $idRule + $rules : $idRule + ['progress' => 'required'];
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
            'ticket.required' => 'The ticket name is required.',
            'ticket.regex' => 'The ticket name is invalid.',
            'ticket.min' => 'The ticket name must be at least :min characters.',
            'ticket.max' => 'The ticket name may not be greater than :max characters.',
            'ticket.unique' => 'The ticket name has already been taken.',

            'description.required' => 'The description is required.',
            'description.min' => 'The description must be at least :min characters.',
            'description.max' => 'The description may not be greater than :max characters.',

            'cost.required' => 'The estimated cost is required.',
            'cost.numeric' => 'The estimated cost must be a number.',
            'cost.regex' => 'The estimated cost must be a number with up to 2 decimal places.',
            'cost.min' => 'The estimated cost must be at least :min.',

            'priority.required' => 'The priority is required.',
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
