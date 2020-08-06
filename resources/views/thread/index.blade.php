@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach ($threads as $thread)
                <div class="card mb-2">
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            <h5><a href="{{ $thread->path() }}">{{ $thread->title }}</a></h5>
                            <a href="">{{ $thread->creatorName }}</a>
                        </div>
                        <div>
                            {{ $thread->replies_count }} {{ Str::plural('reply', $thread->replies_count) }}
                        </div>
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
