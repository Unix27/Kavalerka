<select class="form-control selectpicker ml-2" data-width="200px" id="locale">
    @foreach(Localization::getSupportedLocales() as $locale => $properties)
        @if($locale == Localization::getDefaultLocale()) @continue @endif
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

            const input = $('#locale');

            const url = '{{request()->url()}}';

            input.on('change', function () {
                window.location.href = url + '?locale=' + input.val();
            })
        }

        localesInit();
    </script>

@endpush
