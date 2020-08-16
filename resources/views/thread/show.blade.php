@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-start">
            <div class="col-md-8">
                <div class="card mb-5">
                    <div class="card-header">{{ $thread->title }}</div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>

                @forelse($replies as $reply)
                    @include('thread.reply')

                    {{ $replies->links() }}
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

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Thread information</div>

                    <div class="card-body">
                        This thread was published {{ $thread->created_at->diffForHumans() }}.
                        It currently has {{ $thread->replies_count }} {{ Str::plural('reply', $thread->replies_count) }}.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
