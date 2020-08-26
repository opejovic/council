<div id="reply-{{ $reply->id }}" class="card mb-2">
    <div class="card-header d-flex justify-content-between">
        <p>
            {{ $reply->owner->name }} at {{ $reply->created_at->diffForHumans() }}
        </p>

        @auth
            <form action="{{ route('reply.favorite', [$reply]) }}" method="post">
                @csrf
                <button class="btn btn-primary" type="submit" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                    {{ $reply->favorites_count }} {{ Str::plural('Favorite', $reply->favorites_count) }}
                </button>
            </form>
        @endauth

    </div>

    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
