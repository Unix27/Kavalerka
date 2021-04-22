<form action="{{route('admin.blog.posts.store')}}" method="POST" id="form" onsubmit="return false">
    @csrf

    @include('admin::blog.posts.sections.top')

    @include('admin::blog.posts.sections.main')

    @include('admin::blog.posts.sections.seo')

</form>

@push('scripts')

    <script>

        function formInit() {

            let content = null;

            const saveBtn = document.querySelector('#save');

            saveBtn.onclick = function (e) {

                $(this).attr('disabled', true);
                $(this).addClass('spinner spinner-white spinner-right');

                e.preventDefault();

                window.editor.save().then((outputData) => {
                    content = outputData;
                }).then(() => {
                    saveData();
                }).catch((error) => {
                    console.log('Saving failed: ', error)
                });
            };

            function saveData() {

                const url = '/admin/blog/posts';

                let formData = new FormData();

                formData.append('title', $('[name=title]').val());
                formData.append('content', JSON.stringify(content));
                formData.append('slug', $('[name=slug]').val());
                formData.append('locale', $('[name=locale]').val());
                formData.append('related', JSON.stringify($('#related').val()));
                formData.append('tags', $('[name=tags]').val());
                formData.append('image', $('[name=image]')[0].files[0] ?? '');
                formData.append('image_remove', $('[name=image_remove]').val() ?? null);
                formData.append('category_id', $('[name=category_id]').val());
                formData.append('meta_title', $('[name=meta_title]').val());
                formData.append('meta_description', $('[name=meta_description]').val());
                formData.append('meta_keywords', $('[name=meta_keywords]').val());

                @if(isset($post))

                formData.append('post_id', {{$post->id}});

                @endif

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    enctype: 'multipart/form-data',
                    processData: false, //Important!
                    contentType: false,
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        console.log(data);
                        setTimeout(function () {

                            if(data.redirect_url) {
                                window.location.href = data.redirect_url
                            } else {
                                $(saveBtn).attr('disabled', false);
                                $(saveBtn).removeClass('spinner spinner-white spinner-right');
                            }

                        }, 500);

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        let response = $.parseJSON(jqXHR.responseText);
                        console.log(response);
                        $(saveBtn).attr('disabled', false);
                        $(saveBtn).removeClass('spinner spinner-white spinner-right');
                    }
                });
            }

        }

        formInit();

    </script>

@endpush
