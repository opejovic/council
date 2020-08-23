<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Activity;
use App\Models\Reply;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_records_activity_when_thread_is_created()
    {
        $this->signIn();
        $thread = factory(Thread::class)->create();

        $this->assertEquals(1, Activity::count());
    }
    /** @test */
    public function it_records_activity_when_reply_is_created()
    {
        $this->signIn();
        $reply = factory(Reply::class)->create();

        $this->assertEquals(2, Activity::count());
    }

    /** @test */
    public function it_fetches_a_feed_for_any_user()
    {
        $this->signIn();
        $threadFromNow = factory(Thread::class)->create(['user_id' => auth()->id()]);
        $threadFromWeekAgo = factory(Thread::class)->create([
            'user_id' => auth()->id(),
            'created_at' => now()->subWeek(),
        ]);


        // Update the activity created at timestamp for thread
        Activity::where('subject_id', $threadFromWeekAgo->id)->first()->update([
            'created_at' => now()->subWeek()
        ]);

        $feed = Activity::feed(auth()->user());
        $this->assertTrue($feed->keys()->contains($threadFromNow->fresh()->created_at->format('d.m.Y')));
        $this->assertTrue($feed->keys()->contains($threadFromWeekAgo->fresh()->created_at->format('d.m.Y')));
    }
}
