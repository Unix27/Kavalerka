<div class="form-group row">

    <div class="col-12">
        <div style="border: 4px solid #f3f6f9">
            <div id="editor"></div>
            {{--<textarea name="content" id="editor"></textarea>--}}
        </div>
    </div>
</div>
<input type="hidden" name="content">

@push('scripts')
    <script src="{{asset('assets/admin/js/editor.js')}}"></script>

    <script>

        function loadEditor(json) {
            window.editor.isReady.then(function () {
                console.log('editor data loaded');
                window.editor.render(json)
            });
        }

        @if(isset($translation) && count($translation->content->blocks) > 0)
        loadEditor(@json($translation->content, true));
        @endif
    </script>

@endpush

@push('styles')

    <style>
        .ce-block__content {
            max-width: 99% !important;
        }

        .ce-toolbar__content {
            max-width: 100% !important;
        }

        .image-tool__image-picture {
            max-width: 400px !important;
        }

    </style>

@endpush


