<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\UpdateNarcaRequet;

class UpdateMarcaRequest extends FormRequest
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
        $marca = $this->route('marca');
        $caracteristicaId = $marca->caracteristica->id;
        return [
            'nombre' => 'required|string|max:60|unique:caracteristicas,nombre,'. $caracteristicaId,
            'descripcion' => 'string|max:255|nullable',
        ];
    }
}
