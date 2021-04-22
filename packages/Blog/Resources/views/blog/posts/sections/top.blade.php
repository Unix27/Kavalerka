<?php

use Localization\Models\Locale;

$locales = Localization::getSupportedLocales();

?>

<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header">

        <div class="card-toolbar">
            @include('admin::blog.posts.inputs.locale')
        </div>

        <div class="card-toolbar">
            <a href="javascript:history.back()" class="btn btn-light-primary font-weight-bolder mr-2">
                <i class="ki ki-long-arrow-back icon-sm"></i>
                Назад
            </a>
            @if(isset($post) && $post->category)
                <a class="btn btn-light font-weight-bolder mr-2" target="_blank"
                   href="{{route('site.blog.post.view', [$post->category->slug, $post->slug])}}">
                    <i class="flaticon-eye"></i>
                    <span class="kt-hidden-mobile">Предпросмотр</span>
                </a>
            @endif
            <div class="btn-group">
                <button type="button" class="btn btn-primary font-weight-bolder mr-2" id="save">
                    <i class="ki ki-check icon-sm"></i>
                    Сохранить
                </button>
            </div>
            @if(isset($post))
                @if(!$post->status)
                    <button class="btn btn-success font-weight-bolder" onclick="$('#publish').submit()">
                        <i class="la la-share"></i>
                        <span class="kt-hidden-mobile">Опубликовать</span>
                    </button>
                @else
                    <button class="btn btn-danger" onclick="$('#unpublish').submit()">
                        <i class="la la-close"></i>
                        <span class="kt-hidden-mobile">Снять с публикации</span>
                    </button>
                @endif
            @endif
        </div>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-xl-12">
                @include('admin::blog.posts.inputs.title')

                <div class="separator separator-dashed separator-border-2 mb-10"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                @include('admin::blog.posts.inputs.content')
            </div>
        </div>

    </div>
</div>

@push('scripts')
@endpush
