<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use App\Models\Topic;
use App\Models\Subscription;

class SubscriptionsTest extends TestCase
{
    public function test_subscription_has_expected_columns()
    {
        $this->assertTrue( 
            Schema::hasColumns('subscriptions', [
              'id','url', 'topic_id'
          ]), 1);
    }

    public function test_subscriptions_belong_to_topic()
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
            ]`
        ]);

        $subscription = Subscription::make(['topic_id' => $topic->id]);
        $this->assertInstanceOf(Topic::class, $subscription->topic);
    }
}
