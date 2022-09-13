@extends('layouts.master')
@section('title', __('common.selling_request.list_title_page'))

@section('content')

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon2-indent-dots"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    {{ __('common.selling_request.list_title') }}
                </h3>
            </div>

        </div>

        <div class="kt-portlet__body">
            <div class="row input-daterange">
                <div class="col-md-3">
                    <input type="text" name="from_date_range" data-filter="date_from" class="form-control"
                        placeholder="{{ __('common.from_date') }}" readonly />
                </div>
                <div class="col-md-3">
                    <input type="text" name="to_date_range" data-filter="date_to" class="form-control"
                        placeholder="{{ __('common.to_date') }}" readonly />
                </div>
                <div class="col-md-3">
                    <select data-filter="status" class="form-control">
                        <option value="">{{ __('common.all') }}</option>
                        @foreach ($statuses as $status => $label)
                            <option value="{{ $status }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="button" name="filter" id="filter"
                        class="btn btn-filter">{{ __('common.filter_button') }}</button>
                    <button type="button" name="reset" id="filter-reset"
                        class="btn btn-reset">{{ __('common.reset_button') }}</button>
                </div>
            </div>

            <div class="kt-portlet__body">

                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable data-table"
                    id="data-lists-table">
                    <thead>
                        <tr>
                            <th>{{ __('common.table.id') }}</th>
                            <th>#</th>
                            <th>{{ __('common.table.month') }}</th>
                            <th>{{ __('common.table.username') }}</th>
                            <th>{{ __('common.table.status') }}</th>
                            <th>{{ __('common.table.date_submitted') }}</th>
                            <th>{{ __('common.table.view') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

                <!--end: Datatable -->
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(function() {

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
                    url: "{{ route('selling_request.index') }}",
                    data: function(d) {
                        $("[data-filter]").each(function() {
                            d[this.dataset.filter] = this.value;
                        });
                        return d;
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        orderable: true,
                        searchable: false,
                        visible: false
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'date_of_movement',
                        name: 'date_of_movement',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'farmers',
                        name: 'farmer.username',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: true
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: null,
                        render: function(row) {
                            const view_url = "{{ route('selling_request.show', ':id') }}"
                                .replace(':id', row.id);
                            return `<a href="${ view_url }" class="edit btn btn-primary btn-sm"><i class="far fa-eye"></i></a>`;
                        },
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [0, "desc"]
                ],
            });

            $(document).on('click', 'a.delete', function(e) {
                e.preventDefault();
                let me = this;
                Swal.fire({
                        title: 'Do You Want To Delete',
                        text: 'Are you sure?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'Cancel',
                    })
                    .then(function(res) {
                        if (res.value) {
                            let action = me.getAttribute('href');
                            $('form#delete-form').attr('action', action).submit();
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
