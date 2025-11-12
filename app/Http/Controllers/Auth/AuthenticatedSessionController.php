<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
   public function store(LoginRequest $request): RedirectResponse
{
    // Validasi input dasar
    $request->validate([
        'nip'      => 'required|string',
        'password' => 'required|string',
    ]);

    // Cari user berdasarkan NIP + muat relasi unit
    $user = User::with('unit')->where('nip', $request->nip)->first();

    // Cek kredensial (NIP/password)
    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'nip' => __('NIP atau kata sandi salah.'),
        ]);
    }

    // Cek status user
    if (! $user->is_active) {
        throw ValidationException::withMessages([
            'nip' => __('Akun Anda nonaktif. Silakan hubungi admin.'),
        ]);
    }

    // Cek status UPT (jika wajib punya unit aktif)
    if (! $user->unit || ! $user->unit->is_active) {
        throw ValidationException::withMessages([
            'nip' => __('UPT Anda nonaktif. Silakan hubungi admin.'),
        ]);
    }

    // Lolos semua: login
    Auth::login($user, $request->boolean('remember'));
    $request->session()->regenerate();

    // Redirect per role
    $role = $user->role->name ?? '';
    return match ($role) {
        'admin_kanwil' => redirect()->intended('/kanwil/beranda'),
        'admin_upt'    => redirect()->intended('/upt/beranda'),
        'admin_layanan' => redirect()->intended('/layanan/beranda'),
        default        => redirect()->intended('/dashboard'),
    };
        $request->validate([
            'nip' => 'required|string',
            'password' => 'required|string',
        ]);

        // pakai nip, bukan email
        if (! Auth::attempt([
            'nip'      => $request->nip,
            'password' => $request->password,
            // opsional: batasi hanya user aktif
            // 'is_active' => 1,
        ], $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'nip' => __('NIP atau kata sandi salah.'),
            ]);
        }

        $request->session()->regenerate();

        // redirect per role (atau ke /beranda)
        $user = Auth::user();
        return match ($user->role->name ?? '') {
            'admin_kanwil' => redirect()->intended('/kanwil/beranda'),
            'admin_upt'    => redirect()->intended('/upt/beranda'),
            'user_layanan' => redirect()->intended('/beranda/layanan'),
            default        => redirect()->intended('/beranda'),
        };

    //     $request->session()->regenerate();
    //     $user = Auth::user();

    //     $request->authenticate();

    //     // $request->session()->regenerate();

    //     // return redirect()->intended(route('beranda', absolute: false));
        
    //     return match ($user->role->name ?? '') {
    //         'admin_kanwil' => redirect()->intended('/beranda/kanwil'),
    //         'admin_upt'    => redirect()->intended('/beranda/upt'),
    //         'user_layanan' => redirect()->intended('/beranda/layanan'),
    //         default        => redirect()->intended('/beranda'),
    //     };
     
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
