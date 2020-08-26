@component("profiles.activities.activity")
    @slot('heading')
        <p><a href="{{ $activity->subject->favorited->path() }}">{{ $profileUser->name }} favorited a reply.</a> </p>
        <span class="small">{{ $activity->created_at->diffForHumans() }}</span>
    @endslot

    @slot('body')
        {{ $activity->subject->favorited->body }}
    @endslot
@endcomponent
