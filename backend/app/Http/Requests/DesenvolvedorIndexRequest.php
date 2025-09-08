<?php

namespace App\Http\Requests;

class DesenvolvedorIndexRequest extends PaginationWithOrderRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'nome' => 'nullable|string|max:255',
            'nivel_id' => 'nullable|integer|exists:nivels,id',
            'sexo' => 'nullable|in:M,F',
            'hobby' => 'nullable|string|max:255',
            'data_nascimento' => 'nullable|date',
            'order_by' => [...parent::rules()['order_by'], 'in:id,nome,nivel_id,sexo,data_nascimento,nivel'],
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
            'order_by.in' => 'O campo order_by deve ser "nome", "nivel_id", "nivel", "sexo", "data_nascimento" ou "id".',
        ]);
    }
}
