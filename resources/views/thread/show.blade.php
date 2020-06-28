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
            </div>
        </div>
    </div>
@endsection
