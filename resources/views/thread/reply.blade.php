{{--<div id="reply-{{ $reply->id }}" class="card mb-2">--}}
{{--    <div class="card-header d-flex justify-content-between">--}}
{{--        <p>--}}
{{--            {{ $reply->owner->name }} at {{ $reply->created_at->diffForHumans() }}--}}
{{--        </p>--}}

{{--        <div class="d-flex">--}}
{{--            @auth--}}
{{--                <form class="mr-1" action="{{ route('reply.favorite', $reply) }}" method="POST">--}}
{{--                    @csrf--}}
{{--                    <button class="btn btn-primary btn-sm" type="submit" {{ $reply->isFavorited() ? 'disabled' : '' }}>--}}
{{--                        {{ $reply->favorites_count }} {{ Str::plural('Favorite', $reply->favorites_count) }}--}}
{{--                    </button>--}}
{{--                </form>--}}
{{--            @endauth--}}
{{--        </div>--}}


{{--    </div>--}}

{{--    <div class="card-body">--}}
{{--        {{ $reply->body }}--}}
{{--    </div>--}}

{{--    @can('update', $reply)--}}
{{--    <div class="card-footer">--}}
{{--            <form action="{{ route('reply.delete', $reply) }}" method="POST">--}}
{{--                @csrf--}}
{{--                @method('DELETE')--}}

{{--                <button class="btn btn-danger btn-sm" type="submit">Delete</button>--}}
{{--            </form>--}}
{{--    </div>--}}
{{--    @endcan--}}
{{--</div>--}}
