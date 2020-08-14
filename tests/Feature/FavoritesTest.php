<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Reply;
use App\Models\User;

class FavoritesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_can_not_favorite_anything()
    {
        $this->post("/replies/1/favorites")->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $reply = factory(Reply::class)->create();
        auth()->login($user = factory(User::class)->create());
    
        $this->actingAs($user)->post("/replies/{$reply->id}/favorites");
    
        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply_only_once()
    {
        $reply = factory(Reply::class)->create();
        auth()->login($user = factory(User::class)->create());
    
        $this->actingAs($user)->post("/replies/{$reply->id}/favorites");
        $this->actingAs($user)->post("/replies/{$reply->id}/favorites");
    
        $this->assertCount(1, $reply->favorites);
    }
}
