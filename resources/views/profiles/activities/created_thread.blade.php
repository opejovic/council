@component("profiles.activities.activity")
    @slot('heading')
        <p><a href="{{ route('profile', $activity->subject->creator) }}">{{ $activity->subject->creatorName }}</a> published a thread: <a href="{{ $activity->subject->path() }}">{{ $activity->subject->title }}</a></p>
        <span class=" small">{{ $activity->subject->created_at->diffForHumans() }}</span>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent
