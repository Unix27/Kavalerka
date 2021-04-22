<div class="form-group row">
    <label class="col-3 col-form-label">Post content</label>
    <div class="col-9">
        <textarea class="form-control" type="text"
                  name="description" data-msg="Обязательно для заполнения"
        >@if(isset($translation)){!! $translation->description !!}@endif</textarea>
    </div>
</div>
