@php

    use Blog\Models\BlogCategory;

    $categories = BlogCategory::all();

@endphp

<div class="form-group">
    <label class="">Категория</label>
    <div class="">
        <select class="form-control selectpicker" name="category_id" id="category_id">
            @foreach($categories as $item)
                <option data-icon="flaticon2-folder font-size-lg bs-icon"
                        value="{{$item->id}}"
                        @if(isset($post) && $post->category_id == $item->id) selected @endif
                >{{$item->name}}
                </option>
            @endforeach
        </select>
    </div>
</div>
