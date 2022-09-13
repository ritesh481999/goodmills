@extends('layouts.master')
@section('title',__('common.bid_location.bid_location_title'))

@section('content')

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon2-indent-dots"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    {{ __('common.bid_location.bid_location_list') }}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('bid_location.create') }}" class="btn btn-add btn-elevate btn-icon-sm">
                            <i class="la la-plus"></i>
                            {{ __('common.bid_location.add_bid_location') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="kt-portlet__body">
            <div class="row input-daterange">
                <div class="col-md-4">
                    <input type="text" name="from_date_range" data-filter="date_from" class="form-control"
                        placeholder="{{__('common.from_date')}}" readonly />
                </div>
                <div class="col-md-4">
                    <input type="text" name="to_date_range" data-filter="date_to" class="form-control"
                        placeholder="{{__('common.to_date')}}" readonly />
                </div>
                <div class="col-md-4">
                    <button type="button" name="filter" id="filter" class="btn btn-filter">{{ __('common.filter_button') }}</button>
                    <button type="button" name="reset" id="filter-reset" class="btn btn-reset">{{ __('common.reset_button') }}</button>
                </div>
            </div>

            <div class="kt-portlet__body">

                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable data-table"
                    id="data-lists-table">
                    <thead>
                        <tr>
                            <th>{{ __('bid_location.id') }}</th>
                            <th>#</th>
                            <th>{{ __('common.created_date') }}</th>
                            <th>{{ __('common.bid_location.bid_location_name') }}</th>
                            <th>{{ __('common.status') }}</th>
                            <th>{{ __('common.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

                <!--end: Datatable -->
            </div>
        </div>
    </div>
    <form id="delete-form" method="POST" class="hide" action="">
        @csrf
        @method('DELETE');
    </form>
@endsection
@section('script')
    <script type="text/javascript">
        $(function() {

            $('.input-daterange').datepicker({
                todayBtn: 'linked',
                format: 'dd-M-yyyy',
                autoclose: true,
                // todayHighlight: true
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
                    url: "{{ route('bid_location.index') }}",
                    data: function(d) {
                        $("[data-filter]").each(function() {
                            d[this.dataset.filter] = this.value;
                        });
                        return d;
                    }
                },
                order: [
                    [0, "desc"]
                ],
                columns: [{
                        data: 'id',
                        name: 'id',
                        searchable: false,
                        orderable: true,
                        visible: false
                    },
                    {
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

        });
    </script>
@endsection
