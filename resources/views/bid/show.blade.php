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
                    {{ __('common.bid.bid_details') }}
                </h3>
            </div>
            <div class="back-url-div">
                <a href="{{ route('bid.index') }}" class="btn btn-brand btn-elevate btn-icon-sm back-url">
                    {{ __('common.back_button') }}
                </a>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <!-- <a href="{{ route('bid.create') }}"" class="btn btn-brand btn-elevate btn-icon-sm">
                                                                            <i class="la la-plus"></i>
                                                                            Add Bid
                                                                        </a> -->
                    </div>
                </div>
            </div>
        </div>


        <div class="kt-portlet__body">

            <!--begin: table -->
            <table class="table table-striped- table-bordered table-hover table-checkable data-table">
                <thead>
                    <tr>
                        <th>{{ __('common.bid.bid_id') }}</th>
                        <td>{{ $bid->bid_code }}</td>

                    </tr>
                    <tr>
                        <th>{{ __('common.bid.bid_name') }}</th>
                        <td>{{ $bid->bid_name }}</td>

                    </tr>
                    <tr>
                        <th> {{ __('common.bid.publish_on') }} </th>
                        <td> {{ $bid->publish_on }} </td>
                    </tr>
                    <tr>
                        <th>{{ __('common.bid.month') }} </th>
                        <td> {{ $bid->month_of_movement_display }} </td>
                    </tr>
                    <tr>
                        <th> {{ __('common.bid.commodity') }} </th>
                        <td> {{ $bid->commodity->name ?? '-' }} </td>
                    </tr>
                    <tr>
                        <th> {{ __('common.bid.variety') }} </th>
                        <td> {{ $bid->variety->name ?? '-' }} </td>
                    </tr>
                    <tr>
                        <th> {{ __('common.bid.specification') }} </th>
                        <td> {{ $bid->specification->name ?? '-' }} </td>
                    </tr>
                    <tr>
                        <th> {{ __('common.bid.max_tonnage') }} </th>
                        <td> {{ $bid->max_tonnage }} </td>
                    </tr>
                    <tr>
                        <th>{{ __('common.bid.price') }} </th>
                        <td> {{ $bid->price }} </td>
                    </tr>
                    <tr>
                        <th> {{ __('common.bid.validity') }} </th>
                        <td> {{ displayDateTime($bid->valid_till) }} </td>
                    </tr>
                    <tr>
                        <th> {{ __('common.bid.bid_location') }} </th>
                        <td>
                            {{ $bid->bidLocation->implode('name', ', ') }}
                        </td>
                    </tr>
                    <tr>
                        <th>{{ __('common.bid.delivery_method') }}</th>
                        <td>
                            @if ($bid->delivery_method == 1)
                                Ex-Farm
                            @elseif($bid->delivery_method == 2)Delivery
                            @else -
                            @endif
                        </td>
                    </tr>
                    @if ($bid->delivery_method == 2)
                        <tr>
                            <th>{{ __('common.bid.delivery_location') }}</th>
                            <td>
                                {{ $bid->delivery->name ?? '-' }}
                            </td>
                        </tr>
                    @elseif($bid->delivery_method == 1)
                        <tr>
                            <th>{{ __('common.bid.delivery_address') }}</th>
                            <td>
                                {{ $bid->delivery_address ?? '-' }}
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th>{{ __('common.bid.postal_code') }}</th>
                        <td>
                            {{ $bid->postal_code ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <th>{{ __('common.bid.number_of_users') }}</th>
                        <td>{{ $bid->bidFarmer->count() }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('common.bid.status') }}</th>
                        <td>
                            <form action="{{ route('bid.update_status', $bid->id) }}" method="post">

                                <div>
                                    <label for="status-active">
                                        <input type="radio" name="status" value="1" class=""
                                            id="status-active" {{ $bid->status == 1 ? 'checked' : '' }}>
                                        {{ __('common.active') }}
                                    </label>

                                    <label for="status-inactive" style="padding-left: 2%;">
                                        <input type="radio" name="status" value="0" class=""
                                            id="status-inactive" {{ $bid->status == 0 ? 'checked' : '' }}>
                                        {{ __('common.inactive') }}
                                    </label>

                                    <button style="margin-left: 10%;" type="submit"
                                        class="btn btn-success btn-sm">{{ __('common.bid.update') }}</button>
                                </div>
                                @method('PATCH')
                                @csrf
                            </form>
                        </td>
                    </tr>

                </thead>
                <tbody>

                </tbody>
            </table>

            <!--end: table -->
            <!--begin: Datatable -->

            <table class="table table-striped- table-bordered table-hover table-checkable data-table" id="bid_userTable">
                <thead>
                    <tr>
                        <th>{{ __('common.bid.id') }}</th>
                        <th>{{ __('common.bid.username') }}</th>
                        <th>{{ __('common.bid.tonnage') }}</th>
                        <th>{{ __('common.bid.counter_offer') }}</th>
                        <th>{{ __('common.bid.bid_status') }}</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <!--end: Datatable -->

        </div>

    </div>

    <div class="modal" tabindex="-1" role="dialog" id="reject-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="counterOfferReasonForm">
                        @csrf
                        <input type="hidden" name="farmer_id" id="farmer_id">
                        <input type="hidden" name="bid_id" id="bid_id">
                        <div class="form-group">
                            {!! Html::decode(Form::label('farmer', 'Username', ['class' => 'col-md-4 control-label'])) !!}
                            <div class="col-md-6">
                                <b><span id="username"></span></b>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="reason">{{ __('common.selling_request.reson_popup.form.reason.label') }}</label>
                            <input type="text" id="reason" name="reason" class="form-control"
                                placeholder="{{ __('common.selling_request.reson_popup.form.reason.placeholder') }}"
                                data-parsley-required='true'
                                data-parsley-required-message="{{ __('common.selling_request.reson_popup.form.reason.required') }}" />

                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $('.input-daterange').datepicker({
            todayBtn: 'linked',
            format: 'yyyy-mm-dd',
            autoclose: true
        });
        const dtable = $('#bid_userTable').DataTable({
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
                processing: @json(__('common.datatable.general.processing')),
                zeroRecords: @json(__('common.datatable.general.zeroRecords')),
                lengthMenu: @json(__('common.datatable.general.lengthMenu')),
                search: @json(__('common.datatable.general.search')),
            },

            processing: true,
            serverSide: true,
            searchDelay: 1000,
            order: [
                [1, "desc"]
            ],
            ajax: {
                url: '{{ route('bid.show', $bid->id) }}'
            },
            columns: [{
                    data: 'user_id',
                    name: 'farmers.id'
                },
                {
                    data: 'username',
                    name: 'farmers.username'
                },
                {
                    data: 'tonnage',
                    name: 'bid_farmers.tonnage'
                },
                {
                    data: 'counter_offer',
                    name: 'bid_farmers.counter_offer'
                },
                {
                    data: null,
                    name: 'bid_farmers.status',
                    orderable: false,
                    searchable: false,
                    render: function(row) {
                        if (row.status == 0) {
                            let g = 'Pending';

                            if ({{ $isExpired ? 1 : 0 }})
                                g += ' (Bid is expired)';
                            else if (!{{ $bid->status }})
                                g += ' (Bid is in-active)';
                            return `<span class="badge badge-pill badge-info">${g}</span>`;
                        } else if (row.status == 1) {
                            return `<span class="badge badge-pill badge-success">Accepted</span>`;
                        } else if (row.status == 2) {
                            if (row.counter_offer > 0) {

                                $status = `<span class="badge badge-pill badge-danger">Rejected/Counter-offer received</span> &nbsp <a href="javascript:void(0)" class="accept_btn btn btn-outline-success btn-sm"  bid-id='${row.bid_id}' farmer-id="${row.farmer_id}">
                        <i class="fa fa-check" aria-hidden="true"></i>
                            </a>
                            <a href="javascript:void(0)" 
                            class="reject_btn btn btn-outline-danger btn-sm" bid-id='${row.bid_id}' farmer-id="${row.farmer_id}" farmer-name ="${row.username}">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </a>`;
                                return $status;
                            } else {
                                return `<span class="badge badge-pill badge-danger">Rejected</span>`;
                            }

                        } else if (row.status == 3) {

                            return `<span class="badge badge-pill badge-success">Counter-offer accepted by admin</span>`;


                        } else if (row.status == 4) {
                            $status = `<span class="badge badge-pill badge-danger">Counter-offer rejected by admin</span> &nbsp;(<span style="color:red">Reason</span>:- <b>${row.reason} </b>)`
                            return $status;


                        } else
                            return '-';
                    }
                },

            ]
        });
        $(document).on("click", ".accept_btn", function() {
            let bid_id = $(this).attr('bid-id');
            let farmer_id = $(this).attr('farmer-id');

            Swal.fire({
                title: 'Do You Want To Accept',
                text: 'Are you sure?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('bid.accept') }}",
                        method: 'POST',
                        data: {
                            'bid_id': bid_id,
                            'farmer_id': farmer_id,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(result) {
                            if (result.status == 'true') {
                                Swal.fire({
                                    type: 'success',
                                    text: 'Accepted',
                                })
                                $('#bid_userTable').DataTable().ajax.reload(null, false);
                            } else {
                                Swal.fire({
                                    type: 'error',
                                    text: 'Failed to delete',
                                })
                            }
                        }
                    });
                }
            });
        });

        $(document).on("click", ".reject_btn", function() {
            let bid_id = $(this).attr('bid-id');
            let farmer_id = $(this).attr('farmer-id');
            let username = $(this).attr('farmer-name');
            Swal.fire({
                title: 'Do You Want To Reject',
                text: 'Are you sure?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.value) {
                    $('.modal-title').text("{{ __('common.selling_request.reson_popup.title') }}");
                    $('#farmer_id').val(farmer_id);
                    $('#bid_id').val(bid_id);
                    $('#username').html(username);
                    $('#reject-modal').modal('show');
                }
            });
        });
        $('#counterOfferReasonForm').parsley();
            $('#counterOfferReasonForm').on('submit', function(event) {
                event.preventDefault();
             
                $.ajax({
                    url: "{{ route('bid.reject') }}",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",

                    success: function(response) {
                        console.log("success");
                        if (response.status == 'true') {
                          
                            //$loading.hide();
                            $('#counterOfferReasonForm')[0].reset();
                            $('#reject-modal').modal('hide');
                            $('#bid_userTable').DataTable().ajax.reload(null,
                                false);
                        }
                    }
                })
            });
        // 
    </script>
  

@endsection
