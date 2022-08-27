<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Subscription;
use App\Events\NotifySubscriber;

class SendHttpNotification
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
     * @param  \App\Events\PublishTopic  $event
     * @return void
     */
    public function handle(NotifySubscriber $event)
    {
        $published = $event->topic;

        //prepare data to send as part of request
        $data = [
            'topic' => $published->title,
            'data' => $published->article
        ];

        //get subscribed urls for article
        $topicSubscribers = (new Subscription)->where('topic_id', $published->id)->get();
        foreach($topicSubscribers as $topicSubscriber) {

            //send notification request
            $response = Http::post($topicSubscriber->url, $data);
            if(!$response->ok()) {
                //log error message
                Log::error('Notification not sent to '. $topicSubscriber->url);
            }

        }
    }
}
