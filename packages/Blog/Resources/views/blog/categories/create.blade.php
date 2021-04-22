@extends('admin::layouts.master')

@section('title')
    Создать категорию
@endsection

@push('subheader_toolbar')
    <a href="{{route('admin.blog.categories.index')}}" class="btn btn-clean kt-margin-r-10">
        <i class="la la-arrow-left"></i>
        <span class="kt-hidden-mobile">Назад</span>
    </a>
    <button class="btn btn-sm btn-primary font-weight-bold ml-2" id="save">
        <span class="kt-hidden-mobile">Сохранить</span>
    </button>
@endpush


@section('content')
    @include('admin::blog.categories.form')
@endsection
