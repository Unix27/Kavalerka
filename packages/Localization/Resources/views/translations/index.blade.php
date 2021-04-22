@extends('admin::layouts.master')

@section('subheader')

    <div class="input-group input-group-sm input-group-solid max-w-175px">
        <input type="text" class="form-control pl-4" placeholder="Search..." id="generalSearch">
        <div class="input-group-append">
            <span class="input-group-text">
                <span class="svg-icon svg-icon-md">{{Metronic::getSVG('media/svg/icons/General/Search.svg')}}</span>
            </span>
        </div>
    </div>

    <select class="selectpicker group-select ml-3" data-width="200px">
        <option value="">Выберите группу</option>
        @foreach($groups as $group => $props)
            <option data-icon="fa fa-folder" value="{{$group}}"
            >{{$group}}</option>
        @endforeach
    </select>
    @include('admin::translations.partials.locale')
@endsection

@push('subheader_toolbar')
    <a href="#" onclick="showPublish()" class="btn btn-light-success font-weight-bolder btn-sm mr-2">
        <i class="fa fa-share"></i>
        Опубликовать всё
    </a>
    <a href="#" onclick="showImport()" class="btn btn-light-info font-weight-bolder btn-sm mr-2">
        <i class="fa fa-file-import"></i>
        Импорт
    </a>
    {{--<a href="{{ route('admin.blog.posts.create') }}" class="btn btn-brand btn-elevate btn-icon-sm">
        <i class="fa fa-plus"></i>
        Новая запись
    </a>--}}
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <div id="kt_table">
            </div>
        </div>
    </div>
    @include('admin::translations.partials.import')
    @include('admin::translations.partials.publish')
@endsection


@push('scripts')

    <script>
        "use strict";

        let table;

        let url = '{{route('admin.datagrid.localization.translations.index')}}';


        function setupTable(url) {

            table = $('#kt_table').KTDatatable({
                // datasource definition
                data: {
                    type: 'remote',
                    source: {
                        read: {
                            url: url,
                            // sample custom headers
                            headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),},
                            map: function (raw) {
                                // sample data mapping
                                var dataSet = raw;
                                if (typeof raw.data !== 'undefined') {
                                    dataSet = raw.data;
                                }
                                return dataSet;
                            },
                        },
                    },
                    pageSize: 10,
                    serverPaging: false,
                    serverFiltering: false,
                    serverSorting: false,
                },

                // layout definition
                layout: {
                    scroll: true,
                    footer: false,
                },

                // column sorting
                sortable: true,

                pagination: true,

                search: {
                    input: $('#generalSearch'),
                },
                extensions: {
                    checkbox: {
                        vars: {
                            selectedAllRows: 'selectedAllRows',
                            requestIds: 'requestIds',
                            rowIds: 'meta.rowIds',
                        },
                    },
                },

                // columns definition
                columns: [
                    {
                        field: 'key',
                        title: 'Ключ',
                        width: 200,
                        template: function (row) {
                            return `<code>${row.group}.${row.key}</code>`;

                        }
                    },
                        @php
                        $locale = Localization::getDefaultLocale();
                        @endphp
                    {
                        field: '{{$locale}}',
                        title: '{{$locale}}',
                        width: 200,
                        template: function (row) {

                            let id = null, value = '<span class="text-danger">Не задано</span>';
                            let hasValue = 0;

                            if (row.values['{{$locale}}']) {
                                value = row.values['{{$locale}}']['value'];
                                id = row.values['{{$locale}}']['id'];
                                hasValue = 1;
                            }
                            return `<a onclick="editValue(this, ${id}, '{{$locale}}', '${row.group}', '${row.key}')" style="text-decoration-style: dashed; text-decoration: underline" data-has-value="${hasValue}">${value}</a>`;

                        }
                    },
                        @php
                            $locale = $currentLocale;
                        @endphp
                    {
                        field: '{{$locale}}',
                        title: '{{$locale}}',
                        width: 200,
                        template: function (row) {

                            let id = null, value = '<span class="text-danger">Не задано</span>';
                            let hasValue = 0;

                            if (row.values['{{$locale}}']) {
                                value = row.values['{{$locale}}']['value'];
                                id = row.values['{{$locale}}']['id'];
                                hasValue = 1;
                            }
                            return `<a onclick="editValue(this, ${id}, '{{$locale}}', '${row.group}', '${row.key}')" style="text-decoration-style: dashed; text-decoration: underline" data-has-value="${hasValue}">${value}</a>`;

                        }
                    },

                    {
                        field: 'Actions',
                        title: '',
                        sortable: false,
                        width: 50,
                        overflow: 'visible',
                        autoHide: false,
                        template: function (row) {
                            return `
						<a href="javascript:;" onclick="deleteEntry('${row.group}', '${row.key}')" class="btn btn-sm btn-clean btn-icon btn-icon-sm" title="Удалить">
							<i class="flaticon2-trash"></i>
						</a>

					`;
                        },
                    }],

            });

        }


        jQuery(document).ready(function () {
            setupTable(url);
        });

        $('.group-select').on('change', function () {

            let reload = url + '/' + this.value;

            table.destroy();

            setupTable(reload);

        });

        function deleteEntry(group, key) {
            swal.fire({
                title: 'Вы уверены?',
                text: "Действие нельзя отменить",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Да!',
                cancelButtonText: 'Отмена'
            }).then((result) => {
                if (result.value) {

                    const url = `/admin/datagrid/localization/translations/${group}/${key}/delete`;

                    fetch(url).then(response => response.json().then(r => {
                        if (r === 'ok') {
                            swal.fire(
                                'Удалено!',
                                '',
                                'success'
                            );

                            table.reload();
                        }
                    }));
                }
            })

        }

        function editValue(el, id, locale, group, key) {

            let value = '';

            if(el.dataset.hasValue === '1') {
                value = $(el).html();
            }


            let form =
                `<div>` +
                `<textarea name="value" cols="50" rows="10" class="form-control loading">${value}</textarea>`;


            form += `<div class="mt-3">`;

            form += `<button onclick="save(this, ${id}, '${locale}', '${group}', '${key}')" class="btn btn-icon btn-sm btn-info"><i class="flaticon2-check-mark"></i></button>`;
            form += `<button onclick="closePopover(this)" class="btn btn-icon btn-sm ml-2"><i class="flaticon2-delete"></i></button>`;

            form += `</div></div>`;

            $(el).popover({
                title: 'Изменить',
                sanitize: false,
                content: function () {
                    return form;
                },
                html: true
            });

            $(el).popover('show');
        }

        function closePopover(el) {
            console.log(el);
            $(el.closest('.popover')).popover('hide')
        }

        function save(el, id, locale, group, key) {

            let value = el.closest('.popover').querySelector('textarea').value;

            const url = '{{route('admin.datagrid.localization.translations.save')}}';

            $.ajax({
                type: "POST",
                url: url,
                data: JSON.stringify(
                    {
                        translation_id: id,
                        locale: locale,
                        group: group,
                        key: key,
                        value: value,
                    }
                ),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    console.log(data);
                    table.reload();
                    closePopover(el);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    let response = $.parseJSON(jqXHR.responseText);
                    console.log(response);
                }
            });
        }

        function showImport() {
            $('#import').modal()
        }

        function showPublish() {
            $('#publish').modal()
        }

    </script>

@endpush

@push('styles')

@endpush
