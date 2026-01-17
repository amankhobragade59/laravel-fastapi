@extends('layout.app')

@section('content')
<style>
    h2 {
        color: #ffc107;
        margin-bottom: 20px;
        text-align: center;
    }

    .post-view {
        background: #2c2c2c;
        padding: 20px;
        border-radius: 10px;
        max-width: 600px;
        margin: 0 auto;
        font-size: 14px;
        color: #fff;
    }

    .post-view label {
        font-weight: bold;
        color: #ccc;
        display: block;
        margin-top: 15px;
        margin-bottom: 6px;
    }

    .post-view .content {
        background: #1a1a1a;
        padding: 12px;
        border-radius: 6px;
        border: 1px solid #444;
        color: #fff;
    }

    .actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }

    .back-btn {
        background: #10ccb9;
        color: #fff;
        padding: 10px 20px;
        border-radius: 20px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        text-align: center;
        font-weight: bold;
    }

    .back-btn:hover {
        background: #02ecd4;
    }
</style>

<h2>View Post</h2>

<div class="post-view">
    <label>Title</label>
    <div class="content">{{ $post['title'] }}</div>

    <label>Content</label>
    <div class="content">{{ $post['body'] }}</div>

    <div class="actions">
        <button onclick=history.back() class="back-btn">Back</button>
    </div>
</div>
@endsection
