<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unaunthenticated_users_may_not_reply(){
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('/threads/1/replies', []);
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
}
