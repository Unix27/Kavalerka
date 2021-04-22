<?php

/**
/* @var Blog\Models\BlogPost $post
 */

use Blog\Models\BlogPost;

if (isset($post))
    $relatedPosts = BlogPost::where('id', '<>', $post->id)->where('status', 1)->get();
else
    $relatedPosts = BlogPost::all();
?>


<div class="form-group">
    <label>Похожие</label>
    <select class="form-control kt-select2" id="related" multiple name="related">
        <option></option>
        @foreach($relatedPosts as $relatedPost)

            <option value="{{$relatedPost->id}}"
                    @if(isset($post) && $post->related->contains('id', $relatedPost->id)) selected @endif
            >{{$relatedPost->name}}
            </option>

        @endforeach
    </select>
</div>

@push('scripts')

    <script>
        $('#related').select2({
            placeholder: "Выбрать",
            //tags: true
            minimumResultsForSearch: 1
        });
    </script>

@endpush
