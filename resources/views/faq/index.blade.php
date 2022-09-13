@extends('layouts.master')
@section('title', 'FAQ')
 
@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid" >
          @if (session()->has('success'))
            <div class="alert alert-success">
                {!! session()->get('success') !!}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {!! session()->get('error') !!}
            </div>
        @endif
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-brand flaticon2-indent-dots"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        FAQ List
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            <a href="{{ route('faq.create') }}"" class="btn btn-brand btn-elevate btn-icon-sm">
                                <i class="la la-plus"></i>
                                Add FAQ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="row input-daterange">
                <div class="col-md-4">
                    <input type="text" name="from_date_range" data-filter="date_from" id="from_date_range" class="form-control" placeholder="From Date" readonly />
                </div>
                <div class="col-md-4">
                    <input type="text" name="to_date_range" data-filter="date_to" id="to_date_range" class="form-control" placeholder="To Date" readonly />
                </div>
                <div class="col-md-4">
                    <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                    <button type="button" name="refresh" id="filter-reset" class="btn btn-default">Reset</button>
                </div>
            </div>

            <div class="kt-portlet__body">

                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable data-table" id="faqTable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Uploaded Date</th>
                        <th>FAQ</th>
                        <th>Status</th>
                        <th width="20%">Actions</th>
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
    	 var deleteRoute = '{{ route("faq.destroy", ":id") }}';
          $('.input-daterange').datepicker({
          todayBtn:'linked',
          format:'dd-M-yyyy',
          autoclose:true,
          // todayHighlight: true
         });
          const dtable = $('#faqTable').DataTable({
            processing: true,
            serverSide: true,
            order: [[ 1, "desc" ]],
            pageLength: 25,
            ajax: {
                url:'{{ route("faq.index") }}',
                data:function(d){
                    $("[data-filter]").each(function(){
                        d[this.dataset.filter] = this.value;
                    });
                    return d;
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'created_at', name: 'created_at'},
                {data: 'faq', name: 'faq'},
               
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
          $('#filter').on('click', function(e) {
            let d = {};
            $("[data-filter]").each(function(){
                d[this.dataset.filter] = this.value;
            });
            dtable.draw();
            e.preventDefault();
        });

        $('#filter-reset').on('click',function(e){
            $("[data-filter]").each(function(){
                this.value = "";
            });
            dtable.draw();
            e.preventDefault();
        });
        // $(function () {
        //     var table = $('#faqTable').DataTable({
        //         processing: true,
        //         serverSide: true,
        //         order: [[ 1, "desc" ]],
        //         ajax: "{{ route('faq.index') }}",
        //         columns: [
        //             {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
        //             {data: 'created_at', name: 'created_at'},
        //             {data: 'faq', name: 'faq'},
        //             {data: 'status', name: 'status'},
        //             {data: 'action', name: 'action', orderable: false, searchable: false},
        //         ]
        //     });
            
        // });
    </script>
     <script src="{{asset('js/faq.js')}}" type="text/javascript"></script>
@endsection

 