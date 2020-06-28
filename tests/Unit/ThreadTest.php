<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function thread_can_have_many_replies()
    {
        $thread = factory(Thread::class)->create();

        factory(Reply::class, 2)->create(['thread_id' => $thread->id]);

        $this->assertEquals(2, $thread->replies()->count());
    }
}
