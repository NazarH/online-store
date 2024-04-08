<?php

namespace App\Listeners;

use App\Events\ConfirmOrder;
use App\Notifications\ConfirmOrderClientNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ConfirmOrderClient
{
    /**
     * Handle the event.
     */
    public function handle(ConfirmOrder $event): void
    {
        $event->user->notify(new ConfirmOrderClientNotification());
    }
}
