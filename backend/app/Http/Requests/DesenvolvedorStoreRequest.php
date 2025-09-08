<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\WithFailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class DesenvolvedorStoreRequest extends FormRequest
{
    use WithFailedValidation;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'nivel_id' => 'required|integer|exists:niveis,id',
            'sexo' => 'required|in:M,F',
            'hobby' => 'nullable|string|max:255',
            'data_nascimento' => 'required|date|date_format:Y-m-d|before:today',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.string' => 'O campo nome deve ser uma string.',
            'nome.max' => 'O campo nome não pode ter mais de 255 caracteres.',
            'nivel_id.required' => 'O campo nível é obrigatório.',
            'nivel_id.integer' => 'O campo nível deve ser um número inteiro.',
            'nivel_id.exists' => 'O nível selecionado é inválido.',
            'sexo.required' => 'O campo sexo é obrigatório.',
            'sexo.in' => 'O campo sexo deve ser "M" ou "F".',
            'hobby.string' => 'O campo hobby deve ser uma string.',
            'hobby.max' => 'O campo hobby não pode ter mais de 255 caracteres.',
            'data_nascimento.required' => 'O campo data de nascimento é obrigatório.',
            'data_nascimento.date' => 'O campo data de nascimento deve ser uma data válida.',
            'data_nascimento.date_format' => 'O campo data de nascimento deve estar no formato YYYY-MM-DD.',
        ];
    }
}
