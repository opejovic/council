<?php

namespace Tests\Feature;

use App\Models\User;
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
        $user = factory(User::class)->create();
        $thread = factory(Thread::class)->create();
        $this->assertEquals(0, $thread->replies()->count());


        $response = $this->actingAs($user)->post("{$thread->path()}/replies", [
            'body' => 'I have something to say about this thread.'
        ]);

        $response->assertOk();
        $this->assertEquals(1, $thread->fresh()->replies()->count());
        $this->get($thread->path())->assertSee('I have something to say about this thread.');
    }
}
