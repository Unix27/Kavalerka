<div class="form-group row">
    <label class="col-3 col-form-label">Slug</label>
    <div class="col-9">
        <input class="form-control" type="text"
               @if(isset($model)) value="{{$model->slug}}" @endif
               name="slug" id="slug" placeholder="">
    </div>
</div>
