<?php

namespace App\Listeners;

use App\Events\NewUserRegistered;
use App\Mail\NewUserNotify;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendRegisteredNotification implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $admins = User::where('role', '=', 'admin');

        $admins->chunk(50, function($admins) use ($event){
           foreach ($admins as $admin) {
               Mail::to($admin->email)->send(new NewUserNotify('Зареєстровано користувача', 'Новий користувач: '.$event->user->name));
           }
        });
    }
}
