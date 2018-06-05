<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unaunthenticated_users_may_not_reply(){
        $this->post('/threads/test/1/replies', [])
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads(){
        // Given and authenticated user
        // and an existing thread,
        // then their reply should be visible on the page

        $this->be($user = factory('App\User')->create());

        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->make();

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())
                ->assertSee($reply->body);

    }
    
    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->be($user = factory('App\User')->create());
        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->make();

        $reply->body = null;
        
        $this->post($thread->path() . '/replies', $reply->toArray())
                ->assertSessionHasErrors('body');;

        
    }
}
