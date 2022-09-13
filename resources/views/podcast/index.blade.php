@extends('layouts.master')
@section('title', 'Podcast')

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
                        Podcast List
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            <a href="{{ route('podcast.create') }}" class="btn btn-brand btn-elevate btn-icon-sm">
                                <i class="la la-plus"></i>
                                Add Podcast
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="kt-portlet__body">
                <div class="row input-daterange">
                <div class="col-md-4">
                    <input type="text" name="from_date_range" data-filter="date_from" class="form-control" placeholder="From Date" readonly />
                </div>
                <div class="col-md-4">
                    <input type="text" name="to_date_range" data-filter="date_to"  class="form-control" placeholder="To Date" readonly />
                </div>
                <div class="col-md-4">
                    <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                    <button type="button" name="reset" id="filter-reset" class="btn btn-default">Reset</button>
                </div>
            </div>

            <div class="kt-portlet__body">

                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable data-table" id="data-lists-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>#</th>
                            <th>Uploaded Date</th>
                            <th>Title</th>
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
    <form id="delete-form" method="POST" class="hide" action="">
        @csrf
        @method('DELETE');
    </form>
@endsection
@section('script')
    <script type="text/javascript">
        $(function () {
            const viewUrl = "{{ route('podcast.edit',':id') }}";
            const deleteUrl = "{{ route('podcast.destroy', ':id') }}";

            $('.input-daterange').datepicker({
                todayBtn:'linked',
                format:'dd-M-yyyy',
                autoclose:true,
                // todayHighlight: true
            });
                
            const dtable = $('#data-lists-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                ajax: {
                    url: "{{ route('podcast.index') }}",
                    data:function(d){
                        $("[data-filter]").each(function(){
                            d[this.dataset.filter] = this.value;
                        });
                        return d;
                    }
                },
                order: [[0, "desc" ]],
                columns: [
                    {data:'id', name: 'id', orderable:true, searchable:false, visible:false},
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'title', name: 'title'},
                    {data: null, render: function(row){
                        return `<span class="badge badge-pill badge-${ row.status ? 'success' : 'danger'}">${ row.status ? 'Active' : 'In-Active'}</span>`;
                    }, name: 'status'},
                    {data: null, render: function(row){
                        return `<a href="${ viewUrl.replace(':id', row.id) }" class="btn btn-primary btn-sm">Edit</a>
                        <a href="${ deleteUrl.replace(':id', row.id) }" class="btn btn-danger btn-sm ml-1 delete">Delete</a>`;
                    }, orderable: false, searchable: false},
                ]
            });

            $(document).on('click', 'a.delete', function(e){
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
                    if(res.value){
                        let action = me.getAttribute('href');
                        $('form#delete-form').attr('action', action).submit();
                    }
                });
                
                return false;
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
            
        });

        
    </script>
@endsection

