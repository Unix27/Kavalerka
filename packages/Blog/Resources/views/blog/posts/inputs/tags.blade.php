<div class="form-group">
    <label>Теги</label>
        <input id="kt_tagify_1" name='tags' placeholder='...' value='{{isset($post) ? $post->tags : ''}}' autofocus >
</div>


@push('scripts')

    <script>

        jQuery(document).ready(function() {
            const input = document.getElementById('kt_tagify_1'),
                tagify = new Tagify(input);

            //document.getElementById('kt_tagify_1_remove').addEventListener('click', tagify.removeAllTags.bind(tagify))
        });

    </script>

@endpush
