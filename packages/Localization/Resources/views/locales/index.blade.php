@extends('admin::layouts.master')

@section('title')
    {{__('localization::locales.languages')}}
@endsection

@section('subheader')
    {!! $datagrid->getSearchInput() !!}
@endsection

@section('content')

    <div class="card">
        <div class="card-body">
            {{ $datagrid->render() }}
        </div>
    </div>


@endsection


@push('scripts')
    <script>

        function makeDefault(id) {

            const url = '{{route('admin.datagrid.localization.locales.default')}}';

            $.ajax({
                type: "POST",
                url: url,
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: JSON.stringify({
                    id: id
                }),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    console.log(data);
                    table.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    let response = $.parseJSON(jqXHR.responseText);
                    console.log(response);
                }
            });
        }

        function toggleActive(id) {

            const url = '{{route('admin.datagrid.localization.locales.active')}}';

            $.ajax({
                type: "POST",
                url: url,
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: JSON.stringify({
                    id: id
                }),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    console.log(data);
                    table.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    let response = $.parseJSON(jqXHR.responseText);
                    console.log(response);
                }
            });
        }

        function togglePublish(id) {

            const url = '{{route('admin.datagrid.localization.locales.publish')}}';

            $.ajax({
                type: "POST",
                url: url,
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: JSON.stringify({
                    id: id
                }),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    console.log(data);
                    table.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    let response = $.parseJSON(jqXHR.responseText);
                    console.log(response);
                }
            });
        }

    </script>

@endpush

@push('styles')


    <style>
        .dataTable {
            font-size: 14px;
        }

        .kt-datatable__pager-info {
            display: none;
        }

        .muted {
            opacity: .5;
        }

        th span {
            font-weight: 700 !important;
        }
    </style>
@endpush
