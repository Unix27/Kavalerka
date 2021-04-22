@if ($paginator->hasPages())
        <ul class="" >
            {{-- Previous Page Link --}}
{{--            @if ($paginator->onFirstPage())--}}
{{--                <li class="disabled page-item page-item__prev hidden" aria-disabled="true" aria-label="@lang('pagination.previous')">--}}
{{--                    <div class="page-item__icon page-item__icon--prev icon__chevron-left"></div>--}}
{{--                    <a class="page-link" aria-hidden="true">Назад</a>--}}
{{--                </li>--}}
{{--            @else--}}
{{--                <li class="page-item page-item__prev ">--}}
{{--                    <div class="page-item__icon page-item__icon--prev icon__chevron-left"></div>--}}
{{--                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">--}}
{{--                        Назад--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            @endif--}}

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="js-active page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
{{--            @if ($paginator->hasMorePages())--}}
{{--                <li class="page-item page-item__next ">--}}
{{--                    <div class="page-item__icon page-item__icon--next icon__chevron-right"></div>--}}
{{--                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">Вперед</a>--}}
{{--                </li>--}}
{{--            @else--}}
{{--                <li class="page-item disabled hidden page-item__next" aria-disabled="true" aria-label="@lang('pagination.next')">--}}
{{--                    <div class="page-item__icon page-item__icon--next icon__chevron-right"></div>--}}
{{--                    <a class="page-link" aria-hidden="true">Вперед</a>--}}
{{--                </li>--}}
{{--            @endif--}}
        </ul>
@endif
