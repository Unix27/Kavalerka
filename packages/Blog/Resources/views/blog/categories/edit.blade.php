@extends('admin::layouts.master')

@section('title')
    Изменить категорию
@endsection

@section('content')
    <form action="{{route('admin.blog.categories.update', $model->id)}}" method="POST" id="form">
        @method('PUT')
        @csrf

        @include('admin::blog.categories.sections.top')

        @include('admin::blog.categories.sections.seo')

    </form>
@endsection
