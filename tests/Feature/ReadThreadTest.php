<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FeatureTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

    
    /** @test */
    public function a_user_can_view_thread()
    {
        $response = $this->get('/threads')
                    ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_single_thread()
    {
        $response = $this->get($this->thread->path())
                    ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_replies_associated_with_a_thread(){
        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);

        $response = $this->get($this->thread->path())
                    ->assertSee($reply->body);
    }

}
