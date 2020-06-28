@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-5">
                    <div class="card-header">{{ $thread->title }}</div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>

                @forelse($thread->replies as $reply)
                    @include('thread.reply')
                @empty
                    No replies for this thread yet.
                @endforelse

                @if(auth()->check())
                <div class="mt-4">
                    <form action="{{ $thread->path() }}/replies" method="POST">
                        @csrf
                        <textarea class="w-100 form-control" name="body" id="body" rows="6" placeholder="Have something to say?"></textarea>

                        <button type="submit" class="mt-2 form-control btn btn-primary">Reply</button>
                    </form>

                </div>
                @else
                    <p class="text-center mt-4">Please <a href="/login">sign in</a> to participate in discussion.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
