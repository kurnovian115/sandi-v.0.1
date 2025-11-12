<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\KategoriPengaduan;

class KategoriPengaduanController extends Controller
{
   public function index(Request $request)
    {
        $q = $request->input('q');
        $is_active = $request->input('is_active');

        $query = KategoriPengaduan::query();

        if ($q) {
            $query->where(function($x) use ($q){
                $x->where('nama', 'like', "%{$q}%")
                  ->orWhere('kode', 'like', "%{$q}%");
            });
        }

        if (!is_null($is_active) && $is_active !== '') {
            $query->where('is_active', $is_active == '1' ? 1 : 0);
        }

        $list = $query->orderBy('nama')->paginate(12)->withQueryString();

        return view('kategori-pengaduan.index', [
            'title' => 'Kategori Pengaduan',
            'list' => $list,
        ]);
    }

    public function create()
    {
        $kategori = new KategoriPengaduan();
        return view('kategori-pengaduan.tambah', compact('kategori'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'nama' => ['required','string','max:150','unique:kategori_pengaduan,nama'],
            'kode' => ['nullable','string','max:50'],
            'deskripsi' => ['nullable','string','max:1000'],
            'is_active' => ['nullable','boolean'],
        ]);
        $data['is_active'] = $r->boolean('is_active');

        KategoriPengaduan::create($data);

        return redirect()->route('kategori-pengaduan.index')->with('ok','Kategori ditambahkan');
    }

    public function edit($id)
    {
        $kategori = KategoriPengaduan::findOrFail($id);
        return view('kategori-pengaduan.edit', compact('kategori'));
    }

    public function update($id, Request $r)
    {
        $kategori = KategoriPengaduan::findOrFail($id);

        $data = $r->validate([
            'nama' => ['required','string','max:150', Rule::unique('kategori_pengaduan','nama')->ignore($kategori->id)],
            'kode' => ['nullable','string','max:50'],
            'deskripsi' => ['nullable','string','max:1000'],
            'is_active' => ['nullable','boolean'],
        ]);
        $data['is_active'] = $r->boolean('is_active');

        $kategori->update($data);

        return redirect()->route('kategori-pengaduan.index')->with('ok','Kategori diperbarui');
    }

    public function destroy($id)
    {
        $kategori = KategoriPengaduan::findOrFail($id);

        // Jika kamu punya relasi complaints() pakai ini agar tidak delete jika dipakai
        if (method_exists($kategori, 'complaints') && $kategori->complaints()->exists()) {
            return back()->with('err','Kategori tidak bisa dihapus karena sudah digunakan di pengaduan.');
        }

        $kategori->delete();

        return back()->with('ok','Kategori dihapus');
    }

    public function toggle($id)
    {
        $kategori = KategoriPengaduan::findOrFail($id);
        $kategori->is_active = ! $kategori->is_active;
        $kategori->save();
        return back()->with('ok','Status kategori diperbarui');
    }
}
