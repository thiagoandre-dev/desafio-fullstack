<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\WithFailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class NivelStoreRequest extends FormRequest
{
    use WithFailedValidation;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nivel' => 'required|string|max:100|unique:niveis,nivel',
        ];
    }

    public function messages(): array
    {
        return [
            'nivel.required' => 'O campo nível é obrigatório.',
            'nivel.string' => 'O campo nível deve ser uma string.',
            'nivel.max' => 'O campo nível não pode ter mais de 100 caracteres.',
            'nivel.unique' => 'O nível informado já existe.',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'nivel' => $this->input('nivel') ? trim($this->input('nivel')) : null,
        ]);
    }
}
