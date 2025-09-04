<?php

namespace App\Http\Requests;

class NivelIndexRequest extends PaginationRequest
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
            'nivel' => 'nullable|string|max:255',
        ]);
    }

    public function messages(): array
    {
        return array_merge(parent::messages(), [
            'nivel.string' => 'O campo nível deve ser uma string.',
            'nivel.max' => 'O campo nível não pode ter mais de 255 caracteres.',
        ]);
    }
}
