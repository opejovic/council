<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use App\Filters\ThreadFilters;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category, ThreadFilters $filters)
    {
        $threads = Thread::filter($filters);

        if ($category->exists) {
            $threads = Thread::where('category_id', $category->id);
        }

        $threads = $threads->latest()->get();

        return view('thread.index', ['threads' => $threads]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('thread.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'body' => ['required'],
            'category_id' => ['required', 'exists:categories,id'],
        ]);

        $thread = Thread::create([
            'category_id' => $request['category_id'],
            'user_id' => auth()->id(),
            'title' => $request['title'],
            'body' => $request['body'],
        ]);

        return redirect($thread->path())->with('flash', 'Thread created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category $category
     * @param  \App\Models\Thread   $thread
     * @return \Illuminate\Http\Response
     */
    public function show($categorySlug, Thread $thread)
    {
        return view('thread.show', [
            'thread' => $thread,
            'replies' => $thread->replies()->paginate(20)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category $category
     * @param  \App\Models\Thread   $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category, Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->replies->each->delete();
        $thread->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect('/threads');
    }
}
