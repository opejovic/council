<?php

namespace Tests\Feature;

use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InteractingWithThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_view_all_threads()
    {
        $thread = factory(Thread::class)->create();

        $response = $this->get('/threads');

        $response->assertOk();
        $response->assertSee($thread->title);
    }

    /** @test */
    function a_user_can_browse_a_single_thread()
    {
        $this->withExceptionHandling();
        $thread = factory(Thread::class)->create();

        $response = $this->get("/threads/{$thread->id}");

        $response->assertOk();
        $response->assertSee($thread->title);
    }
}
