<?php

namespace App\Actions\Admin\Notification;

use App\Mail\SubscribeNotify;
use App\Models\Lead;
use Illuminate\Support\Facades\Mail;

class NotificationSendAction
{
    public function handle($data)
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
