@extends('layouts.master')
@section('title',  __('common.farmer_group.farmer_group'))
 
@section('content')
   
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-brand flaticon2-indent-dots"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                       {{__('common.farmer_group.farmer_group_list')}}
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            <a href="{{ route('farmer_group.create') }}" class="btn btn-add btn-elevate btn-icon-sm">
                                <i class="la la-plus"></i>
                               {{__('common.farmer_group.add_farmer_group')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
           <div class="kt-portlet__body">
            <div class="row input-daterange">
                <div class="col-md-3">
                    <input type="text" data-filter="from_date" id="from_date_range" class="form-control"
                        placeholder="{{ __('common.from_date') }}" readonly />
                </div>
                <div class="col-md-3">
                    <input type="text" data-filter="to_date" id="to_date_range" class="form-control" placeholder="{{ __('common.to_date') }}"
                        readonly />
                </div>
                <div class="col-md-3">
                   
                    <select data-filter="country_id" class="form-control">
                        <option value="">{{ __('common.select_country') }}</option>
                        @foreach ($countries as $id => $country)
                            <option value="{{ $id }}">{{ $country }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="button" name="filter" id="filter" class="btn btn-filter">{{ __('common.filter_button') }}</button>
                    <button type="button" name="refresh" id="filter-reset" class="btn btn-reset">{{ __('common.reset_button') }}</button>
                </div>
            </div>

            <div class="kt-portlet__body">

                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable data-table" id="data-table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('common.table.name') }}</th>
                        <th>{{ __('common.farmer_group.number_of_farmer') }}</th>
                        <th>{{__('common.country')}}</th>
                        <th>{{ __('common.status') }}</th>
                        <th>{{ __('common.farmer_group.created_at') }}</th>
                        <th width="20%">{{ __('common.table.action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>

                <!--end: Datatable -->
            </div>
        </div>
@endsection
@section('script')
    <script type="text/javascript">
        
    	var editRoute = '{{ route("farmer_group.edit", ":id") }}';

        const dtable = $('#data-table').DataTable({
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
            order: [[ 1, "desc" ]],
            pageLength: 25,
            ajax: {
                url:'{{ route("farmer_group.index") }}',
                data:function(d){
                    $("[data-filter]").each(function(){
                        d[this.dataset.filter] = this.value;
                    });
                    return d;
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'no_of_farmers', name: 'no_of_farmers', orderable: false, searchable: false},
                {data: 'country_id', name: 'country_id'},
                {data: null, render: function(row) {
                    return `<span class="badge badge-pill badge-${row.status ? 'success' : 'danger'}">${row.status ? 'Active' : 'In-active'}</span>`
                }, searchable: false},
                {data: 'created_at', name: 'created_at'},
                {data: null, render: function(row){
                    return `<a href="${editRoute.replace(':id',row.id)}" class="btn btn-primary btn-sm"> <i class="fas fa-edit"></i></a>`;
                }, orderable: false, searchable: false},
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
@endsection

 