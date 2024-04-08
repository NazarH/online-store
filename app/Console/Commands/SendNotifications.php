<?php

namespace App\Console\Commands;

use App\Mail\SubscribeNotify;
use App\Models\Lead;
use App\Models\Notification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for schedule notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $notifications = Notification::where('notification_date', '<=', now())
            ->whereNotIn('status', ['in_process', 'done']);

        $leads = Lead::where('type', '=', 'subscription');

        $notifications->chunk(50, function ($items) use ($leads){
            foreach ($items as $item) {
                $item->update(['status' => 'in_process']);

                $leads->chunk(50, function ($leads) use ($item){
                    foreach ($leads as $lead) {
                        Mail::to($lead->user->email)->send(new SubscribeNotify($item->topic, $item->text));
                    }
                });

                $item->update(['status' => 'done']);
            }
        });
    }
}
