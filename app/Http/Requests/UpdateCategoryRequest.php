<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
        return [
            "name" => "required|string|min:3|max:25"
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "É obrigatório preencher o nome da categoria.",
            "name.string" => "O nome da categoria deve ser válido.",
            "name.min" => "A categoria deve ter no mínimo :min caracteres.",
            "name.max" => "A categoria deve ter no máximo :max caracteres.",
        ];
    }
}
