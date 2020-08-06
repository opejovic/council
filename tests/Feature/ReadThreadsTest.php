<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;
use App\Models\User;

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
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee($this->thread->title);
    }

    /** @test */
    function a_user_can_browse_a_single_thread()
    {
        $this->thread = factory(Thread::class)->create();

        $response = $this->get($this->thread->path());

        $response->assertOk();
        $response->assertSee($this->thread->title);
    }

    /** @test */
    function a_user_can_read_all_replies_associated_with_the_thread()
    {
        $reply = factory(Reply::class)->create(['thread_id' => $this->thread->id]);

        $response = $this->get($this->thread->path());

        $response->assertOk();
        $response->assertSee($reply->body);
    }

    /** @test */
    public function a_user_can_filter_threads_according_to_a_category()
    {
        $category = factory(Category::class)->create();
        $threadInCategory = factory(Thread::class)->create([
            'category_id' => $category->id
        ]);
    
        $threadInOtherCategory = factory(Thread::class)->create();
    
        $response = $this->get("/threads/{$category->slug}");
    
        $response->assertSee($threadInCategory->title);
        $response->assertDontSee($threadInOtherCategory->title);
    }

    /** @test */
    public function user_can_filter_threads_by_any_username()
    {
        $john = factory(User::class)->create(['name' => 'John']);
        $threadByJohn = factory(Thread::class)->create(['user_id' => $john->id]);
        $threadNotByJohn = factory(Thread::class)->create();
    
        $response = $this->get('/threads?by=John');

        $response->assertSee($threadByJohn->title);
        $response->assertDontSee($threadNotByJohn->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {
        $this->withoutExceptionHandling();
        /* Arrange - we have 2 threads, 1 thread has 2 replies, and the other has 0 replies  */
        $threadWithNoReplies = factory(Thread::class)->create();
        $threadWithTwoReplies = factory(Thread::class)->create();

        factory(Reply::class)->create(['thread_id' => $threadWithTwoReplies]);

    
        /* Act - user filters threads by popularity eg. /threads?popularity=1 or ?popular=1*/
        $response = $this->get('/threads?popularity=1');
    
        /* Assert - the threads are displayed in correct manner - first is displayed the thread with most replies */
        $response->assertOk();
        $response->assertSeeInOrder([$threadWithTwoReplies->title, $threadWithNoReplies->title]);
    }
}
