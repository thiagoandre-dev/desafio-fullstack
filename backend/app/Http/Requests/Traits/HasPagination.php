<?php

namespace App\Http\Requests\Traits;

trait HasPagination
{
    public function paginationRules(): array
    {
        return [
            'page' => ['integer', 'min:1'],
            'limit' => ['integer', 'min:1', 'max:100'],
        ];
    }

    public function paginationDefaults(): array
    {
        return [
            'page' => 1,
            'limit' => 10,
        ];
    }

    public function paginationMessages(): array
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
