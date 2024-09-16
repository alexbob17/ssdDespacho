<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Model' => 'App\Policies\AdminPolicy',

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Definir políticas de acceso
        Gate::define('view-users', function ($user) {
            return true; // Esto debería permitir que todos vean el elemento del menú.
        });

        Gate::define('admin', [AdminPolicy::class, 'admin']);

        
    }
}