<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublisherTest extends TestCase
{
    
    public function test_subscribe_to_topic()
    {
        $response = $this->postJson('/api/subscribe/politics-and-governance', ['url' => 'http://localhost:9000/api/notification']);

        $response->assertStatus(200)
                ->assertExactJson([
                    'url' => 'http://localhost:9000/api/notification',
                    'topic' => 'Politics and Governance'
                ])
                ->dump();
    }

    public function test_publish_to_topic()
    {
        $response = $this->postJson('/api/publish/politics-and-governance', ['article' => [
                                                                                'paragraph_1' => 'Content for paragraph 1',
                                                                                'paragraph_1' => 'Content for paragraph 1',
                                                                                'paragraph_1' => 'Content for paragraph 1'
                                                                                ]
                                                                            ]);
        $response->assertStatus(200)
                ->assertExactJson([ 'success' => 'Article published successfully!' ])
                ->dump();
    }
}
