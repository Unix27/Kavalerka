<div class="form-group row">
    <label class="col-3 col-form-label">Meta title</label>
    <div class="col-9">
        <input class="form-control" type="text"
               @if(isset($translation)) value="{{$translation->meta_title}}" @endif
               name="meta_title" data-msg="Обязательно для заполнения">
    </div>
</div>
