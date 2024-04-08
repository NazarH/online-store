<?php

namespace App\Listeners;

use App\Notifications\ChangePasswordNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ChangePassword
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $event->user->notify(new ChangePasswordNotification($event->password));
    }
}
