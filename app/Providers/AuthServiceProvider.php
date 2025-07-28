<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Employee;
use Illuminate\Support\Facades\Gate;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
        {
        Gate::define('access-admin-panel', function (Employee $user) {
            // ここで上記で定義したisAdmin()メソッドを使っています。
            return $user->isAdmin();
        });
    }
    }
