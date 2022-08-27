<?php

namespace App\Services;

use App\Models\Topic;
use App\Events\NotifySubscriber;

class TopicService 
{
    protected $topicModel;
    protected $subscriptionModel;

    public function __construct(Topic $topicModel) 
    {
        $this->topicModel = $topicModel;
    }

    public function publishTopic($requestData, $topic)
    {
        //Publish article
        $published = tap($this->topicModel->where('slug', $topic))
                    ->update(['article' => $requestData->article])
                    ->first();
                    
        //send notification to subscribers
        event(new NotifySubscriber($published));
        
        return $published ? [ 'message' => ['success' => 'Article published successfully!'], 'code' => 200 ]
                    : [ 'message' => [ 
                            'error' => 'Article could not be published! Try again.'
                        ],
                        'code' => 400
                    ];
    }
    
}