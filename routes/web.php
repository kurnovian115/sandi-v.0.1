<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UptController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminUptController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\BerandaUptController;
use App\Http\Controllers\AdminLayananController;
use App\Http\Controllers\JenisLayananController;
use App\Http\Controllers\UptPengaduanController;
use App\Http\Controllers\PengaduanEkstController;
use App\Http\Controllers\UPT\DisposisiController;
use App\Http\Controllers\PengaduanMasukController;
use App\Http\Controllers\KanwilPengaduanController;
use App\Http\Controllers\PengaduanPublicController;
use App\Http\Controllers\LayananDashboardController;
use App\Http\Controllers\PengaduanLayananController;
use App\Http\Controllers\KategoriPengaduanController;
use App\Http\Controllers\PengaduanEksternalController;

require __DIR__.'/beranda.php';

Route::prefix('pengaduan')
    ->name('pengaduan.')
    // ->middleware(['auth','can:upt-or-kanwil'])
    ->group(function () {
        Route::get('/tambah', [PengaduanController::class, 'create'])->name('create');
        Route::post('/tambah', [PengaduanController::class, 'store'])->name('store');
        Route::get('/track', [PengaduanController::class, 'track'])->name('track');
  });

Route::get('/', function () {
    return view('page.index');
});

//Admin kanwil
Route::middleware(['auth'])->group(function () {
        Route::prefix('layanan/beranda')->middleware('can:layanan-or-upt-or-kanwil')->group(function () {
        // Route::get('/', fn() => view('kanwil.beranda.index', ['title' => 'Beranda Kanwil']))->name('kanwil.beranda');
        Route::get('/', [LayananDashboardController::class, 'index'])->name('index');
    });

    Route::prefix('layanan/pengaduan/inbox')
        ->name('layanan.pengaduan.inbox.')
        ->middleware('can:layanan-or-upt-or-kanwil')
        ->group(function () {
            Route::get('/', [PengaduanMasukController::class, 'index'])->name('index');  
            Route::post('/{pengaduan}/jawab', [PengaduanMasukController::class, 'jawab'])->name('jawab');
            Route::get('/{pengaduan}', [PengaduanMasukController::class, 'show'])->name('show');
    });

    Route::prefix('layanan/pengaduan')
        ->name('layanan.pengaduan.')
        ->middleware('can:layanan-or-upt-or-kanwil')
        ->group(function () {
            Route::get('/', [PengaduanLayananController::class, 'index'])->name('index');  
            Route::get('/{pengaduan}', [PengaduanLayananController::class, 'show'])->name('show');  
    });

    //   Route::prefix('kanwil/beranda')->middleware('can:kanwil-only')->group(function () {
    //     // Route::get('/', fn() => view('kanwil.beranda.index', ['title' => 'Beranda Kanwil']))->name('kanwil.beranda');
    //      Route::get('/', [DashboardController::class, 'index'])->name('index');
    // });

    Route::prefix('kanwil/beranda')->middleware('can:kanwil-only')->group(function () {
        // Route::get('/', fn() => view('kanwil.beranda.index', ['title' => 'Beranda Kanwil']))->name('kanwil.beranda');
         Route::get('/', [DashboardController::class, 'index'])->name('index');
    });

      Route::prefix('kanwil/monitoring')
      -> name('kanwil.monitoring.')
      -> middleware('can:kanwil-only')->group(function () {
        // Route::get('/', fn() => view('kanwil.beranda.index', ['title' => 'Beranda Kanwil']))->name('kanwil.beranda');
         Route::get('/', [KanwilPengaduanController::class, 'index'])->name('index');
    });



    Route::prefix('kanwil/upt')
    ->name('kanwil.upt.')                 // <-- TAMBAH INI
    ->middleware(['auth','can:kanwil-only'])
    ->group(function () {
        Route::get('/',       [UptController::class, 'index'])->name('index');
        Route::get('/tambah', [UptController::class, 'create'])->name('create');
        Route::post('/tambah',[UptController::class, 'store'])->name('store');
        Route::get('/{id}', [UptController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [UptController::class, 'edit'])->name('edit');
        Route::put('/{id}',       [UptController::class, 'update'])->name('update');
        Route::put('{id}/nonaktif', [UptController::class, 'nonaktif'])->name('nonaktif');
        Route::put('{id}/aktifkan', [UptController::class, 'aktifkan'])->name('aktifkan');
    });

    Route::prefix('kanwil/users/admin-upt')
    ->name('kanwil.users.admin-upt.')                 // <-- TAMBAH INI
    ->middleware(['auth','can:kanwil-only'])
    ->group(function () {
        Route::get('/',              [AdminUptController::class, 'index'])->name('index');
        Route::get('/tambah',        [AdminUptController::class, 'create'])->name('create'); // jika butuh halaman sendiri
        Route::post('/tambah',        [AdminUptController::class, 'store'])->name('store');
        Route::get('/{id}',          [AdminUptController::class, 'show'])->name('show');     // opsional
        Route::get('/{id}/edit',     [AdminUptController::class, 'edit'])->name('edit');
        Route::put('/{id}',          [AdminUptController::class, 'update'])->name('update');
        Route::put('/{id}/nonaktif', [AdminUptController::class, 'nonaktif'])->name('nonaktif');
        Route::put('/{id}/aktifkan', [AdminUptController::class, 'aktifkan'])->name('aktifkan');
    });

    Route::prefix('jenis-layanan')
    ->name('jenis-layanan.')                 // <-- TAMBAH INI
    ->middleware(['auth','can:upt-or-kanwil'])
    ->group(function () {
        Route::get('/', [JenisLayananController::class, 'index'])->name('index');
        Route::get('/tambah', [JenisLayananController::class, 'create'])->name('create');
        Route::post('/tambah', [JenisLayananController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [JenisLayananController::class, 'edit'])->name('edit');
        Route::put('/{id}', [JenisLayananController::class, 'update'])->name('update');
        Route::delete('/{id}', [JenisLayananController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/nonaktif', [JenisLayananController::class, 'nonaktif'])->name('nonaktif');
        Route::put('/{id}/aktifkan', [JenisLayananController::class, 'aktifkan'])->name('aktifkan');
    });

    Route::prefix('kategori-pengaduan')
    ->name('kategori-pengaduan.')
    ->middleware(['auth','can:upt-or-kanwil'])   // sesuaikan
    ->group(function () {
        Route::get('/', [KategoriPengaduanController::class,'index'])->name('index');
        Route::get('/tambah', [KategoriPengaduanController::class,'create'])->name('tambah');
        Route::post('/tambah', [KategoriPengaduanController::class,'store'])->name('store');
        Route::get('/{id}/edit', [KategoriPengaduanController::class,'edit'])->name('edit');
        Route::put('/{id}', [KategoriPengaduanController::class,'update'])->name('update');
        Route::delete('/{id}', [KategoriPengaduanController::class,'destroy'])->name('destroy');
        Route::patch('/{id}/toggle', [KategoriPengaduanController::class,'toggle'])->name('toggle');
    });

   // admin UPT
    Route::prefix('upt/beranda')
        ->name('upt.beranda.')
        ->middleware('can:upt-only')
        ->group(function () {
            Route::get('/', [BerandaUptController::class, 'index'])->name('index');
        });

        Route::prefix('upt/disposisi')
        ->name('upt.disposisi.')
        ->middleware('can:upt-only')
        ->group(function () {
            Route::get('/', [DisposisiController::class, 'index'])->name('index');
            Route::post('/{pengaduan}', [DisposisiController::class, 'store'])->name('store'); // disposisi ke user_layanan
            Route::post('/{pengaduan}/recall', [DisposisiController::class, 'recall'])->name('recall'); // tarik kembali
            Route::post('/{pengaduan}/jawab', [DisposisiController::class, 'jawab'])->name('jawab'); // jawab & tutup
            Route::get('/{pengaduan}', [DisposisiController::class, 'show'])->name('show');
        });
    });
  

 Route::prefix('admin-layanan')
    ->name('admin-layanan.')                 // <-- TAMBAH INI
    ->middleware(['auth','can:upt-or-kanwil'])
    ->group(function () {
        Route::get('/',              [AdminLayananController::class, 'index'])->name('index');
        Route::get('/tambah',        [AdminLayananController::class, 'create'])->name('create'); // jika butuh halaman sendiri
        Route::post('/tambah',        [AdminLayananController::class, 'store'])->name('store');
        Route::get('/{id}',          [AdminLayananController::class, 'show'])->name('show');     // opsional
        Route::get('/{id}/edit',     [AdminLayananController::class, 'edit'])->name('edit');
        Route::put('/{id}',          [AdminLayananController::class, 'update'])->name('update');
        Route::put('/{id}/nonaktif', [AdminLayananController::class, 'nonaktif'])->name('nonaktif');
        Route::put('/{id}/aktifkan', [AdminLayananController::class, 'aktifkan'])->name('aktifkan');
    });

      Route::prefix('pengaduan.eksternal')
    ->name('pengaduan.eksternal.')
    ->middleware(['auth','can:upt-or-kanwil'])
    ->group(function () {
        Route::get('/tambah', [PengaduanEksternalController::class, 'create'])->name('create');
        Route::post('/', [PengaduanEksternalController::class, 'store'])->name('store');

    });

    Route::prefix('pengaduan')
    ->name('pengaduan.')
    ->middleware(['auth','can:upt-or-kanwil'])
    ->group(function () {
        Route::get('/', [PengaduanController::class, 'index'])->name('index');
        Route::get('/upt', [PengaduanController::class, 'upt'])->name('upt');
        Route::get('/{id}', [PengaduanController::class, 'show'])->name('show');
        // Route::get('/tambah', [PengaduanController::class, 'create'])->name('create');
        // Route::post('/tambah', [PengaduanController::class, 'store'])->name('store');
        // Route::get('/track', [PengaduanController::class, 'track'])->name('track');
  });

 
Route::get('lang/{locale}', function ($locale) {
    if (! in_array($locale, ['id', 'en'])) {
        abort(400);
    }
    Session::put('locale', $locale);
    App::setLocale($locale);
    // Redirect kembali ke halaman sebelumnya
    return redirect()->back();
})->name('lang.switch');

 Route::get('/dashboard', function () {

    $user = Auth::user();

    return match ($user->role->name ?? '') {
        'admin_kanwil'   => redirect('/kanwil/beranda'),
        'admin_upt'      => redirect('/upt/beranda'),
        'admin_layanan'  => redirect('/layanan/beranda'),
    };
    
})->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });



require __DIR__.'/auth.php';
