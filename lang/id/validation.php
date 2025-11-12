<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    */

    'accepted'             => 'Atribut :attribute harus diterima.',
    // ... (biarkan isi default lainnya)
    'required'             => 'Kolom :attribute wajib diisi.',
    'max'                  => [
        'string'  => 'Panjang :attribute maksimal :max karakter.',
        'file'    => 'Ukuran :attribute maksimal :max kilobyte.',
    ],
    'mimes'                => 'Format :attribute harus berupa :values.',
    'image'                => ':attribute harus berupa gambar.',
    'exists'               => ':attribute yang dipilih tidak valid.',
    'integer'              => ':attribute harus berupa angka.',
    'min'                  => [
        'string' => ':attribute minimal :min karakter.',
    ],
    // ...

    'attributes' => [
        'upt_id' => 'kantor imigrasi',
        'pelapor_nama' => 'nama pelapor',        
        'pelapor_contact' => 'kontak',
        'email' => 'email',
        'kategori_id' => 'kategori pengaduan',
        'jenis_layanan_id' => 'jenis layanan',
        'judul' => 'judul',
        'deskripsi' => 'deskripsi',
        'bukti_masyarakat' => 'bukti pengaduan',
        'bukti_masyarakat.*' => 'file bukti',
        'asal_pengaduan' => 'asal pengaduan',
    ],

    'custom' => [
        // field-specific override messages (opsional)
        'kategori_id' => [
            'required' => 'Silakan pilih kategori pengaduan.',
            'exists' => 'Kategori yang dipilih tidak ditemukan.',
        ],
        'jenis_layanan_id' => [
            'required' => 'Silakan pilih jenis layanan.',
            'exists' => 'Jenis layanan yang dipilih tidak ditemukan.',
        ],
        'upt_id' => [
            'required' => 'Silakan pilih kantor imigrasi tujuan.',
            'exists' => 'Kantor imigrasi tidak ditemukan.',
        ],
        'deskripsi' => [
            'required' => 'Deskripsi pengaduan wajib diisi.',
            'min' => 'Deskripsi terlalu singkat, jelaskan minimal :min karakter.',
        ],
        'bukti_masyarakat.*' => [
            'image' => 'Lampiran harus berupa gambar (jpg, png, webp).',
            'mimes' => 'Format lampiran harus JPG / JPEG / PNG / WEBP.',
            'max' => 'Ukuran setiap file maksimal :max kilobyte.',
        ],
        'pelapor_nama' => [
            'required' => 'Nama Pelapor Wajib Diisi',
        ],
        'pelapor_contact' => [
            'required' => 'No Handphone Wajib Diisi',
        ],
        'email' => [
            'required' => 'Alamat Email Wajib Diisi',
        ],
        'duplicate' => 'A similar complaint with the same contact and title has already been submitted today.',
    ],

];
