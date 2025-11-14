<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;

use App\Models\PositiveReview;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\StorePositiveReviewRequest;

class PositiveReviewController extends Controller
{
//    public function store(StorePositiveReviewRequest $request)
//     {
//         $data = $request->validated();

//         try {
//             $meta = [
//                 'ip' => $request->ip(),
//                 'ua' => substr($request->userAgent() ?? '', 0, 500),
//             ];

//             // simpan UPT agar tidak perlu ubah struktur table
//             if (!empty($data['upt_id'])) {
//                 $meta['upt_id'] = (int) $data['upt_id'];
//             }

//             // simpan jenis layanan
//             if (!empty($data['jenis_layanan_id'])) {
//                 $meta['jenis_layanan_id'] = (int) $data['jenis_layanan_id'];
//             }

//             // simpan review
//             $review = PositiveReview::create([
//                 'pengaduan_id'    => $request->input('pengaduan_id', null),
//                 'pelapor_nama'    => $data['pelapor_nama'],
//                 'pelapor_contact' => $data['pelapor_contact'],
//                 'email'           => $data['email'],
//                 'rating'          => (int) $data['rating'],
//                 'note'            => $data['note'] ?? null,
//                 'meta'            => $meta,
//             ]);

//             return redirect()
//                 ->route('pengaduan.rating')                
//                 ->with('ok',  __('review.thanks_positive'))
//                 ->with('auto_redirect', url('/'));
                

//         } catch (\Throwable $e) {

//             Log::error('Failed to save positive review', [
//                 'message' => $e->getMessage(),
//                 'trace'   => $e->getTraceAsString(),
//                 'input'   => $request->except(['hp_field']), // jangan log honeypot
//             ]);

//             return back()
//                 ->withInput()
//                 ->withErrors(['internal' => 'Gagal menyimpan ulasan, silakan coba lagi.']);
//         }
//     }

public function store(StorePositiveReviewRequest $request)
{
    $data = $request->validated();

    try {
        $meta = [
            'ip' => $request->ip(),
            'ua' => substr($request->userAgent() ?? '', 0, 500),
        ];

        // simpan UPT agar tidak perlu ubah struktur table (tetap set di meta)
        if (!empty($data['upt_id'])) {
            $meta['upt_id'] = (int) $data['upt_id'];
        }

        // simpan jenis layanan ke meta juga
        if (!empty($data['jenis_layanan_id'])) {
            $meta['jenis_layanan_id'] = (int) $data['jenis_layanan_id'];
        }

        // create payload — set kolom upt_id & jenis_layanan_id bila tersedia
        $createData = [
            'pengaduan_id'    => $request->input('pengaduan_id', null),
            'pelapor_nama'    => $data['pelapor_nama'],
            'pelapor_contact' => $data['pelapor_contact'],
            'email'           => $data['email'],
            'rating'          => (int) $data['rating'],
            'note'            => $data['note'] ?? null,
            'meta'            => $meta,
        ];

        // jika kolom upt_id & jenis_layanan_id telah ditambahkan (migration),
        // kita isikan juga supaya memudahkan query/filter di DB
        if (!empty($data['upt_id'])) {
            $createData['upt_id'] = (int) $data['upt_id'];
        }
        if (!empty($data['jenis_layanan_id'])) {
            $createData['jenis_layanan_id'] = (int) $data['jenis_layanan_id'];
        }

        $review = PositiveReview::create($createData);

        return redirect()
            ->route('pengaduan.rating')
            ->with('ok',  __('review.thanks_positive'))
            ->with('auto_redirect', url('/'));

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

 public function index(Request $request)
    {
        $q = PositiveReview::query();
        $uptId = $request->query('upt_id');
        if ($request->user()->role->name === 'admin_upt') {
            $uptId = $request->user()->unit_id;
        }
        // eager if needed
        // $q->with(['upt', 'jenisLayanan']);

        
        $layananId = $request->query('layanan_id');
        $rating = $request->query('rating');
        $search = trim((string) $request->query('q', ''));
        $perPage = (int) $request->query('per_page', 10);
        $perPage = ($perPage > 0 && $perPage <= 200) ? $perPage : 10;

        // filter upt
        if ($uptId) {
            if (Schema::hasColumn((new PositiveReview())->getTable(), 'upt_id')) {
                $q->where('upt_id', $uptId);
            } else {
                $q->where(function ($sub) use ($uptId) {
                    $sub->where('meta->upt_id', $uptId)
                        ->orWhere('meta->unit_id', $uptId)
                        ->orWhere('meta->upt', $uptId);
                });
            }
        }

        // filter layanan
        if ($layananId) {
            if (Schema::hasColumn((new PositiveReview())->getTable(), 'jenis_layanan_id')) {
                $q->where('jenis_layanan_id', $layananId);
            } else {
                $q->where('meta->jenis_layanan_id', $layananId);
            }
        }

        // rating filter
        if ($rating && in_array((int)$rating, [1,2,3,4,5], true)) {
            $q->where('rating', (int)$rating);
        }

        // search
        if ($search !== '') {
            $q->where(function ($sub) use ($search) {
                $sub->where('pelapor_nama', 'like', "%{$search}%")
                    ->orWhere('pelapor_contact', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('note', 'like', "%{$search}%");
            });
        }

        // sorting allowlist
        $sort = $request->get('sort', 'created_at');
        $dir = strtolower($request->get('dir', 'desc')) === 'asc' ? 'asc' : 'desc';
        $allowedSort = ['created_at', 'rating', 'pelapor_nama', 'pelapor_contact', 'email'];
        if (! in_array($sort, $allowedSort)) $sort = 'created_at';

        $q->orderBy($sort, $dir);

        $reviews = $q->paginate($perPage)->withQueryString();

        $upts = $this->getUpts();
        $layanans = $this->getLayanans();

        return view('upt.apresiasi.index', compact('reviews', 'upts', 'layanans'));
    }

    /**
     * Show detail JSON (optional for AJAX)
     */
    public function show(PositiveReview $positive_review)
    {
        return response()->json([
            'id' => $positive_review->id,
            'pelapor_nama' => $positive_review->pelapor_nama,
            'pelapor_contact' => $positive_review->pelapor_contact,
            'email' => $positive_review->email,
            'rating' => $positive_review->rating,
            'note' => $positive_review->note,
            'meta' => $positive_review->meta,
            'upt_id' => $positive_review->upt_id ?? ($positive_review->meta['upt_id'] ?? null),
            'jenis_layanan_id' => $positive_review->jenis_layanan_id ?? ($positive_review->meta['jenis_layanan_id'] ?? null),
            'created_at' => optional($positive_review->created_at)->toDateTimeString(),
        ]);
    }

    /**
     * Helper: try to load UPT list via common model names.
     * If not found, return empty collection.
     */
    protected function getUpts()
    {
        // adjust model name if you use different one
        if (class_exists(Unit::class)) {
            return Unit::orderBy('name')->get();
        }
       
        // fallback: if you have a 'units' or 'upts' table but no model, try DB:
        if (Schema::hasTable('units')) {
            return DB::table('units')->orderBy('name')->get();
        }
        if (Schema::hasTable('upts')) {
            return DB::table('upts')->orderBy('name')->get();
        }

        return collect();
    }

    /**
     * Helper: try to load layanan list via common model name.
     */
    protected function getLayanans()
    {
        if (class_exists(JenisLayanan::class)) {
            return JenisLayanan::orderBy('nama')->get();
        }
        if (class_exists(JenisLayanan::class)) {
            return JenisLayanan::orderBy('name')->get();
        }
        if (Schema::hasTable('jenis_layanans')) {
            return DB::table('jenis_layanans')->orderBy('nama')->get();
        }
        return collect();
    }

}