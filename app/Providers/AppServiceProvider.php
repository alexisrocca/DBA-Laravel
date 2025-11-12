<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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
        // Permitir que cualquier usuario autenticado acceda a Filament
        // Filament por defecto puede usar una Gate llamada 'viewFilament' o similar.
        // Definimos una Gate segura que permite el acceso a usuarios autenticados.
        Gate::define('viewFilament', fn (?User $user): bool => (bool) $user);
    }
}
