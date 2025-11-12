<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q      = $request->q;
        $status = $request->status;

        $query = Unit::query();

        if ($q) {
            $query->where(fn($x)=>$x->where('name','like',"%{$q}%"));
        }
        if ($status)  $query->where('is_active', $status === 'active');

        $query->withCount(['users as admins_count' => function($u){
            $u->whereHas('role', fn($r)=>$r->where('name','admin_upt'));
        }]);

       $upts = $query->oldest()
              ->paginate(7)
              ->withQueryString();

        return view('kanwil.data-upt.upt', [
            'title' => 'Data UPT',
            'upts'  => $upts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kanwil.data-upt.upt-tambah', [
        'title' => 'Tambah UPT',
    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validated = $request->validate([
        'name'      => ['required', 'string', 'max:255'],
        'address'   => ['nullable', 'string', 'max:500'],
        'is_active' => ['required', 'boolean'],
    ], [
        'name.required' => 'Nama UPT wajib diisi.',
        'name.max'      => 'Nama UPT maksimal 255 karakter.',
        'is_active.required' => 'Pilih status aktif atau nonaktif.',
    ]);

    Unit::create($validated);

    return redirect()
        ->route('kanwil.upt.index')
        ->with('success', 'Data UPT berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
          $unit = Unit::with([
        'adminUsers' => fn($q) => $q->select('id','name','email','nip','unit_id','role_id')
    ])->findOrFail($id);

    return view('kanwil.data-upt.upt-detail', [
        'title' => 'Detail UPT',
        'unit'  => $unit,
    ]);
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $unit = Unit::findOrFail($id);

    return view('kanwil.data-upt.upt-edit', [
        'title' => 'Edit UPT',
        'unit'  => $unit,
    ]);
    }

    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       $unit = Unit::findOrFail($id);

    $unit = Unit::findOrFail($id);

    $data = $request->validate(
        [
            'name'      => ['bail','required','string','max:255'],
            'address'   => ['nullable','string','max:500'],
            'is_active' => ['required','boolean'],
        ],
        [
            'name.required' => 'Nama UPT wajib diisi.',
            'name.max'      => 'Nama UPT maksimal 255 karakter.',
            'address.max'   => 'Alamat maksimal 500 karakter.',
            'is_active.required' => 'Pilih status aktif/nonaktif.',
        ]
    );

    $unit->update($data);

    return redirect()
        ->route('kanwil.upt.edit', $unit->id) // tetap di halaman edit
        ->with('success', 'Data UPT berhasil diperbarui.')
        ->with('auto_redirect', route('kanwil.upt.index')); // target pindah
    }

    /**
     * Remove the specified resource from storage.
     */

    public function nonaktif($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->update(['is_active' => false]);
        return back()->with('success', "UPT {$unit->name} berhasil dinonaktifkan.");
    }

    public function aktifkan($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->update(['is_active' => true]);
        return back()->with('success', "UPT {$unit->name} telah diaktifkan kembali.");
    }


    public function destroy(string $id)
    {
        //
    }
}
