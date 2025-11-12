<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePengaduanRequest extends FormRequest
{
    public function authorize()
    {
        return true; // atur permission jika perlu
    }

    public function rules()
    {
        return [
            'upt_id' => 'required|integer|exists:units,id',
            'pelapor_nama' => 'required|string|max:191',
            'pelapor_contact' => ['required', 'regex:/^[0-9]+$/'],
            'email' => 'required|email|max:200',
            'kategori_id' => 'required|integer|exists:kategori_pengaduan,id',
            'jenis_layanan_id' => 'required|integer|exists:jenis_layanan,id',
            'pelapor_nama'=>'required|string|',
            'judul' => 'required|string|max:191',
            'deskripsi' => 'required|string|min:10',
            'prioritas' => 'nullable|in:rendah,tinggi',
            'bukti_masyarakat' => 'nullable|array',
            'bukti_masyarakat.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120', // HANYA foto, max 5MB
            'asal_pengaduan' => 'nullable|string|max:50',
           
        ];
    }

    // opsi: custom messages lokal bisa diletakkan di resources/lang/... sebaiknya.
    public function messages()
    {
        return [
            // tambahan pesan khusus (opsional) — sebagian sudah di lang/validation.php
            'bukti_masyarakat.*.image' => __('validation.custom.bukti_masyarakat.*.image') ?? 'Lampiran harus gambar.',
        ];
    }
}
