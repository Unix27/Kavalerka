<div class="form-group row">
    <div class="col-12">
        <div id="scrolling-container" class="quill-editor">
            <div id="editor-{{$locale}}" class="text-editor">
                @if(isset($translation)) {!! $translation->content !!} @endif
            </div>
            <input type="hidden" name="translations[{{$locale}}][content]" id="content-{{$locale}}"
                   value="{{isset($translation) ? $translation->content : ''}} ">
        </div>
    </div>
</div>

@push('scripts')
    <script>

        var toolbarOptions = [
            // [{ 'font': fonts }],
            // [{ 'header': 1 }, { 'header': 2 }],
            [{'header': [1, 2, 3, 4, 5, 6, false]}],
            // [{ 'size': ['small', false, 'large', 'huge'] }],
            ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
            ['blockquote'],

            [{'list': 'ordered'}, {'list': 'bullet'}],
            // [{ 'script': 'sub'}, { 'script': 'super' }],
            // [{ 'indent': '-1'}, { 'indent': '+1' }],
            // [{ 'direction': 'rtl' }],

            [{'color': []}, {'background': []}],
            ['link'],

            [{align: ''}, {align: 'right'}, {align: 'center'}, {align: 'justify'}],
            ['image', 'video'],
            ['clean'],

        ];

        var quill = new Quill('#editor-{{$locale}}', {
            theme: 'snow',
            modules: {
                toolbar: toolbarOptions
            },
            scrollingContainer: '#scrolling-container',
        });
        quill.on('text-change', function (delta, oldDelta, source) {

            let editorContent = document.querySelector('#editor-{{$locale}}').children[0].innerHTML;

            $('#content-{{$locale}}').val(editorContent);
        });

    </script>
@endpush

@push('styles')

    <style>
        .ql-editor p {
            margin: 20px 0 !important;
        }

        .ql-tooltip {
            left: 20px !important;
        }

        .ql-editor {
            max-height: calc(100vh - 250px);
            color: #212529 !important;
        }

        .ql-editor p:first-child {
            margin-top: 0;
        !important;
        }

        /*.ql-toolbar{
            position: fixed;
            z-index: 100;

        }*/
        #scrolling-container {
            height: 100%;
            min-height: 100%;
            max-height: 100%;
            overflow-y: auto;
        }
    </style>

@endpush
