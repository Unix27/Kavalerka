<?php

$hasImage = (isset($post) && !empty($post->image));

?>
<div class="image-input  image-input-empty   image-input-outline" id="kt_image">
    <div class="image-input-wrapper"></div>

    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Изменить">
        <i class="fa fa-pen icon-sm text-muted"></i>
        <input type="file" name="image" accept=".png, .jpg, .jpeg"/>
        <input type="hidden" name="image_remove"/>
    </label>

    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Отменить">
		<i class="ki ki-bold-close icon-xs text-muted"></i>
	</span>

    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Удалить">
		<i class="ki ki-bold-close icon-xs text-muted"></i>
	</span>
</div>

@push('scripts')

    <script>

        function imageInit() {

            var image = new KTImageInput('kt_image', {

            });

            image.on('cancel', function(imageInput) {

            });

            image.on('change', function(imageInput) {

            });

            image.on('remove', function(imageInput) {

            });

        }

        imageInit();

    </script>

@endpush

{{----}}
