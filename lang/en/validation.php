<?php

return [
    'required' => 'The :attribute field is required.',
    'max' => [
        'string' => 'The :attribute may not be greater than :max characters.',
        'file' => 'The :attribute may not be greater than :max kilobytes.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'image' => 'The :attribute must be an image.',
    'exists' => 'The selected :attribute is invalid.',
    'integer' => 'The :attribute must be an integer.',
    'min' => [
        'string' => 'The :attribute must be at least :min characters.',
    ],

    'attributes' => [
        'upt_id' => 'immigration office',
        'pelapor_nama' => 'reporter name',
        'pelapor_contact' => 'contact',
        'kategori_id' => 'complaint category',
        'jenis_layanan_id' => 'service type',
        'judul' => 'title',
        'deskripsi' => 'description',
        'bukti_masyarakat' => 'evidence',
        'bukti_masyarakat.*' => 'evidence file',
        'asal_pengaduan' => 'source',
    ],

    'custom' => [
        'kategori_id' => [
            'required' => 'Please select a complaint category.',
            'exists' => 'The selected category was not found.',
        ],
        'jenis_layanan_id' => [
            'required' => 'Please select a service type.',
            'exists' => 'The selected service type was not found.',
        ],
        'upt_id' => [
            'required' => 'Please select an immigration office.',
            'exists' => 'Selected office not found.',
        ],
        'deskripsi' => [
            'required' => 'Complaint description is required.',
            'min' => 'Description is too short, at least :min characters.',
        ],
        'bukti_masyarakat.*' => [
            'image' => 'Attachments must be images (jpg, png, webp).',
            'mimes' => 'Attachments must be JPG / JPEG / PNG / WEBP.',
            'max' => 'Each file must not exceed :max kilobytes.',
        ],
        'duplicate' => 'Pengaduan dengan kontak dan judul yang sama sudah tercatat hari ini.',
    ],
];
