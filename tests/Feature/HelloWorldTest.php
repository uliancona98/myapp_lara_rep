<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HelloWorldTest extends TestCase
{
    /**
     * 
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
	
    public function test_when_client_send_a_request_a_hello_world_is_responded()
    {
        
        # When
        # we send a GET request to the url /greeting
        $response = $this->get('api/greeting');

        # Then
        # We receive a HTTP status code of 200 (OK)
        $response->assertStatus(200);
        # We receive the texts "Hello World!" inside the response
        $response->assertSeeText('Hello World!');
    }
}
