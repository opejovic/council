<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->thread = factory(Thread::class)->create();
    }

    /** @test */
    function a_thread_belongs_to_a_user()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    /** @test */
    function thread_can_have_many_replies()
    {
        $this->thread = factory(Thread::class)->create();

        factory(Reply::class, 2)->create(['thread_id' => $this->thread->id]);

        $this->assertEquals(2, $this->thread->replies()->count());
    }

    /** @test */
    function a_reply_can_be_added_to_a_thread()
    {
        $this->thread = factory(Thread::class)->create();
        $this->thread->addReply([
            'body' => 'Dummy reply',
            'user_id' => 1
        ]);

        $this->assertEquals(1, $this->thread->replies()->count());
    }

    /** @test */
    function thread_knows_formatted_creator_name_attribute()
    {
        $this->assertEquals($this->thread->creator->name, $this->thread->creatorName);
    }

}
