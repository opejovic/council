<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guests_cannot_reply_in_threads()
    {
        $thread = factory(Thread::class)->create();
        $this->assertEquals(0, $thread->replies()->count());

        $response = $this->post("{$thread->path()}/replies", [
            'body' => 'I have something to say about this thread.'
        ]);

        $response->assertRedirect('/login');
        $this->assertEquals(0, $thread->fresh()->replies()->count());
    }

    /** @test */
    function an_authenticated_user_may_reply_in_forum_threads()
    {
        $this->signIn();
        $thread = factory(Thread::class)->create();
        $this->assertEquals(0, $thread->replies()->count());

        $this->post("{$thread->path()}/replies", [
            'body' => 'I have something to say about this thread.'
        ]);

        $this->assertEquals(1, $thread->fresh()->replies()->count());
        $this->get($thread->path())->assertSee('I have something to say about this thread.');
    }

    /** @test */
    function unauthorized_users_cannot_delete_replies()
    {
        $reply = factory(Reply::class)->create();
        $user = factory(User::class)->create();

        $responseForGuest = $this->delete("/replies/{$reply->id}");
        $responseForUnauthorizedUser = $this->actingAs($user)->delete("/replies/{$reply->id}");

        $responseForGuest->assertRedirect('/login');
        $responseForUnauthorizedUser->assertStatus(403);
    }

    /** @test */
    function authorized_users_can_delete_replies()
    {
        $user = factory(User::class)->create();
        $reply = factory(Reply::class)->create(['user_id' => $user->id]);

        $this->actingAs($user)->delete("/replies/{$reply->id}");

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, Reply::count());
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->signIn();
        $thread = factory(Thread::class)->create();

        $response = $this->post("{$thread->path()}/replies", [
            'body' => null,
        ]);

        $response->assertSessionHasErrors('body');
    }
}
