@extends('layouts.master') 
@section('title', __('common.static_contents.list_title_page'))

@section('content')

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon2-indent-dots"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                {{ __('common.static_contents.list_title') }}
                </h3>
            </div>
        </div>




        <div class="kt-portlet__body">

            <!--begin: Datatable -->
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ __('common.table.static_pages') }}</th>
                        <th scope="col">{{ __('common.table.action') }}</th>
                    </tr>
                </thead>
                <tbody>


                    @foreach ($contents as $key => $content)
                        <tr>

                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $content['name'] }}</td>
                            <td>
                                <a href="{{ route('static_contents.edit', $content['slug']) }}"
                                    class="btn btn-primary btn-sm editNews">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="javascript:void(0)" data-id="{{ $key + 1 }}"
                                    data-url="{{ route('static_contents.destroy', $key + 1) }}"
                                    class="btn btn-danger btn-sm deleteRow">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>


                        </tr>
                    @endforeach

                </tbody>
            </table>

            <!--end: Datatable -->
        </div>
    </div>

    <form id="delete-form" method="POST" class="hide" action="">
        @csrf
        @method('DELETE');
    </form>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $(document).on("click", ".deleteRow", function(event) {
                event.preventDefault();

                var deleteUrl = $(this).data("url");
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });

                Swal.fire({
                    title: "{{ __('common.delete_popup.title') }}",
                    text: "{{ __('common.delete_popup.text') }}",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText:"{{ __('common.delete_popup.confirm_button') }}",
                    cancelButtonText: "{{ __('common.delete_popup.cancel_button') }}",
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: deleteUrl,
                            method: "DELETE",
                            success: function(result) {
                                if (result.status == "true") {
                                    Swal.fire({
                                        type: "success",
                                        ext: "{{ __('common.delete_popup.success_text') }}",
                                    });
                                    location.reload();
                                } else {
                                    Swal.fire({
                                        type: "error",
                                        text: "{{ __('common.delete_popup.error_text') }}",
                                    });
                                }
                            },
                        });
                    }
                });
            });
        })
    </script>

@endsection
