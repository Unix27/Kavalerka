@extends('admin::layouts.master')

@section('title', 'Статьи')

@push('subheader_toolbar')
    <a href="{{ route('admin.blog.posts.create') }}"
       class="btn btn-sm btn-primary font-weight-bold ml-2">{!! Metronic::returnSVG('media/svg/icons/Design/Flatten.svg') !!} Добавить</a>
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            {{ $datagrid->render() }}
        </div>
    </div>
@endsection


@push('scripts')
@endpush

@push('styles')
@endpush
