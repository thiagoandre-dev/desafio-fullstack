<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\HasOrder;
use App\Http\Requests\Traits\HasPagination;
use App\Http\Requests\Traits\WithFailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class PaginationWithOrderRequest extends FormRequest
{
    use HasOrder, HasPagination, WithFailedValidation;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge(
            $this->paginationRules(),
            $this->orderRules()
        );
    }

    public function messages(): array
    {
        return array_merge(
            $this->paginationMessages(),
            $this->orderMessages()
        );
    }
}
