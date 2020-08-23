<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Category;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Activity;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_see_the_form_to_create_threads()
    {
        $this->get('/threads/create')->assertRedirect('/login');
    }

    /** @test */
    public function guests_cannot_create_threads()
    {
        $this->post('/threads', [])->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_users_can_create_threads()
    {
        $this->signIn();
        $this->assertCount(0, Thread::all());

        $this->post('/threads', [
            'category_id' => factory(Category::class)->create()->id,
            'title' => 'My first thread',
            'body' => 'My thoughts on some subject.',
        ]);

        $this->assertCount(1, Thread::all());

        $thread = Thread::first();

        $this->get($thread->path())
            ->assertSee($thread->creatorName)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    function unauthorized_users_can_not_delete_threads()
    {
        $thread = factory(Thread::class)->create();

        $this->delete($thread->path())->assertRedirect('/login');

        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);
    }

    /** @test */
    function authorized_users_can_delete_threads()
    {
        $this->signIn();
        $thread = factory(Thread::class)->create(['user_id' => auth()->id()]);
        $reply = factory(Reply::class)->create(['thread_id' => $thread->id]);
        $this->assertCount(1, Thread::all());
        $this->assertCount(1, Reply::all());

        $response = $this->json('delete', $thread->path());

        $response->assertStatus(204);
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertCount(0, Thread::all());
        $this->assertCount(0, Reply::all());
        $this->assertEquals(0, Activity::count());
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_category()
    {
        $this->publishThread(['category_id' => null])->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function a_thread_requires_a_valid_category()
    {
        factory(Category::class, 2)->create();
        $this->publishThread(['category_id' => 999])->assertSessionHasErrors('category_id');
    }

    private function publishThread($overrides = [])
    {
        $this->signIn();

        $thread = factory(Thread::class)->make($overrides);

        return $this->post("/threads", $thread->toArray());
    }
}
