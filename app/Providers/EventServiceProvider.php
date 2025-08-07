<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Login;
use App\Listeners\LogSuccessfulLogin;

class EventServiceProvider extends ServiceProvider
{
    /**
     * イベントとリスナーのマッピング
     */
    protected $listen = [
        Login::class => [
            LogSuccessfulLogin::class,
        ],
    ];

    /**
     * アプリケーションイベントの登録
     */
    public function boot(): void
    {
        parent::boot();
    }
}
