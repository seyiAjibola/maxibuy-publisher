<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TopicService;
use App\Http\Requests\TopicRequest;

class TopicController extends Controller
{
    protected $topicService;

    public function __construct(TopicService $topicService) 
    {
        $this->topicService = $topicService;
    }

    public function topicPublication(TopicRequest $request, $topic)
    {
        $publishedResponse = $this->topicService->publishTopic($request, $topic);
        return response($publishedResponse['message'], $publishedResponse['code']);
    }
}
