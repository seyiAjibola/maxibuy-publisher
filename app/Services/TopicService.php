<?php

namespace App\Services;

use App\Models\Topic;
use App\Models\Subscription;
use Illuminate\Support\Facades\Http;

class TopicService 
{
    protected $topicModel;
    protected $subscriptionModel;

    public function __construct(Topic $topicModel, Subscription $subscriptionModel) 
    {
        $this->topicModel = $topicModel;
        $this->subscriptionModel = $subscriptionModel;
    }

    public function publishTopic($requestData, $topic)
    {
        //Publish article
        $published = tap($this->topicModel->where('slug', $topic))
                            ->update(['article' => $requestData->article])
                            ->first();

        //get subscribed urls for article
        $topicSubscribers = $this->subscriptionModel->where('topic_id', $published->id)->get();
        foreach($topicSubscribers as $topicSubscriber) {
            //send notification request
            $payload = json_encode([
                'topic' => $published->title,
                'data' => $published->article
            ]);
            Http::post($topicSubscriber->url, $payload);
        }

        return $published ? [ 'message' => ['success' => 'Article published successfully!'], 'code' => 200 ]
                    : [ 'message' => [ 
                        'error' => 'Article could not be published! Try again.'
                        ],
                        'code' => 400
                    ];
    }
    
}