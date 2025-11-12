<?php
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    // Beranda umum (default fallback)
    Route::view('/beranda', 'beranda')->name('beranda');

    // Admin Kanwil
    // Route::prefix('beranda/kanwil')->middleware('can:kanwil-only')->group(function () {
    //     Route::view('/', 'beranda.kanwil')->name('beranda.kanwil');
    //     Route::view('/users', 'beranda.kanwil-users')->name('kanwil.users');
    //     Route::view('/laporan', 'beranda.kanwil-laporan')->name('kanwil.laporan');
    // });

    // Admin UPT
    // Route::prefix('beranda/upt')->middleware('can:upt-or-kanwil')->group(function () {
    //     Route::view('/', 'beranda.upt')->name('beranda.upt');
    //     Route::view('/pengaduan', 'beranda.upt-pengaduan')->name('upt.pengaduan');
    //     Route::view('/users', 'beranda.upt-users')->name('upt.users');
    // });

    // User Layanan
    // Route::prefix('beranda/layanan')->middleware('can:layanan-or-upt-or-kanwil')->group(function () {
    //     Route::view('/', 'beranda.layanan')->name('beranda.layanan');
    //     Route::view('/tiket', 'beranda.layanan-tiket')->name('layanan.tiket');
    // });

});
