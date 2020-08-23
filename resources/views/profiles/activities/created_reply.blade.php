@component("profiles.activities.activity")
    @slot('heading')
        <p><a href="{{ route('profile', $activity->subject->owner) }}">{{ $activity->subject->ownerName }}</a> left
            a reply on: <a
                href="{{ $activity->subject->thread->path() }}">{{ $activity->subject->thread->title }}</a></p>
        <span class=" small">{{ $activity->subject->created_at->diffForHumans() }}</span>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent
