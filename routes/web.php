<?php

use App\Http\Controllers\Admin\CategorieController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DemandePortraitController;
use App\Http\Controllers\Admin\PortraitController;
use App\Http\Controllers\Admin\ReseauSocialController;
use App\Http\Controllers\AProposController;
use App\Http\Controllers\DemandePortraitController as PublicDemandePortraitController;
use App\Http\Controllers\GalerieController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TemoignageController;
use App\Models\Admin;
use App\Models\Portrait;
use App\Models\ReseauSocial;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', [
        'admin' => Admin::with('user')->first(),
        'portraits' => Portrait::with('categorie')->latest('date_realisation')->take(8)->get(),
        'reseaux' => ReseauSocial::query()->where('actif', true)->orderBy('nom')->get(),
    ]);
})->name('welcome');
Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
Route::get('/cv-abloart', [ProfileController::class, 'downloadCv'])->name('profile.cv');
Route::get('/galerie', [GalerieController::class, 'index'])->name('galerie.index');
Route::get('/demande-portrait', [PublicDemandePortraitController::class, 'create'])->name('demandes.create');
Route::post('/demande-portrait', [PublicDemandePortraitController::class, 'store'])->name('demandes.store');
Route::get('/temoignages', [TemoignageController::class, 'index'])->name('temoignages.index');
Route::post('/temoignages', [TemoignageController::class, 'store'])->name('temoignages.store');
Route::get('/a-propos', [AProposController::class, 'index'])->name('a-propos.index');
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
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.destroy');
    Route::delete('/profile/cv', [ProfileController::class, 'deleteCv'])->name('profile.cv.destroy');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
