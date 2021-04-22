<?php

namespace Feedback\Providers;

use Feedback\Events\FeedbackCreatedEvent;
use Feedback\Listeners\FeedbackCreatedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Route;

class FeedbackServiceProvider extends ServiceProvider
{

    protected $listen = [
        FeedbackCreatedEvent::class => [
            FeedbackCreatedListener::class,
        ]
    ];

    public function boot()
    {

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations/');
        Route::middleware('web')->group(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'feedback');

        $this->mergeConfigFrom(__DIR__ . '/../config/menu.php', 'admin.menu_aside');
    }
}
