<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\View\View;

class SubscribeNotify extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $topic;
    public $text;

    /**
     * Create a new message instance.
     */
    public function __construct($topic, $text)
    {
        $this->topic = $topic;
        $this->text = $text;
    }

    public function build(): SubscribeNotify
    {
        return $this->view('admin.emails.pattern')
            ->with([
                'topic' => $this->topic,
                'text' => $this->text
            ]);
    }
}
