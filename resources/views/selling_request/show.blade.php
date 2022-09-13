@extends('layouts.master')
@section('title', __('common.selling_request.details_title_page'))

@section('content')

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon2-indent-dots"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                {{ __('common.selling_request.details_title') }} 
                </h3>
            </div>
            <div class="back-url-div">
                <a href="{{ route('selling_request.index') }}" class="btn btn-brand btn-elevate btn-icon-sm back-url">
                {{ __('common.back_button') }}
                </a>
            </div>
        </div>

        <div class="kt-portlet__body">
            <div class="row">
                <div class="col-md-4">
                    <table class="table table-borderless">
                        <tbody>
                            @if ($item->bid)
                                <tr>
                                    <th>{{ __('common.selling_request.details.bid_id.label') }}</th>
                                    <td>{{ $item->bid->bid_code }}</td>
                                </tr>
                            @endif

                            <tr>
                                <th>{{ __('common.selling_request.details.user_id.label') }}</th>
                                <td>{{ $item->farmer->id ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('common.selling_request.details.username.label') }}</th>
                                <td>{{ $item->farmer->name ?? '-' }} @if($item->farmer->deleted_at != null) <span class="badge badge-danger">Deleted</span> @endif</td>
                            </tr>
                            <tr>
                                <th>{{ __('common.selling_request.details.month.label') }}</th>
                                <td>{{ displayMonthYear($item->date_of_movement) ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('common.selling_request.details.tonnage.label') }}</th>
                                <td>{{ $item->tonnage ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('common.selling_request.details.commodity.label') }}</th>
                                <td>{{ $item->commodity->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('common.selling_request.details.variety.label') }}</th>
                                <td>{{ $item->variety->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('common.selling_request.details.specification.label') }}</th>
                                <td>{{ $item->specification->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('common.selling_request.details.delivery_type.label') }}</th>
                                <td>{{ $item->delivery_method == 1 ? 'Ex-Farm' : 'Deliver' }}</td>
                            </tr>
                            @if($item->delivery_method == 2)
                            <tr>
                                <th>{{__('common.bid.delivery_location')}}</th>
                                <td>
                                    {{ $item->deliveryLocation->name ?? '-' }}
                                </td>
                            </tr>
                            @elseif($item->delivery_method == 1)
                            <tr>
                                <th>{{__('common.bid.delivery_address')}}</th>
                                <td>
                                    {{ $item->delivery_address ?? '-' }}
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <th>{{ __('common.selling_request.details.postal_code.label') }}</th>
                                <td>
                                    {{ $item->postal_code ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('common.status') }}</th>
                            @switch($item->status)
                                @case(1)
        
                                        <td><span class="badge badge-primary">{{selling_request_status(1)}}</span></td>
                                  
                                @break
                                @case(2)
                                     
                                        <td><span class="badge badge-success">{{selling_request_status(2)}}</span></td>
                                    
                                @break
                                @case(3)
                                    
                                        <td><span class="badge badge-danger">{{selling_request_status(3)}}</span></td>
                                    
                                @break
                                @case(4)
                                    
                                        <td><span class="badge badge-success">{{selling_request_status(4)}}</span></td>
                                   
                                @break
                                @case(5)
                                   
                                        <td><span class="badge badge-danger">{{selling_request_status(5)}}</span></td>
                                   
                                @break

                                @case(6)
                                    
                                        <td><span class="badge badge-success">{{selling_request_status(6)}}</span></td>
                                   
                                @break
                                @case(7)
                                   
                                        <td><span class="badge badge-danger">{{selling_request_status(7)}}</span></td>
                                   
                                @break
                            @endswitch
                        </tr>
                        </tbody>

                        @if ($item->status == 1 && $item->farmer->deleted_at == null)
                            <tfoot>
                                <tr>
                                    <td>
                                        <a href="{{ route('bid.create', ['selling_request_id' => $item->id]) }}"
                                            class="btn btn-success">{{ __('common.accept_button') }}</a>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger" data-id={{ $item->id }}
                                            id="reject">{{ __('common.reject_button') }}</button>
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
                {{-- <div class="col-md-8" style="
                            margin-top: 388px; display:none" id="reasonDiv">
                    <form id="reject-form" action="" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="reason">Reason</label>
                                    <input type="text" id="reason" name="reason" placeholder="Enter A reason"
                                        class="form-control" data-parsley-required='true'
                                        data-parsley-required-message='Please enter reason' />
                                    {!! $errors->first('reason', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>
                            <div class="col-md-2" style="
                                    margin-left: 25px;
                                    margin-top: 25px;">
                                <button type="submit" form="accept-form" class="btn btn-primary"
                                    id="send_reason">Send</button>
                            </div>
                            <div class="col-md-2" style="
                                    margin-top: 25px;">
                                <button type="submit" class="btn btn-secondary"
                                    id="cancel_reason">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div> --}}
            </div>
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
                    <form action="{{ route('selling_request.reject') }}" method="POST" id="reject-form">
                        @csrf
                        <input type="hidden" name="selling_request_id" id="selling_request_id">
                        <div class="form-group">
                            <label for="reason">{{ __('common.selling_request.reson_popup.form.reason.label') }}</label>
                            <input type="text" id="reason" name="reason" class="form-control" placeholder="{{ __('common.selling_request.reson_popup.form.reason.placeholder') }}"
                                data-parsley-required='true' data-parsley-required-message="{{ __('common.selling_request.reson_popup.form.reason.required') }}" />
                            {!! $errors->first('reason', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('common.selling_request.reson_popup.send_button') }}</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('common.selling_request.reson_popup.cancel_button') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- <form action="{{ route('selling_request.reject', $item->id) }}" id="reject-form" method="POST"
        style="display: none;">
        @csrf
    </form> --}}
@endsection
@section('script')
    <script type="text/javascript">
        (function() {
            var rejectRoute = '{{ route('selling_request.reject', ':id') }}';

            // $('#reject').on('click', function(e) {
            //     e.preventDefault();
            //     // $('#reasonDiv').css({
            //     //     "display": "block"
            //     // });;
            //     $('#')
            // })

            $('#reject').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                let me = this;
                let selling_request_id = $(this).data('id');
                Swal.fire({
                        title: "{{ __('common.selling_request.reject_popup.title') }}",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: "{{ __('common.selling_request.reject_popup.confirm_button') }}",
                        cancelButtonText: "{{ __('common.selling_request.reject_popup.cancel_button') }}",
                    })
                    .then(function(res) {
                        if (res.value) {
                            $('.modal-title').text("{{ __('common.selling_request.reson_popup.title') }}");
                            $('#selling_request_id').val(selling_request_id)
                            $('#reject-modal').modal('show');
                        }
                    });
                return false;
            });
            // $('#send_reason').on('click', function() {

            //     var selling_request_id =   $('#selling_request_id').val() 

            //     let rejectUrl = rejectRoute.replace(':id',selling_request_id);

            //     $.ajax({
            //         url: rejectUrl,
            //         method: 'POST',
            //         data: {
            //             reason : $('#reason').val(),
            //             _token: $('meta[name="csrf-token"]').attr('content')
            //         },
            //         success: function(result) {
            //             if (result.status == 'true') {
            //                 $('#reject-modal').modal('hide');
            //                 location.reload();
            //             } 
            //         }
            //     });

            // });
            $(document).ready(function() {
                //parsley validate the form
                $('#reject-modal').on('hidden.bs.modal', function() {
                    $('#reject-form').parsley().reset();
                    $(this).find('form').trigger('reset');
                })
                $('#reject-form').parsley();
                $('#accept-form').parsley();
            });

            @if ($errors->any())
                $('#accept-btn').trigger('click');
            @endif
        })();
    </script>
@endsection
