<form action="{{route('admin.blog.categories.store')}}" method="POST" id="form">
    @csrf

    @include('admin::blog.categories.sections.top')

    @include('admin::blog.categories.sections.seo')

</form>

@push('scripts')

    <script>



    </script>

@endpush
