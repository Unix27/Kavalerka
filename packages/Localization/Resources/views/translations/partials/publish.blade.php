<div class="modal fade" id="publish" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Опубликовать всё</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Вы уверены, что хотите опубликовать всю группу переводов? Это перезапишет существующие языковые файлы.
                </p>
            </div>
            <div class="modal-footer">
                <form class="form-inline form-publish-all" method="POST"
                      action="{{route('admin.localization.manager.postpublish')}}" data-remote="true" role="form"
                      data-confirm="Are you sure you want to publish all translations group? This will overwrite existing language files.">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <button type="submit" class="btn btn-primary" data-disable-with="Publishing..">Опубликовать
                    </button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>