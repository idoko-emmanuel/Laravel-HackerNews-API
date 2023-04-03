<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HackernewsControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_the_maximum_item_id_in_the_spool()
    {
        $response = $this->get('/api/v1/spool/max');

        $response->assertStatus(200);
        $response->assertJsonStructure(['message']);
    }

    /** @test */
    public function it_returns_the_top_items_in_the_spool()
    {
        $response = $this->get('/api/v1/spool/top');

        $response->assertStatus(200);
        $response->assertJsonStructure(['message']);
    }

    /** @test */
    public function it_returns_the_new_items_in_the_spool()
    {
        $response = $this->get('/api/v1/spool/new');

        $response->assertStatus(200);
        $response->assertJsonStructure(['message']);
    }

    /** @test */
    public function it_returns_the_show_items_in_the_spool()
    {
        $response = $this->get('/api/v1/spool/show');

        $response->assertStatus(200);
        $response->assertJsonStructure(['message']);
    }

    /** @test */
    public function it_returns_the_ask_items_in_the_spool()
    {
        $response = $this->get('/api/v1/spool/ask');

        $response->assertStatus(200);
        $response->assertJsonStructure(['message']);
    }

    /** @test */
    public function it_returns_the_job_items_in_the_spool()
    {
        $response = $this->get('/api/v1/spool/job');

        $response->assertStatus(200);
        $response->assertJsonStructure(['message']);
    }

    /** @test */
    public function it_returns_the_best_items_in_the_spool()
    {
        $response = $this->get('/api/v1/spool/best');

        $response->assertStatus(200);
        $response->assertJsonStructure(['message']);
    }
}
