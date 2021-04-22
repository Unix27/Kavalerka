<div class="form-group row">
    <label class="col-3 col-form-label">Meta keywords</label>
    <div class="col-9">
        <textarea class="form-control" type="text"
               name="meta_keywords" data-msg="Обязательно для заполнения"
        >@if(isset($translation)){!! $translation->meta_keywords !!}@endif</textarea>
    </div>
</div>
