<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         Model::preventLazyLoading(false);
        // Gate::define('kanwil-only', fn($user) => optional($user->role)->name === 'admin_kanwil');
         // Kanwil saja
    Gate::define('kanwil-only', function (User $user) {
        return ($user->role->name ?? null) === 'admin_kanwil';
    });

    Gate::define('upt-only', function (User $user) {
        return ($user->role->name ?? null) === 'admin_upt';
    });

    // UPT atau Kanwil
    Gate::define('upt-or-kanwil', function (User $user) {
        return in_array($user->role->name ?? null, ['admin_upt', 'admin_kanwil'], true);
    });

    // Layanan atau UPT atau Kanwil
    Gate::define('layanan-or-upt-or-kanwil', function (User $user) {
        return in_array($user->role->name ?? null, ['admin_layanan', 'admin_upt', 'admin_kanwil'], true);
    });

    }
}
