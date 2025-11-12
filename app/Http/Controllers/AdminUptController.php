<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class AdminUptController extends Controller
{
 /** Ambil role_id untuk admin_upt (cache ringan di properti) */
    private int $adminRoleId;

    public function __construct()
    {
        $this->adminRoleId = (int) Role::where('name', 'admin_upt')->value('id');
    }
public function index(Request $request)
{
    $units = Unit::orderBy('name')->get();

    $query = User::with('unit')
        ->whereHas('role', fn($r) => $r->where('name','admin_upt'));

    if ($request->filled('q')) {
        $query->where(function ($q) use ($request) {
            $q->where('name','like','%'.$request->q.'%')
              ->orWhere('email','like','%'.$request->q.'%')
              ->orWhere('nip','like','%'.$request->q.'%');
        });
    }
    if ($request->filled('unit_id')) $query->where('unit_id', $request->unit_id);
    if ($request->filled('status'))  $query->where('is_active', $request->status === 'active');

    $users = $query->latest()->paginate(7);

    return view('kanwil.users.admin-upt', [
        'title' => 'Manajemen Pengguna — Admin UPT',
        'users' => $users,
        'units' => $units,
    ]);
}

public function create()
{
    $units = Unit::orderBy('name')->get(['id','name']);
    return view('kanwil.users.admin-upt-tambah', [
        'title' => 'Tambah Admin UPT',
        'units' => $units,
    ]);
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name'      => ['required','string','min:3','max:100'],
        'nip'       => ['required','regex:/^\d{8,18}$/','unique:users,nip'],
        'email'     => ['nullable','email','max:150', Rule::unique('users','email')->whereNotNull('email')],
        'unit_id'   => ['required', Rule::exists('units','id')],
        'password'  => ['required','string','min:8','confirmed'],
        'is_active' => ['nullable','boolean'],
    ]);

    $roleId = Role::where('name', 'admin_upt')->value('id');
    if (!$roleId) return back()->withErrors(['role'=>'Role admin_upt tidak ditemukan.']);

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
    ]);

    // Lebih sederhana: langsung ke index, biarkan SweetAlert di index membaca session('success').
    return redirect()
        ->route('kanwil.users.admin-upt.create') // kembali ke form Tambah
        ->with('success', 'Admin UPT berhasil ditambahkan.')
        ->with('auto_redirect', route('kanwil.users.admin-upt.index')); // target pindah
}

public function show(string $id)
{
    $user = User::with('unit:id,name')->where('role_id', $this->adminRoleId)->findOrFail($id);

    return view('kanwil.users.admin-upt-show', [
        'title' => 'Detail Admin UPT',
        'user'  => $user,
    ]);
}

public function edit(string $id)
{
    $user  = User::where('role_id', $this->adminRoleId)->findOrFail($id);
    $units = Unit::orderBy('name')->get(['id','name']);

    return view('kanwil.users.admin-upt-edit', [
        'title' => 'Edit Admin UPT',
        'user'  => $user,
        'units' => $units,
    ]);
}

public function update(Request $request, string $id)
{
    $user = User::where('role_id', $this->adminRoleId)->findOrFail($id);

    $data = $request->validate([
        'name'     => ['bail','required','string','max:255'],
        'email'    => ['nullable','email','max:255', Rule::unique('users','email')->ignore($user->id)->whereNotNull('email')],
        'nip'      => ['nullable','regex:/^\d{8,18}$/', Rule::unique('users','nip')->ignore($user->id)->whereNotNull('nip')],
        'unit_id'  => ['required','exists:units,id'],
        'is_active'=> ['required','boolean'],
        'password' => ['nullable','string','min:8','max:100'],
    ]);

    $payload = [
        'name'      => Str::squish($data['name']),
        'email'     => isset($data['email']) && trim($data['email']) !== '' ? Str::lower($data['email']) : null,
        'nip'       => isset($data['nip']) && trim($data['nip']) !== '' ? preg_replace('/\D/','',$data['nip']) : null,
        'unit_id'   => (int) $data['unit_id'],
        'is_active' => (bool) $data['is_active'],
    ];
    if (!empty($data['password'])) {
        $payload['password'] = Hash::make($data['password']);
    }

    $user->update($payload);

    return redirect()
        ->route('kanwil.users.admin-upt.edit',$user->id ) // kembali ke form Tambah
        ->with('success', 'Data Admin UPT berhasil diperbarui.')
        ->with('auto_redirect', route('kanwil.users.admin-upt.index')); // target pindah
}
 // app/Http/Controllers/AdminUptController.php
    public function nonaktif($id)
    {
        $unit = User::findOrFail($id);
        $unit->update(['is_active' => false]);
        return back()->with('success', "UPT {$unit->name} berhasil dinonaktifkan.");
    }

    public function aktifkan($id)
    {
        $unit = User::findOrFail($id);
        $unit->update(['is_active' => true]);
        return back()->with('success', "UPT {$unit->name} telah diaktifkan kembali.");
    }


}