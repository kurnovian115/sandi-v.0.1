<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $units = Unit::where('is_active', true)->orderBy('name')->get(['id','name']);
        return view('auth.register', compact('units'));
        // return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nip' =>['required', 'digits:18', 'unique:'.User::class],
            'email' => [ 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'unit_id'  => ['required', 'exists:units,id'],
        ]);

        $roleId = Role::where('name','admin_upt')->value('id');
        $user = User::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id'  => $roleId,
            'unit_id'  => $request->unit_id,
            'is_active' => true,
        ]);

        // event(new Registered($user));

        // Auth::login($user);

         return redirect()->route('register')   // atau ke beranda kanwil: route('beranda.kanwil')
        ->with('success', 'Admin UPT berhasil ditambahkan.');
    }
}
