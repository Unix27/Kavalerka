@extends('admin::layouts.master')

@section('title')
    Изменить пост
@endsection

@section('content')
    @include('admin::blog.posts.form')
    <form action="{{route('admin.blog.posts.publish', $post->id)}}" method="POST" id="publish">
        @method('PUT')
        <input type="hidden" name="id" value="{{$post->id}}">
        @csrf
    </form>
    <form action="{{route('admin.blog.posts.unpublish', $post->id)}}" method="POST" id="unpublish">
        @method('PUT')
        <input type="hidden" name="id" value="{{$post->id}}">
        @csrf
    </form>
@endsection
