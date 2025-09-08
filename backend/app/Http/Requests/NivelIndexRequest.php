<?php

namespace App\Http\Requests;

class NivelIndexRequest extends PaginationWithOrderRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'nivel' => ['nullable', 'string', 'max:255'],
            'order_by' => [...parent::rules()['order_by'], 'in:id,nivel'],
        ]);
    }

    public function messages(): array
    {
        return array_merge(parent::messages(), [
            'nivel.string' => 'O campo nível deve ser uma string.',
            'nivel.max' => 'O campo nível não pode ter mais de 255 caracteres.',
            'order_by.in' => 'O campo order_by deve ser "nivel" ou "id".',
        ]);
    }
}
