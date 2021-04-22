<?php

namespace Feedback\Listeners;

use Feedback\Events\FeedbackCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class FeedbackCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  FeedbackCreatedEvent  $event
     * @return void
     */
    public function handle(FeedbackCreatedEvent $event)
    {
        $data = [
            'email' => $event->feedback->email,
            'question' => $event->feedback->message,
        ];

        Mail::send('feedback::emails.feedback', $data, function ($message) {
            $message->to('alex142970@gmail.com')
                ->subject('Новое сообщение!');
        });

        info($data['message']);
    }
}
