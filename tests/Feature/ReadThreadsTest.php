<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;

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
        $this->withoutExceptionHandling();
        /* Arrange  2 threads, associated with different categories */
        $category = factory(Category::class)->create();
        $threadInCategory = factory(Thread::class)->create([
            'category_id' => $category->id
        ]);
    
        $threadInOtherCategory = factory(Thread::class)->create();
    
        /* Act user filters by one category */
        $response = $this->get("/threads/{$category->slug}");
    
        /* Assert only a thread associated with filtered category is shown */
        $response->assertSee($threadInCategory->title);
        $response->assertDontSee($threadInOtherCategory->title);
    }
}
