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

        return redirect($thread->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category $category
     * @param  \App\Models\Thread   $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Thread $thread)
    {
        return view('thread.show', ['thread' => $thread]);
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
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        //
    }
}
