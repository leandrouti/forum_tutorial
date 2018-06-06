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

    /** @test */
    public function a_user_can_filter_threads_according_to_a_channel(){
        $channel = factory('App\Channel')->create();

        $threadInChannel = factory('App\Thread')->create(['channel_id' => $channel->id]);
        $threadNotInChannel = factory('App\Thread')->create();

        $this->get('threads/' . $channel->slug)
                ->assertSee($threadInChannel->title)
                ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {
        $this->actingAs($user = factory('App\User')->create(['name' => 'JohnDoe']));

        $threadByJohn = factory('App\Thread')->create(['user_id' => Auth()->id()]);
        $threadNotByJohn = factory('App\Thread')->create();

        $this->get('threads?by=JohnDoe')
                ->assertSee($threadByJohn->title)
                ->assertDontSee($threadNotByJohn);
    }

    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {
        $this->actingAs($user = factory('App\User')->create(['name' => 'JohnDoe']));
        
        $threadWithTwoReplies = factory('App\Thread')->create();
        factory('App\Reply', 2)->create(['thread_id' => $threadWithTwoReplies->id]);

        $threadWithThreeReplies = factory('App\Thread')->create();
        $replies = factory('App\Reply', 3)->create(['thread_id' => $threadWithThreeReplies->id]);

        $threadWithNoReplies = $this->thread;

        $response = $this->getJson('threads?popular=1')->json();

        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }

}
