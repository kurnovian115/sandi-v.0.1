<?php

namespace App\Http\Requests\UPT;

use Illuminate\Foundation\Http\FormRequest;

class DisposisiStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->isRole('admin_upt') ?? false;
    }

   
    public function rules(): array
    {
        return [
            'admin_layanan_id' => ['required','exists:users,id'],
            'note' => ['nullable','string','max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'admin_layanan_id.required' => 'Penerima disposisi wajib dipilih.',
        ];
    }
}
