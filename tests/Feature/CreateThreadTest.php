<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guests_may_not_create_threads(){
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->withoutExceptionHandling();

        $this->get('/threads/create')
                ->assertRedirect('/login');

        $this->post('/threads')
                ->assertRedirect('/login');
        
    }

    /** @test */
    public function an_authenticated_user_can_create_threads()
    {
        $this->actingAs($user = factory('App\User')->create());

        $thread = factory('App\Thread')->make();

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function a_thread_requires_title()
    {
        $this->actingAs($user = factory('App\User')->create());

        $thread = factory('App\Thread')->create();

        $thread->title = null;

        $this->post('/threads', $thread->toArray())
                ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_body()
    {
        $this->actingAs($user = factory('App\User')->create());
        
        $thread = factory('App\Thread')->create();

        $thread->body = null;

        $this->post('/threads', $thread->toArray())
                ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_channel()
    {
        $this->actingAs($user = factory('App\User')->create());
        
        $channels = factory('App\Channel', 2)->create();

        $thread = factory('App\Thread')->create();

        $thread->channel_id = null;
        $this->post('/threads', $thread->toArray())
                ->assertSessionHasErrors('channel_id');

        //Checks valid channel
        $thread->channel_id = 999;
        $this->post('/threads', $thread->toArray())
                ->assertSessionHasErrors('channel_id');
    }
}
