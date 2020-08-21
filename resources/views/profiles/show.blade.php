@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center border-bottom mb-4">
                <h1>{{ $profileUser->name }}</h1>
                <p>Member since {{ $profileUser->created_at->diffForHumans() }}</p>
            </div>

            @foreach ($threads as $thread)
            <div class="mt-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-start">
                        <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                        <span class=" small">{{ $thread->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="card-body">{{ $thread->body }}</div>
                </div>

            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
