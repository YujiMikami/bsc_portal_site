<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\TransportationExpense;
use App\Models\PaidRequest;
use App\Models\EmployeeAccount;
use App\Models\Safety;
use App\Policies\TransportationExpensePolicy;
use App\Policies\PaidRequestPolicy;
use App\Policies\SafetyPolicy;
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

    protected $policies = [
        TransportationExpense::class => TransportationExpensePolicy::class,
        PaidRequest::class => PaidRequestPolicy::class,
        Safety::class => SafetyPolicy::class,
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
        {
        Gate::define('access-admin-panel', function (EmployeeAccount $user) {
            // ここで上記で定義したisAdmin()メソッドを使っています。
            return $user->isAdmin();
        });
    }
    }
