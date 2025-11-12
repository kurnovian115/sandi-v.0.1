<?php

namespace App\Http\Requests\UPT;

use Illuminate\Foundation\Http\FormRequest;

class JawabanStoreRequest extends FormRequest
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
            'hasil_tindaklanjut' => ['required','string','min:5'],
            'petugas_nama' => ['required','string','max:255'],
            'dokumen_penyelesaian' => ['nullable','file','mimes:pdf,jpg,jpeg,png','max:4096'],
        ];
    }
}
