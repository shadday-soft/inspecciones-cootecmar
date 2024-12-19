<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInspectionRequest extends FormRequest
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
            'solicitante' => ['required', 'string', 'max:255'],
            'gerencia' => ['required'],
            'fecha' => ['required','date'],
            'tipo' => ['required'],
            'grafo' => ['required'],
            'supervisor' => ['required', 'string', 'max:255'],
            'prioridad' => ['required'],
            'descripcion' => ['required']
        ];
    }
}
