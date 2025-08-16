<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssistanceTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && in_array(auth()->user()->role, ['admin', 'officer']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:assistance_types,name',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'max_amount' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama jenis bantuan harus diisi.',
            'name.unique' => 'Nama jenis bantuan sudah ada.',
            'description.required' => 'Deskripsi harus diisi.',
            'max_amount.numeric' => 'Jumlah maksimal harus berupa angka.',
            'max_amount.min' => 'Jumlah maksimal tidak boleh negatif.',
        ];
    }
}