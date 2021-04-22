<div class="card card-custom card-collapsed mt-10" data-card="true" id="kt_card_4">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">SEO</h3>
        </div>
        <div class="card-toolbar">
            <a href="#" class="btn btn-icon btn-sm btn-light-primary mr-1" data-card-tool="toggle">
                <i class="ki ki-arrow-down icon-nm"></i>
            </a>
        </div>
    </div>
    <div class="card-body">
        @include('admin::blog.posts.inputs.slug')
        @include('admin::blog.posts.inputs.meta_title')
        @include('admin::blog.posts.inputs.meta_description')
        @include('admin::blog.posts.inputs.meta_keywords')
    </div>
</div>
