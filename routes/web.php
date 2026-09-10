<?php

use App\Http\Controllers\Admin\CategorieController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DemandePortraitController;
use App\Http\Controllers\Admin\PortraitController;
use App\Http\Controllers\Admin\ReseauSocialController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('portraits', PortraitController::class)->names('admin.portraits');
    Route::resource('categories', CategorieController::class)
        ->parameters(['categories' => 'categorie'])
        ->names('admin.categories');
    Route::resource('reseaux', ReseauSocialController::class)
        ->parameters(['reseaux' => 'reseau'])
        ->names('admin.reseaux');
    Route::get('/demandes', [DemandePortraitController::class, 'index'])->name('admin.demandes.index');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
