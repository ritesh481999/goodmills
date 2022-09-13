@extends('layouts.master')
@section('title', __('common.masters.label.commodity'))

@section('content')

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon2-indent-dots"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    {{ __('common.masters.commodity.commodity_list') }}
                </h3>
            </div>

            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('masters') }}" class="btn btn-add btn-elevate btn-icon-sm">
                            <i class="la la-left"></i>
                            {{ __('common.back_to_masters') }}
                        </a>
                        <a href="{{ route('commodity.create') }}" class="  btn btn-add btn-elevate btn-icon-sm">
                            <i class="la la-plus"></i>
                            {{ __('common.masters.commodity.add_commodity') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="row input-daterange">
                <div class="col-md-4">
                    <input type="text" data-filter="from_date" id="from_date_range" class="form-control"
                        placeholder="From Date" readonly />
                </div>
                <div class="col-md-4">
                    <input type="text" data-filter="to_date" id="to_date_range" class="form-control" placeholder="To Date"
                        readonly />
                </div>
                <div class="col-md-4">
                    <button type="button" name="filter" id="filter" class="btn btn-filter">Filter</button>
                    <button type="button" name="refresh" id="filter-reset" class="btn btn-reset">Reset</button>
                </div>
            </div>
            <div class="kt-portlet__body">
                <table class="table table-striped- table-bordered table-hover table-checkable data-table"
                    id="commodityTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('common.created_date') }}</th>
                            <th>{{ __('common.masters.commodity.commodity_name') }}</th>
                            <th>{{ __('common.status') }}</th>
                            <th width="20%">{{ __('common.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        var deleteRoute = "{{ route('commodity.destroy', ':id') }}";

        const dtable = $('#commodityTable').DataTable({
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
            order: [
                [1, "desc"]
            ],
            pageLength: 25,
            ajax: {
                url: '{{ route('commodity.index') }}',
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
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
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
    </script>
    <script src="{{ asset('js/commodity.js') }}" type="text/javascript"></script>
@endsection
