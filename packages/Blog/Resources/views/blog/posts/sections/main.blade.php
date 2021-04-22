<div class="card mt-10">
    <div class="card-body">
        <div class="row">
            <div class="col-4">
                @include('admin::blog.posts.inputs.image')
            </div>
            <div class="col-8">
                @include('admin::blog.posts.inputs.category')
                @include('admin::blog.posts.inputs.tags')
                @include('admin::blog.posts.inputs.related')
            </div>
        </div>

    </div>
</div>


