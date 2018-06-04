<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class FeatureTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    public function a_user_can_view_thread()
    {
        $thread = factory('App\Thread')->create();
        $response = $this->get('/threads');
        $response->assertSee($thread->title);
    }

    /** @test */
    public function a_user_can_view_single_thread()
    {
        $thread = factory('App\Thread')->create();
        $response = $this->get('/threads/' . $thread->id);
        $response->assertSee($thread->title);
    }

}
