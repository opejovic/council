<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Reply;
use App\Models\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_reply_belongs_to_a_user()
    {
        $reply = factory(Reply::class)->create();

        $this->assertInstanceOf(User::class, $reply->owner);
    }

    /** @test */
    function a_reply_belongs_to_a_thread()
    {
        $reply = factory(Reply::class)->create();

        $this->assertInstanceOf(Thread::class, $reply->thread);
    }
}
