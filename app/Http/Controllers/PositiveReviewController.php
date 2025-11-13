<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PositiveReview;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StorePositiveReviewRequest;

class PositiveReviewController extends Controller
{
   public function store(StorePositiveReviewRequest $request)
    {
        $data = $request->validated();

        try {
            $meta = [
                'ip' => $request->ip(),
                'ua' => substr($request->userAgent() ?? '', 0, 500),
            ];

            // simpan UPT agar tidak perlu ubah struktur table
            if (!empty($data['upt_id'])) {
                $meta['upt_id'] = (int) $data['upt_id'];
            }

            // simpan jenis layanan
            if (!empty($data['jenis_layanan_id'])) {
                $meta['jenis_layanan_id'] = (int) $data['jenis_layanan_id'];
            }

            // simpan review
            $review = PositiveReview::create([
                'pengaduan_id'    => $request->input('pengaduan_id', null),
                'pelapor_nama'    => $data['pelapor_nama'],
                'pelapor_contact' => $data['pelapor_contact'],
                'email'           => $data['email'],
                'rating'          => (int) $data['rating'],
                'note'            => $data['note'] ?? null,
                'meta'            => $meta,
            ]);

            return redirect()
                ->route('pengaduan.rating')
                ->with('ok', 'Terima kasih atas ulasan positif Anda!');
                // ->with('auto_redirect', url('/'));
                

        } catch (\Throwable $e) {

            Log::error('Failed to save positive review', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'input'   => $request->except(['hp_field']), // jangan log honeypot
            ]);

            return back()
                ->withInput()
                ->withErrors(['internal' => 'Gagal menyimpan ulasan, silakan coba lagi.']);
        }
    }
}