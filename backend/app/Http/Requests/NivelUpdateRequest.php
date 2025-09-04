<?php

namespace App\Http\Requests;

use App\Traits\RequestWithFailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class NivelUpdateRequest extends FormRequest
{
    use RequestWithFailedValidation;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nivel' => 'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'nivel.required' => 'O campo nível é obrigatório.',
            'nivel.string' => 'O campo nível deve ser uma string.',
            'nivel.max' => 'O campo nível não pode ter mais de 100 caracteres.',
        ];
    }
}
