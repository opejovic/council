@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center border-bottom mb-4">
                <h1>{{ $profileUser->name }}</h1>
                <p>Member since {{ $profileUser->created_at->diffForHumans() }}</p>
            </div>

            @foreach ($activities as $date => $group)
                <h3>{{ $date }}</h3>
                @foreach($group as $activity)
                    @if(view()->exists("profiles.activities.{$activity->type}"))
                        @include("profiles.activities.{$activity->type}")
                    @endif
                @endforeach
                <br>
            @endforeach
        </div>
    </div>
</div>

@endsection
