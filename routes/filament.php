<?php

use Illuminate\Support\Facades\Route;
// use Filament\Http\Livewire\Auth\Login;
use Filament\Http\Livewire\Dashboard; // Asegúrate de que esta clase exista

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [Login::class, 'render'])->name('dashboard');
        // Otras rutas de Filament...
    });
