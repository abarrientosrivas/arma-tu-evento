<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_invalid_values_search()
    {

        $response = $this->get("api/search/0/0");
        $response->assertStatus(404);

        $response = $this->get("api/search/1654041600/0");
        $response->assertStatus(404);

        $response = $this->get("api/search/1654041600/-100");
        $response->assertStatus(404);

        $response = $this->get("api/search/0/texto");
        $response->assertStatus(500);

        $response = $this->get("api/search/texto/0");
        $response->assertStatus(500);
    }

    public function test_valid_post_search()
    {
        $response = $this->get("/api/search/16547918040/10");
        $response->assertStatus(200);

        $response = $this->get("/api/search/16547918040/0");
        $response->assertStatus(200);
    }
}
