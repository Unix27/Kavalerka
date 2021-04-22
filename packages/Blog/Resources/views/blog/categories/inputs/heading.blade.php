<div class="form-group row">
    <label class="col-3 col-form-label">Заголовок</label>
    <div class="col-9">
        <input class="form-control" type="text"
               @if(isset($translation)) value="{{$translation->heading}}" @endif
               name="heading" data-msg="Обязательно для заполнения">
    </div>
</div>
