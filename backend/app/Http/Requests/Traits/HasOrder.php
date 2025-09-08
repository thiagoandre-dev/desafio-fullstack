<?php

namespace App\Http\Requests\Traits;

trait HasOrder
{
    public function orderRules(): array
    {
        return [
            'order_by' => ['nullable', 'string'],
            'order_direction' => ['nullable', 'string', 'in:asc,desc'],
        ];
    }

    public function orderDefaults(): array
    {
        return [
            'order_by' => 'id',
            'order_direction' => 'asc',
        ];
    }

    public function orderMessages(): array
    {
        return [
            'order_by.string' => 'O campo order_by deve ser uma string.',
            'order_direction.string' => 'O campo order_direction deve ser uma string.',
            'order_direction.in' => 'O campo order_direction deve ser "asc" ou "desc".',
        ];
    }
}
