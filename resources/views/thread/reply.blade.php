<div class="card mb-2">
    <div class="card-header d-flex justify-content-between">
        <p>
            {{ $reply->owner->name }} at {{ $reply->created_at->diffForHumans() }}
        </p>
        
        @auth
            <form action="{{ route('reply.favorite', [$reply]) }}" method="post">
                @csrf
                <button class="btn btn-primary" type="submit">
                    {{ $reply->favorites()->count() }} {{ Str::plural('Favorite', $reply->favorites()->count()) }}
                </button>
            </form>
        @endauth

    </div>

    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
