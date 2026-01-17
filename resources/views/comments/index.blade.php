@extends('layouts.app')

@section('content')
<h1>Comments</h1>

@foreach($comments as $comment)
    <div class="card">
        <b>{{ $comment['name'] }}</b>
        <p>{{ $comment['body'] }}</p>
        <small>{{ $comment['email'] }}</small>
    </div>
@endforeach

{{ $comments->links() }}
@endsection
