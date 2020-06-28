<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->thread = factory(Thread::class)->create();
    }

    /** @test */
    function a_user_can_view_all_threads()
    {
        $response = $this->get('/threads');

        $response->assertOk();
        $response->assertSee($this->thread->title);
    }

    /** @test */
    function a_user_can_browse_a_single_thread()
    {
        $this->thread = factory(Thread::class)->create();

        $response = $this->get("/threads/{$this->thread->id}");

        $response->assertOk();
        $response->assertSee($this->thread->title);
    }

    /** @test */
    function a_user_can_read_all_replies_associated_with_the_thread()
    {
        // And that thread has replies
        $reply = factory(Reply::class)->create(['thread_id' => $this->thread->id]);

        // When the user visits that thread
        $response = $this->get($this->thread->path());

        // Then he should be able to see all replies associated with it
        $response->assertOk();
        $response->assertSee($reply->body);
    }
}
