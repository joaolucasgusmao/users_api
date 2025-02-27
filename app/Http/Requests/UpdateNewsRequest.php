<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsRequest extends FormRequest
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
            "hat" => "nullable|string|min:3|max:30",
            "title" => "string|min:5|max:255",
            "summary" => "nullable|string|min:5|max:255",
            "image" => ["url", "regex:/\\.(jpg|jpeg|png|webp)$/i"],
            "content" => "string|min:5",
            "caption" => "nullable|string|min:5|max:255",
            "topics" => "nullable|array",
            "topics.*" => "string|min:3|max:50",
            "is_fixed" => "sometimes|boolean",
            "is_draft" => "sometimes|boolean",
            "is_active" => "sometimes|boolean",
            "categories" => "sometimes|array|min:1",
            "categories.*" => "required|integer|exists:categories,id",
        ];
    }

    public function messages(): array
    {
        return [
            "hat.string" => "O campo chapéu deve ser um texto.",
            "hat.min" => "O campo chapéu deve ter no mínimo :min caracteres.",
            "hat.max" => "O campo chapéu deve ter no máximo :max caracteres.",

            "title.string" => "O campo título deve ser um texto.",
            "title.min" => "O campo título deve ter no mínimo :min caracteres.",
            "title.max" => "O campo título deve ter no máximo :max caracteres.",

            "summary.string" => "O campo resumo deve ser um texto.",
            "summary.min" => "O campo resumo deve ter no mínimo :min caracteres.",
            "summary.max" => "O campo resumo deve ter no máximo :max caracteres.",

            "image.url" => "O campo imagem deve ser uma URL válida.",
            "image.regex" => "A URL da imagem deve terminar em .jpg, .jpeg, .png ou .webp.",

            "content.string" => "O campo conteúdo deve ser um texto.",
            "content.min" => "O campo conteúdo deve ter no mínimo :min caracteres.",

            "caption.string" => "O campo legenda deve ser um texto.",
            "caption.min" => "O campo legenda deve ter no mínimo :min caracteres.",
            "caption.max" => "O campo legenda deve ter no máximo :max caracteres.",

            "topics.array" => "O campo tópicos deve ser um array.",
            "topics.*.string" => "Cada item em tópicos deve ser um texto.",
            "topics.*.min" => "Cada item em tópicos deve ter no mínimo :min caracteres.",
            "topics.*.max" => "Cada item em tópicos deve ter no máximo :max caracteres.",

            "is_fixed.boolean" => "O campo 'is_fixed' deve ser verdadeiro ou falso.",
            "is_draft.boolean" => "O campo 'is_draft' deve ser verdadeiro ou falso.",
            "is_active.boolean" => "O campo 'is_active' deve ser verdadeiro ou falso.",

            "categories.array" => "O campo categorias deve ser um array.",
            "categories.min" => "Cada item em categorias é obrigatório.",
            "categories.*.integer" => "Cada item em categorias deve ser um número inteiro.",
            "categories.*.exists" => "Uma ou mais categorias selecionadas são inválidas.",
        ];
    }
}
