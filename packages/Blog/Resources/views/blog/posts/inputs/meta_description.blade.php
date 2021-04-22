<div class="form-group row">
    <label class="col-3 col-form-label">Meta description</label>
    <div class="col-9">
        <textarea class="form-control" type="text"
               name="meta_description" data-msg="Обязательно для заполнения"
        >@if(isset($translation)){!! $translation->meta_description !!}@endif</textarea>
    </div>
</div>
