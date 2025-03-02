<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreToolRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:tools,name'],
            'description' => ['required', 'string', 'max:255'],
            'file' => ['nullable', 'file'],
            'serial' => ['required', 'string', 'max:255', 'unique:tools,serial'],
            'last_calibration' => ['required', 'date'],
        ];
    }
}
