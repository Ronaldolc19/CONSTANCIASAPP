<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConstanciaRequest extends FormRequest
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
            'no_registro'=>'required|string|max:100|unique:constancias,no_registro,'.$this->route('constancia'),
            'no_folio'=>'nullable|string|max:100|unique:constancias,no_folio,'.$this->route('constancia'),
            'fecha_emision'=>'required|date',
            'id_estudiante'=>'required|exists:estudiantes,id_estudiante',
            'id_empresa'=>'nullable|exists:empresas,id_empresa',
            'id_periodo'=>'nullable|exists:periodos,id_periodo',
        ];
    }
}
