<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SubscriptionService;
use App\Http\Requests\SubscriptionRequest;

class SubscriptionController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService) 
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function topicSubscription(SubscriptionRequest $request, $topic)
    {
        $subscriptionResponse = $this->subscriptionService->subscribe($request, $topic);
        return response($subscriptionResponse['message'], $subscriptionResponse['code']);
    }
}
