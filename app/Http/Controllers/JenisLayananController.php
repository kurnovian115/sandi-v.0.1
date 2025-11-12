<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JenisLayananController extends Controller
{
    public function index(Request $request) {

        $q     = $request->input('q');
        $status = $request->status;

        $query = JenisLayanan::query();

        // pencarian nama atau kode
        if ($q) {
            $query->where(function ($x) use ($q) {
                $x->where('nama', 'like', "%{$q}%")
                ->orWhere('kode', 'like', "%{$q}%");
            });
        }

        // filter status: pastikan kolom di DB adalah 'aktif' (boolean)
        
        if ($status)  $query->where('is_active', $status === 'active');

        $list = $query->oldest()->paginate(5)->withQueryString();

        return view('jenis-layanan.index', [
            'title' => 'Data Jenis Layanan',
            'list'  => $list,
        ]);
    }

    public function create() {
        $layanan = new JenisLayanan();
        return view('jenis-layanan.tambah', compact('layanan'));
    }

    public function store(Request $r) {
        $data = $r->validate([
            'nama' => ['required','string','max:150','unique:jenis_layanan,nama'],
            'kode' => ['nullable','string','max:50'],
            'deskripsi' => ['nullable','string','max:1000'],
            'is_active' => ['nullable','boolean'],
        ], [
            'nama.required' => 'Nama Layanan wajib diisi.',
            'name.max'      => 'Nama Layanan maksimal 150 karakter.',
            'is_active.required' => 'Pilih status aktif atau nonaktif.',
        ]);
        $data['aktif'] = $r->boolean('aktif');
        JenisLayanan::create($data);

        return redirect()
        ->route('jenis-layanan.index')
        ->with('ok','Layanan ditambahkan')
        ->with('success', 'Jenis Layanan berhasil ditambahkan.')
        ->with('auto_redirect', route('jenis-layanan.index'));
    }

    public function edit($id) {
        $l = JenisLayanan::findOrFail($id);
        // return view('jenis-layanan.edit', compact('list'));

        return view('jenis-layanan.edit', [
            'title' => 'Edit Layanan',
            'l'  => $l,
        ]);
    }

    public function update($id, Request $r) {
        $layanan = JenisLayanan::findOrFail($id);
        $data = $r->validate([
            'nama' => ['required','string','max:150', Rule::unique('jenis_layanan','nama')->ignore($layanan->id)],
            'kode' => ['nullable','string','max:50'],
            'deskripsi' => ['nullable','string','max:1000'],
            'is_active' => ['nullable','boolean'],
        ]);
        $data['is_active'] = $r->boolean('is_active');
        $layanan->update($data);
    //    return redirect()->route('jenis-layanan.edit', $id)->with('ok','Layanan diperbarui');

       return redirect()
        ->route('jenis-layanan.edit', $layanan->id) // tetap di halaman edit
        ->with('success', 'Jenis Layanan berhasil diperbarui.')
        ->with('auto_redirect', route('jenis-layanan.index')); // target pindah
    }

    // public function destroy($id) {
    //     $layanan = JenisLayanan::findOrFail($id);
    //     // opsional: cegah hapus jika dipakai complaint
    //     if (method_exists($layanan, 'complaints') && $layanan->complaints()->exists()) {
    //         return back()->with('err','Tidak bisa dihapus karena sudah dipakai di pengaduan');
    //     }
    //     $layanan->delete();
    //     return back()->with('ok','Layanan dihapus');
    // }

    // app/Http/Controllers/AdminUptController.php
    public function nonaktif($id)
    {
        $list = JenisLayanan::findOrFail($id);
        $list->update(['is_active' => false]);
        return back()->with('success', "{$list->nama} berhasil dinonaktifkan.");
    }

    public function aktifkan($id)
    {
        $list = JenisLayanan::findOrFail($id);
        $list->update(['is_active' => true]);
        return back()->with('success', "{$list->nama} telah diaktifkan kembali.");
    }
}
