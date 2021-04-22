@extends('admin::layouts.master')

@section('title', 'Вопросы')

@section('subheader')
    {!! $datagrid->getSearchInput() !!}
@endsection


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
