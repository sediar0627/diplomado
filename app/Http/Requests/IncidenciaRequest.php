<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IncidenciaRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'sprint_id' => ['nullable', 'exists:sprints,id'],
            'titulo' => ['required', 'string', 'max:100'],
            'descripcion' => ['nullable', 'text'],
            'epica_id' => ['nullable', 'exists:epicas,id'],
            'puntaje' => ['nullable', 'integer', 'min:1', 'max:32'],
            'responsable_id' => ['nullable', 'exists:users,id'],
        ];
    }
}
