<?php

$currentLocale = $editorLocale ?? Localization::getDefaultLocale()

?>

<select class="form-control selectpicker" data-width="200px" name="locale">
    @foreach($locales as $locale => $properties)
        @php
            $countryCode = mb_strtolower(explode('_', $properties['regional'])[1]);

                $icon = "<span class='symbol symbol-20 mr-3'>" .
                "<img src='". asset('images/flags/' . $countryCode . '.svg') . "'>" .
                "</span>";

                $dataContent = "<div style='display:flex; align-items:center'>$icon $properties[name] [$locale]</div>";
        @endphp
        <option data-content="{{$dataContent}}"
                @if($locale == $currentLocale) selected @endif
        >{{$locale}}
        </option>
    @endforeach
</select>

@push('scripts')

    <script>
        function localesInit() {

            const input = $('[name=locale]');

            const url = '{{request()->url()}}';

            input.on('change', function () {
                window.location.href = url + '?locale=' + input.val();
            })
        }

        @if(isset($post))
            localesInit();
        @endif
    </script>

@endpush
