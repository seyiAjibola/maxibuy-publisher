<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use App\Models\Topic;
use App\Models\Subscription;

class TopicsTest extends TestCase
{
    public function test_topic_has_expected_columns()
    {
        $this->assertTrue( 
            Schema::hasColumns('topics', [
              'id','title', 'slug', 'article'
          ]), 1);
    }

    public function test_topic_has_many_subscriptions()
    {
        $topic = Topic::create([
            'title' => 'Youths and Sports',
            'slug' => 'youth-and-sports',
            'article' => `[
                {
                    "heading":"Heading 1",
                    "paragraph_1":"Content for paragraph 1",
                    "paragraph_2":"Content for paragraph 2"
                },
                {
                    "heading":"Heading 2",
                    "paragraph_1":"Content for paragraph 1",
                    "paragraph_2":"Content for paragraph 2"
                },
                {
                    "heading":"Heading 3",
                    "paragraph_1":"Content for paragraph 1",
                    "paragraph_2":"Content for paragraph 2"
                }
            ]`,
        ]);

        $subscriptions = Subscription::create([
            'url' => 'http://127.0.0.1:9000/api/notification',
            'topic_id' => $topic->id
        ]);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $topic->subscriptions);
    }
}
