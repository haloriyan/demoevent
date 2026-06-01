<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Mail\Events\MessageSending;

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
        Event::listen(MessageSending::class, function (MessageSending $event) {
            $emailLog = config('mail.email_log');
            if ($emailLog) {
                $event->message->bcc($emailLog);
            }
        });
    }
}
