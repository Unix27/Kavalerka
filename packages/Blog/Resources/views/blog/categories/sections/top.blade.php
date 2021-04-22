<?php

$locales = Localization::getSupportedLocales();

?>

<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header">

        <div class="card-toolbar">
            @include('admin::blog.categories.inputs.locale')
        </div>

        <div class="card-toolbar">
            <a href="#" class="btn btn-light-primary font-weight-bolder mr-2">
                <i class="ki ki-long-arrow-back icon-sm"></i>
                Назад
            </a>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary font-weight-bolder mr-2">
                    <i class="ki ki-check icon-sm"></i>
                    Сохранить
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-xl-12">
                @include('admin::blog.categories.inputs.title')

                <div class="separator separator-dashed separator-border-2 mb-10"></div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
@endpush
