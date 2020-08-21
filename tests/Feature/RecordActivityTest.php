<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecordActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function activity_is_recorded_when_thread_is_created()
    {
        // When we create a thread
        $this->signIn();
        $thread = factory(Thread::class)->create();

        // Then the activity should be recorded for it
        $this->assertDatabaseHas('activities', [
           'user_id' => auth()->id(),
           'type' => 'created_thread',
           'subject_id' => $thread->id,
           'subject_type' => 'App\Models\Thread',
        ]);
    }

    /** @test */
    function activity_is_recorded_when_reply_is_created()
    {
        // When we create a thread
        $this->assertEquals(0, Activity::count());
        $this->signIn();
        $reply = factory(Reply::class)->create();

        // Then the activity should be recorded for it
        $this->assertDatabaseHas('activities', [
           'user_id' => auth()->id(),
           'type' => 'created_reply',
           'subject_id' => $reply->id,
           'subject_type' => 'App\Models\Reply',
        ]);

        // 2 activities are created, because a thread is created as a part of the reply creation process.
        $this->assertEquals(2, Activity::count());
    }
}
