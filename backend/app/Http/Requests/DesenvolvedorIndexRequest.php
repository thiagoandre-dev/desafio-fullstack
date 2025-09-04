<?php

namespace App\Http\Requests;

class DesenvolvedorIndexRequest extends PaginationRequest
{
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
        return array_merge(parent::rules(), [
            'nome' => 'nullable|string|max:255',
            'nivel_id' => 'nullable|integer|exists:nivels,id',
            'sexo' => 'nullable|in:M,F',
            'hobby' => 'nullable|string|max:255',
            'data_nascimento' => 'nullable|date',
        ]);
    }

    public function messages(): array
    {
        return array_merge(parent::messages(), [
            'nome.string' => 'O campo nome deve ser uma string.',
            'nome.max' => 'O campo nome não pode ter mais de 255 caracteres.',
            'nivel_id.integer' => 'O campo nível deve ser um número inteiro.',
            'nivel_id.exists' => 'O nível selecionado é inválido.',
            'sexo.in' => 'O campo sexo deve ser "M" ou "F".',
            'hobby.string' => 'O campo hobby deve ser uma string.',
            'hobby.max' => 'O campo hobby não pode ter mais de 255 caracteres.',
            'data_nascimento.date' => 'O campo data de nascimento deve ser uma data válida.',
        ]);
    }
}
