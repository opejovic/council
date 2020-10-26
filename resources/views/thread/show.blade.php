@extends('layouts.app')

@section('content')
<thread-component
    :thread="{{ $thread }}"
    :replies="{{ $replies }}"
    :canUpdateThread="{{ Auth::user()->can('update', $thread) }}">
</thread-component>
@endsection
