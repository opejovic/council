<div class="card mb-2">
    <div class="card-header">{{ $reply->owner->name }} at {{ $reply->created_at->diffForHumans() }}</div>

    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
