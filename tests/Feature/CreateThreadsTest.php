<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guests_cannot_create_threads()
    {
        $this->post('/threads', [])->assertRedirect('/login');
    }

    /** @test */
    function authenticated_users_can_create_threads()
    {
        $this->signIn();
        $this->assertCount(0, Thread::all());

        $this->post('/threads', [
            'title' => 'My first thread',
            'body' => 'My thoughts on some subject.'
        ]);

        $this->assertCount(1, Thread::all());

        $thread = Thread::first();

        $this->get("/threads/{$thread->id}")
            ->assertSee($thread->creatorName)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
