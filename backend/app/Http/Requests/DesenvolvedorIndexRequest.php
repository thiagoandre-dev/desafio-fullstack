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
}
