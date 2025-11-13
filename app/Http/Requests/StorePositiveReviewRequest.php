<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\RateLimiter;

class StorePositiveReviewRequest extends FormRequest
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
            'pelapor_nama'      => 'required|string|max:255',
            'pelapor_contact'   => 'required|string|max:20',
            'email'             => 'required|email|max:255',
            'jenis_layanan_id'  => 'required|exists:jenis_layanan,id',
            'rating'            => 'required|integer|min:1|max:5',
            'note'              => 'nullable|string|max:2000',
            'upt_id'            => 'required|exists:units,id',
            'hp_field' => 'prohibited',  
        ];
    }

    // public function withValidator($validator)
    // {
    //     $validator->after(function ($v) {
    //         $key = $this->throttleKey();
    //         if (RateLimiter::tooManyAttempts($key, 10)) {
    //             $v->errors()->add('rating', 'Terlalu banyak permintaan dari alamat ini. Silakan coba lagi nanti.');
    //         }
    //     });
    // }

    // public function passedValidation()
    // {
    //     RateLimiter::hit($this->throttleKey(), 3600);
    // }

    // protected function throttleKey()
    // {
    //     return 'positive-review:' . $this->ip();
    // }
}