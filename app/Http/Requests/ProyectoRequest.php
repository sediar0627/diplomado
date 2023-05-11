<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProyectoRequest extends FormRequest
{
    public function prepareForValidation(): void
    {
        $this->merge([
            'codigo' => strtoupper($this->codigo),
            'nombre' => ucwords($this->nombre),
            'descripcion' => ucfirst($this->descripcion),
        ]);
    }

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
        $unique = $this->routeIs('proyectos.update') ? "{$this->id}" : 'NULL';

        return [
            'id' => [
                'nullable', 
                'integer', 
                'exists:proyectos,id,creador_id,'.auth()->id()
            ],
            'codigo' => [
                'required', 
                'string',
                'regex:/^[a-zA-Z0-9]+$/i', // Solo letras y números
                'max:10',
                "unique:proyectos,codigo,$unique,id,creador_id,".auth()->id(),
            ],
            'nombre' => ['required', 'string', 'max:30'],
            'descripcion' => ['nullable', 'string', 'max:250'],
        ];
    }
}
