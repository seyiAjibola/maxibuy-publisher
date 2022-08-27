<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\Topic;

class SubscriptionService 
{
    protected $subscriptionModel;
    protected $topicModel;

    public function __construct(Subscription $subscriptionModel, Topic $topicModel) 
    {
        $this->subscriptionModel = $subscriptionModel;
        $this->topicModel = $topicModel;
    }

    public function subscribe($requestData, $topic)
    {
        $isValidTopic = $this->topicModel->where('slug', $topic)->first(); //check if topic exists

        if(!$isValidTopic) {
            //return invalid request
            return [
                    'message' => [ 'error' => 'Invalid request'],
                    'code' => 400
                ];        
        }
        
        //subscribe to topic
        $subrcibed = $this->subscriptionModel->create([
            'url' => $requestData->url,
            'topic_id' => $isValidTopic->id
        ]);

        return $subrcibed ? [ 'message' => [
                                    'url' => $subrcibed->url, 
                                    'topic' => $isValidTopic->title
                                ],
                                'code' => 200
                            ]
                        : [ 'message' => [
                                'error' => 'Could not subscribe at this moment, something went wrong! Try again.'
                            ],
                            'code' => 400
                        ];
    }

}