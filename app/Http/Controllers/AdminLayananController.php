<?php

namespace App\Http\Controllers;
use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminLayananController extends Controller
{
  /** Ambil role_id untuk admin-layanan (cache ringan di properti) */
    private int $adminRoleId;

    public function __construct()
    {
        $this->adminRoleId = (int) Role::where('name', 'admin_layanan')->value('id');
    }
// public function index(Request $request)
// {
//     $units = Unit::orderBy('name')->get();

//     $query = User::with('unit')
//         ->whereHas('role', fn($r) => $r->where('name','admin_layanan'));

//     if ($request->filled('q')) {
//         $query->where(function ($q) use ($request) {
//             $q->where('name','like','%'.$request->q.'%')
//             ->orWhere('email','like','%'.$request->q.'%')
//             ->orWhere('nip','like','%'.$request->q.'%');
//         });
//     }
//     if ($request->filled('unit_id')) $query->where('unit_id', $request->unit_id);
//     if ($request->filled('status'))  $query->where('is_active', $request->status === 'active');

//     $users = $query->latest()->paginate(7);

//     return view('admin-layanan.index', [
//         'title' => 'Manajemen Pengguna — Admin Layanan',
//         'users' => $users,
//         'units' => $units,
//     ]);
// }

    public function index(Request $request)
    {
        $auth = Auth::user();

        // Default: ambil semua unit
        $isUpt = false;
        $userUnitId = null;

        if ($auth) {
            // jika role relationship ada, cek nama role. 
            // sesuaikan 'admin_upt' dengan nama role yang kalian pakai
            $roleName = optional($auth->role)->name;

            if ($roleName === 'admin_upt') {
                $isUpt = true;
                $userUnitId = (int) $auth->unit_id;
                // units hanya berisi unit milik user (array koleksi 1)
                $units = Unit::where('id', $userUnitId)->orderBy('name')->get();
            } else {
                // non-upt (kanwil / superadmin) => semua unit
                $units = Unit::orderBy('name')->get();
            }
        } else {
            // fallback: kalau belum login (seharusnya tidak terjadi), tetap semua unit
            $units = Unit::orderBy('name')->get();
        }

        // Query user: hanya admin_layanan (sebelumnya)
        $query = User::with('unit')
            ->whereHas('role', fn($r) => $r->where('name','admin_layanan'));

        // Jika yang login adalah admin UPT, batasi data users ke unit miliknya
        if ($isUpt && $userUnitId) {
            $query->where('unit_id', $userUnitId);
        } else {
            // hanya terapkan filter unit_id dari request jika bukan admin UPT
            if ($request->filled('unit_id')) {
                $query->where('unit_id', $request->unit_id);
            }
        }

        // Pencarian teks tetap berlaku
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('name','like','%'.$request->q.'%')
                ->orWhere('email','like','%'.$request->q.'%')
                ->orWhere('nip','like','%'.$request->q.'%');
            });
        }

        // Status filter (active/inactive)
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $users = $query->latest()->paginate(7)->withQueryString();

        return view('admin-layanan.index', [
            'title' => 'Manajemen Pengguna — Admin Layanan',
            'users' => $users,
            'units' => $units,
            'isUpt' => $isUpt,
            'userUnitId' => $userUnitId,
        ]);
    }

    public function create()
    {
        $user = Auth::user();

       $roleName = optional($user->role)->name; // sesuaikan dengan relasi dan nama role Anda

        if ($roleName === 'admin_upt') {
            // User adalah admin UPT → tampilkan hanya unit miliknya
            $unit = Unit::find($user->unit_id);
            $units = $unit ? collect([$unit]) : collect([]);
            $lockedUnit = $user->unit_id;
        } else {
            // User bukan admin UPT → tampilkan semua unit
            $units = Unit::orderBy('name')->get(['id','name']);
            $lockedUnit = null;
        }


        $layanans = JenisLayanan::orderBy('nama')->get(['id','nama']);

        return view('admin-layanan.tambah', [
            'title' => 'Tambah Admin Layanan',
            'units' => $units,
            'layanans' => $layanans,
            'lockedUnit' => $lockedUnit,
        ]);
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'name'      => ['required','string','min:3','max:100'],
        'nip'       => ['required','regex:/^\d{8,18}$/','unique:users,nip', 'min:18', 'max:18'],
        'email'     => ['nullable','email','max:150', Rule::unique('users','email')->whereNotNull('email')],
        'unit_id'   => ['required', Rule::exists('units','id')],
        'password'  => ['required','string','min:8','confirmed'],
        'is_active' => ['nullable','boolean'],
        'layanan_id' => ['required',Rule::exists('jenis_layanan','id')],
    ]);

    // Cek duplikat: apakah sudah ada user lain di unit yang sama dengan layanan yg dipilih?
    $exists = User::where('unit_id', $validated['unit_id'])
                ->where('layanan_id', $validated['layanan_id'])
                ->exists();

    if ($exists) {
        return back()
            ->withInput()
            ->withErrors(['layanan_id' => 'Di unit ini sudah ada admin untuk layanan yang dipilih.']);
    }

    $roleId = Role::where('name', 'admin_layanan')->value('id');
    if (!$roleId) return back()->withErrors(['role'=>'Role admin layanan tidak ditemukan.']);

    $nip   = preg_replace('/\D/', '', $validated['nip']);
    $name  = Str::squish($validated['name']);
    $email = isset($validated['email']) && trim($validated['email']) !== '' ? Str::lower($validated['email']) : null;

    $user = User::create([
        'name'      => $name,
        'email'     => $email,        // bisa null
        'nip'       => $nip,
        'unit_id'   => (int) $validated['unit_id'],
        'role_id'   => (int) $roleId,
        'is_active' => (bool) ($validated['is_active'] ?? 1),
        'password'  => Hash::make($validated['password']),
        'layanan_id' => (int) $validated['layanan_id'],

    ]);

    // Lebih sederhana: langsung ke index, biarkan SweetAlert di index membaca session('success').
    return redirect()
        ->route('admin-layanan.create') // kembali ke form Tambah
        ->with('success', 'Admin Layanan berhasil ditambahkan.')
        ->with('auto_redirect', route('admin-layanan.index')); // target pindah
}

public function show(string $id)
{
    $user = User::with('unit:id,name')->where('role_id', $this->adminRoleId)->findOrFail($id);

    return view('admin-layanan.index', [
        'title' => 'Detail Admin Layanan',
        'user'  => $user,
    ]);
}

public function edit(string $id)
{
    $user  = User::where('role_id', $this->adminRoleId)->findOrFail($id);
    $units = Unit::orderBy('name')->get(['id','name']);
    $layanans = JenisLayanan::orderBy('nama')->get(['id','nama']);

    return view('admin-layanan.edit', [
        'title' => 'Edit Admin Layanan',
        'user'  => $user,
        'units' => $units,
        'layanans' => $layanans,
    ]);
}

public function update(Request $request, string $id)
{
    $user = User::where('role_id', $this->adminRoleId)->findOrFail($id);

    $data = $request->validate([
        'name'     => ['bail','required','string','max:255'],
        'email'    => ['nullable','email','max:255', Rule::unique('users','email')->ignore($user->id)->whereNotNull('email')],
        'nip'      => ['nullable','regex:/^\d{8,18}$/', 'min:18', 'max:18', Rule::unique('users','nip')->ignore($user->id)->whereNotNull('nip')],
        'unit_id'  => ['required','exists:units,id'],
        'is_active'=> ['required','boolean'],
        'password' => ['nullable','string','min:8','max:100'],
        'layanan_id' => ['required',Rule::exists('jenis_layanan','id')],        
    ]);

    $payload = [
        'name'      => Str::squish($data['name']),
        'email'     => isset($data['email']) && trim($data['email']) !== '' ? Str::lower($data['email']) : null,
        'nip'       => isset($data['nip']) && trim($data['nip']) !== '' ? preg_replace('/\D/','',$data['nip']) : null,
        'unit_id'   => (int) $data['unit_id'],
        'is_active' => (bool) $data['is_active'],
        'layanan_id'=> (int) $data['layanan_id'],
    ];
    if (!empty($data['password'])) {
        $payload['password'] = Hash::make($data['password']);
    }

    $user->update($payload);

     return redirect()
        ->route('admin-layanan.edit', $user->id) // tetap di halaman edit
        ->with('success', 'admin Layanan berhasil diperbarui.')
        ->with('auto_redirect', route('admin-layanan.index')); // target pindah

    // return redirect()
    //     ->route('admin-layanan.index')
    //     ->with('success', 'Data Admin Layanan berhasil diperbarui.');
}
 // app/Http/Controllers/AdminUptController.php
    public function nonaktif($id)
    {
        $unit = User::findOrFail($id);
        $unit->update(['is_active' => false]);
        return back()->with('success', "Admin Layanan {$unit->name} berhasil dinonaktifkan.");
    }

    public function aktifkan($id)
    {
        $unit = User::findOrFail($id);
        $unit->update(['is_active' => true]);
        return back()->with('success', "Admin Layanan {$unit->name} telah diaktifkan kembali.");
    }

}
