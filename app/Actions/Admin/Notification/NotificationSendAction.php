<?php

namespace App\Actions\Admin\Notification;

use App\Mail\SubscribeNotify;
use App\Models\Lead;
use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\Concerns\AsAction;

class NotificationSendAction
{
    use AsAction;

    /**
     * Обробляє відправлення сповіщень.
     *
     * @param array $data Дані для відправлення сповіщень.
     * @return void
     */
    public function handle(array $data): void
    {
        $leads = Lead::where('type', '=', $data['type'])
            ->with('user');

        $leads->chunk(50, function ($leads) use ($data){
            foreach ($leads as $lead) {
                Mail::to($lead->user->email)->send(new SubscribeNotify($data['topic'], $data['text']));
            }
        });
    }
}
