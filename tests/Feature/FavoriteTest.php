<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoriteTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guests_cannot_favorite_reply()
    {
        $this->post('replies/1/favorite')
                ->assertRedirect('/login');
    }


    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($user = factory('App\User')->create());
        
        $reply = factory('App\Reply')->create();

        $this->post('replies/' . $reply->id . '/favorite');

        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_may_favorite_a_reply_once(){
        $this->withoutExceptionHandling();
        $this->actingAs($user = factory('App\User')->create());
        
        $reply = factory('App\Reply')->create();

        

        try{
            $this->post('replies/' . $reply->id . '/favorite');
            $this->post('replies/' . $reply->id . '/favorite');
        }catch(\Exception $e){
            $this->fail('Did not expected insert same record twice');
        }

        $this->assertCount(1, $reply->favorites);
    }
}
