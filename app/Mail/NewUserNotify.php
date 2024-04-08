<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewUserNotify extends Mailable
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

    public function build()
    {
        return $this->view('admin.emails.pattern')
            ->with([
                'topic' => $this->topic,
                'text' => $this->text
            ]);
    }
}
