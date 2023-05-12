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
            'sprint_id' => ['nullable', 'exists:sprints,id,proyecto_id,' . $this->route('proyecto')->id],
            'titulo' => ['required', 'string', 'max:100'],
            'descripcion' => ['nullable', 'string'],
            'epica_id' => ['nullable', 'exists:epicas,id,proyecto_id,' . $this->route('proyecto')->id],
            'puntaje' => ['nullable', 'integer', 'min:1', 'max:32'],
            'responsable_id' => [
                'nullable', 
                'exists:usuarios,id',
                function ($attribute, $value, $fail) {
                    if (!$this->route('proyecto')->usuariosInvitados->pluck('id')->contains($value)) {
                        $fail('El usuario no pertenece al proyecto');
                    }
                }
            ],
        ];
    }
}
