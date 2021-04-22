<div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Импорт</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form class="form-import" method="POST" action="{{route('admin.localization.manager.postimport')}}"
                      data-remote="true" role="form">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="form-group">
                        <div class="kt-radio-list">

                            <label class="kt-radio kt-radio--tick kt-radio--brand">
                                <input type="radio" name="replace" value="0"> Добавить новые переводы
                                <span></span>
                            </label>

                            <label class="kt-radio kt-radio--tick kt-radio--danger">
                                <input type="radio" name="replace" value="1"> Заменить существующие переводы
                                <span></span>
                            </label>

                        </div>
                        <button type="submit" class="btn btn-success btn btn-elevate-air center mt-4"
                                data-disable-with="Loading..">
                            Импорт
                        </button>
                    </div>
                </form>

                <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg kt-separator--portlet-fit"></div>

                <form class="form-find" method="POST" action="{{route('admin.localization.manager.postfind')}}"
                      data-remote="true" role="form"
                      data-confirm="Are you sure you want to scan you app folder? All found translation keys will be added to the database.">
                    <div class="form-group">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <button type="submit" class="btn btn-info" data-disable-with="Searching..">
                            Найти переводы в файлах blade
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>