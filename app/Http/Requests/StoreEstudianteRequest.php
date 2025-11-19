<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEstudianteRequest extends FormRequest
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
        $estudianteId = $this->route('estudiante');
        return [
            'nombre'=>'required|string|max:150',
            'ap'=>'nullable|string|max:100',
            'am'=>'nullable|string|max:100',
            'genero'=>'nullable|in:M,F,O',
            'no_cuenta'=>'required|string|max:50|unique:estudiantes,no_cuenta,'.$estudianteId.',id_estudiante',
            'id_carrera'=>'required|exists:carreras,id_carrera'
        ];
    }
}
