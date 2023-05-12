<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnviarInvitacionProyectoRequest extends FormRequest
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
            'correo' => [
                'required', 
                'email', 
                'exists:usuarios,email',
                function($attribute, $value, $fail){
                    if($value == auth()->user()->email){
                        $fail('No te puedes invitar a ti mismo al proyecto');
                    }
                }
            ]
        ];
    }
}
