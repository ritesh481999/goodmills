@extends('layouts.master')
@section('title', __('common.bid.manage_bid'))

@section('content')
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon2-indent-dots"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    {{ __('common.bid.manage_bid') }}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('bid.create') }}" class="btn btn-add btn-elevate btn-icon-sm">
                            <i class="la la-plus"></i>
                            {{ __('common.bid.add_bid') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="row input-daterange">
                <div class="col-md-4">
                    <input type="text" name="from_date_range" data-filter="from_date" id="from_date_range"
                        class="form-control" placeholder="{{__('common.from_date')}}" readonly />
                </div>
                <div class="col-md-4">
                    <input type="text" name="to_date_range" data-filter="to_date" id="to_date_range" class="form-control"
                        placeholder="{{__('common.to_date')}}" readonly />
                </div>
                <div class="col-md-4">
                    <button type="button" name="filter" id="filter" class="btn btn-filter">{{ __('common.filter_button') }}</button>
                    <button type="button" name="refresh" id="filter-reset" class="btn btn-reset">{{ __('common.reset_button') }}</button>
                </div>
            </div>

            <div class="kt-portlet__body">

                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable data-table" id="bidTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('common.bid.bid_date') }}</th>
                            <th>{{ __('common.bid.bid_name') }}</th>
                            <th>{{ __('common.bid.month') }}</th>
                            <th>{{ __('common.bid.no_of_user') }}</th>
                            <th>{{ __('common.bid.bid_accepted') }}</th>
                            <th>{{ __('common.bid.validity') }}</th>
                            <th>{{ __('common.bid.view') }}</th>
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
        $('.input-daterange').datepicker({
            todayBtn: 'linked',
            format: 'dd-M-yyyy',
            autoclose: true,
            // todayHighlight: true
        });
        const viewUrl = "{{ route('bid.show', '#ID') }}"
        const dtable = $('#bidTable').DataTable({
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
            responsive: true,
            processing: true,
            serverSide: true,
            order: [
                [1, "desc"]
            ],
            pageLength: 25,
            ajax: {
                url: '{{ route('bid.index') }}',
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
                    data: 'bid_name',
                    name: 'bid_name'
                },
                {
                    data: 'month_of_movement_display',
                    orderable: true,
                    searchable: false
                },
                {
                    data: 'no_of_farmer',
                    name: 'no_of_farmer',
                    orderable: false,
                    searchable: false
                },
                {
                    data: null,
                    render: function(row) {
                        return row.total_bid_accepted + ' out of ' + row.max_tonnage;
                    },
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'valid_till',
                    name: 'valid_till'
                },
                {
                    data: null,
                    render: function(row) {
                        return `<a href="${viewUrl.replace('#ID',row.id)}" class="btn btn-primary btn-sm"><i class="far fa-eye"></i></a>`;
                    },
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
    <script src="{{ asset('js/bid.js') }}" type="text/javascript"></script>
@endsection
