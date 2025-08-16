<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'assistance_type_id' => 'required|exists:assistance_types,id',
            'applicant_name' => 'required|string|max:255',
            'nik' => 'required|string|size:16|regex:/^[0-9]{16}$/',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'village' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'requested_amount' => 'nullable|numeric|min:0',
            'reason' => 'required|string',
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
            'assistance_type_id.required' => 'Jenis bantuan harus dipilih.',
            'assistance_type_id.exists' => 'Jenis bantuan yang dipilih tidak valid.',
            'applicant_name.required' => 'Nama pemohon harus diisi.',
            'nik.required' => 'NIK harus diisi.',
            'nik.size' => 'NIK harus terdiri dari 16 digit.',
            'nik.regex' => 'NIK harus berupa angka 16 digit.',
            'phone.required' => 'Nomor telepon harus diisi.',
            'address.required' => 'Alamat harus diisi.',
            'village.required' => 'Desa/Kelurahan harus diisi.',
            'district.required' => 'Kecamatan harus diisi.',
            'requested_amount.numeric' => 'Jumlah bantuan harus berupa angka.',
            'requested_amount.min' => 'Jumlah bantuan tidak boleh negatif.',
            'reason.required' => 'Alasan permohonan harus diisi.',
        ];
    }
}