@extends('layouts.master')
@section('title', __('common.admin.list_title_page'))

@section('content')

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon2-indent-dots"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    {{ __('common.admin.list_title') }}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('admin.create') }}" class="btn btn-add btn-elevate btn-icon-sm">
                            <i class="la la-plus"></i>
                            {{ __('common.admin.add_button') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="kt-portlet__body">
            <div class="row input-daterange">
                <div class="col-md-4">
                    <input type="text" name="from_date_range" data-filter="date_from" class="form-control"
                        placeholder="{{ __('common.from_date') }}" readonly />
                </div>
                <div class="col-md-4">
                    <input type="text" name="to_date_range" data-filter="date_to" class="form-control"
                        placeholder="{{ __('common.from_date') }}" readonly />
                </div>
                <div class="col-md-4">
                    <button type="button" name="filter" id="filter"
                        class="btn btn-filter">{{ __('common.filter_button') }}</button>
                    <button type="button" name="reset" id="filter-reset"
                        class="btn btn-reset">{{ __('common.reset_button') }}</button>
                </div>
            </div>
            <div class="kt-portlet__body">
                <table class="table table-striped- table-bordered table-hover table-checkable data-table"
                    id="data-lists-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('common.table.created_date') }}</th>
                            <th>{{ __('common.table.name') }}</th>
                            <th>{{ __('common.table.email') }}</th>
                            <th>{{ __('common.table.role') }}</th>
                            <th>{{ __('common.status') }}</th>
                            <th>{{ __('common.table.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <form id="delete-form" method="POST" class="hide" action="">
        @csrf
        @method('DELETE')
    </form>
@endsection
@section('script')
    <script type="text/javascript">
        $(function() {
            const editUrl = "{{ route('admin.edit', ':id') }}";
            const deleteUrl = "{{ route('admin.delete', ':id') }}";
            $('.input-daterange').datepicker({
                todayBtn: 'linked',
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });

            const dtable = $('#data-lists-table').DataTable({
                "language": {
                    paginate: {
                        'first': @json(__('common.datatable.general.paginate.first')),
                        'last': @json(__('common.datatable.general.paginate.last')),
                    },
                    emptyTable: @json(__('common.datatable.general.emptyTable')),
                    info: @json(__('common.datatable.general.info')),
                    infoEmpty: @json(__('common.datatable.general.infoEmpty')),
                    infoFiltered: @json(__('common.datatable.general.infoFiltered')),
                    loadingRecords: @json(__('common.datatable.general.loadingRecords')),
                    processin: @json(__('common.datatable.general.processing')),
                    zeroRecords: @json(__('common.datatable.general.zeroRecords')),
                    lengthMenu: @json(__('common.datatable.general.lengthMenu')),
                    search: @json(__('common.datatable.general.search')),
                },
                processing: true,
                serverSide: true,
                pageLength: 25,
                ajax: {
                    url: "{{ route('admin.index') }}",
                    data: function(d) {
                        $("[data-filter]").each(function() {
                            d[this.dataset.filter] = this.value;
                        });
                        return d;
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'role_id',
                        name: 'role_id'
                    },
                    {
                        data: null,
                        name: 'is_active',
                        orderable: true,
                        render: function(row) {
                            let active = "{{ __('common.active') }}";
                            let inactive = "{{ __('common.inactive') }}";
                            return `<span class="badge badge-pill badge-${ row.is_active ? 'success' : 'danger'}">${ row.is_active ? active : inactive  }</span>`;
                        }
                    },
                    {
                        data: null,
                        render: function(row) {
                            return `<a href="${ editUrl.replace(':id', row.id) }" class="btn btn-primary btn-sm">{{ __('common.table.actions.edit') }}</a>
                                <a href="${ deleteUrl.replace(':id', row.id) }" data-id="${row.id}" class="btn btn-danger btn-sm ml-1 delete">{{ __('common.table.actions.delete') }}</a>`;
                        },
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $(document).on('click', 'a.delete', function(e) {
                e.preventDefault();
                var deleteId = $(this).data('id');
                var deleteRoute = deleteUrl.replace(':id', deleteId);
                Swal.fire({
                        title: "{{ __('common.delete_popup.title') }}",
                        text: "{{ __('common.delete_popup.text') }}",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: "{{ __('common.delete_popup.confirm_button') }}",
                        cancelButtonText: "{{ __('common.delete_popup.cancel_button') }}",
                    })
                    .then(function(result) {
                        if (result.value) {
                            $.ajax({
                                url: deleteRoute,
                                method: 'DELETE',
                                data: {
                                    'id': deleteId,
                                    _token: $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(result) {
                                    if (result.status == 'true') {
                                        Swal.fire({
                                            type: 'success',
                                            text: "{{ __('common.delete_popup.success_text') }}",
                                        })
                                        location.reload();
                                    } else {
                                        Swal.fire({
                                            type: 'error',
                                            text: "{{ __('common.delete_popup.error_text') }}",
                                        })
                                    }
                                }
                            });
                        }
                    });

                return false;
            });

            $('#filter').on('click', function(e) {
                let d = {};
                $("[data-filter]").each(function() {
                    d[this.dataset.filter] = this.value;
                });
                dtable.draw();
                e.preventDefault();
            });

            $('#filter-reset').on('click', function(e) {
                $("[data-filter]").each(function() {
                    this.value = "";
                });
                dtable.draw();
                e.preventDefault();
            });

        });
    </script>
@endsection
