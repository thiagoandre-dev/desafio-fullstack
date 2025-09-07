<?php

namespace App\Http\Requests;

use App\Traits\RequestWithFailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class PaginationRequest extends FormRequest
{
    use RequestWithFailedValidation;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'page' => 'integer|min:1',
            'limit' => 'integer|min:1|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'page.integer' => 'O campo página deve ser um número inteiro.',
            'page.min' => 'O campo página deve ser no mínimo 1.',
            'limit.integer' => 'O campo limite deve ser um número inteiro.',
            'limit.min' => 'O campo limite deve ser no mínimo 1.',
            'limit.max' => 'O campo limite deve ser no máximo 100.',
        ];
    }
}
