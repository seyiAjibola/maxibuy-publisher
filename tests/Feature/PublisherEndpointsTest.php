<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

class PublisherEndpointsTest extends TestCase
{
    
    public function test_subscribe_to_topic()
    {
        $response = $this->postJson('/api/subscribe/politics-and-governance', ['url' => 'http://127.0.0.1:9000/api/notification']);
        
        $response->assertStatus(200)
                ->assertExactJson([
                    'url' => 'http://127.0.0.1:9000/api/notification',
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

    public function test_subscriber_endpoint()
    {
        $data = `[
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
            ]`;

        Http::fake();

        Http::post('http://127.0.0.1:9000/api/notification', [
            'topic' => 'Politics and Governance',
            'data' => $data
        ]);


        Http::assertSent(function (Request $request) {
            return $request->url() == 'http://127.0.0.1:9000/api/notification' &&
                $request['topic'] == 'Politics and Governance' &&
                $request['data'] == `[
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
                            ]`;
        });
    }
}
