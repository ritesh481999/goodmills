@extends('layouts.master')
@section('title', __('common.farmer_group.farmer_group_list'))

@section('content')
    

        <div class="row">
            <div class="col-lg-12">

                <!--begin::Portlet-->
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                {{__('common.farmer_group.add_farmer_group')}}
                            </h3>
                        </div>
                        <div class="back-url-div">
                            <a href="{{ route('farmer_group.index') }}"
                                class="btn btn-brand btn-elevate btn-icon-sm back-url">
                                {{ __('common.back_button') }}
                            </a>
                        </div>
                    </div>

                    <!--begin::Form-->
                    {!! Form::open(['route' => 'farmer_group.store', 'class' => 'form-horizontal',
                         'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'addFarmerGroup']) !!}

                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="form-group">

                                {!! Html::decode(Form::label('name', __('common.farmer_group.group_name').
                                    '<span class="text-danger">*</span>', ['class' => 'col-md-4 control-label'])) !!}
                                <div class="col-md-6">
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="{{__('common.farmer_group.group_name_placeholder')}}" 
                                        data-parsley-required="true"
                                        data-parsley-required-message=
                                        "{{__('common.farmer_group.group_name_parsley_validation')}}"
                                        data-parsley-trigger="input blur" data-parsley-maxlength='100'
                                        data-parsley-pattern="{{ config('common.safe_string_pattern') }}"
                                        data-parsley-pattern-message="
                                        {{__('common.farmer_group.group_name_parsley_pattern_message')}}"
                                        data-parsley-maxlength-message="
                                        {{__('common.farmer_group.group_name_parsley_max_validation')}}">
                                    {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">{{__('common.farmer_group.group_status')}}<span
                                        class="mandatory">*</span></label>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="custom-control custom-radio custom-control">
                                                <input type="radio" id="active-status" name="status"
                                                    class="custom-control-input" value="1" checked>
                                                <label class="custom-control-label" for="active-status">
                                                    {{__('common.active')}}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="custom-control custom-radio custom-control">
                                                <input type="radio" id="inactive-status" name="status"
                                                    class="custom-control-input" value="0">
                                                <label class="custom-control-label" for="inactive-status">
                                                    {{__('common.inactive')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {!! $errors->first('status', '<p class="help-block text-danger">:message</p>') !!}


                            </div>

                            <div class="">
                                <h4 style='font-weight:bold'>{{__('common.farmer_group.farmers_in_group')}}</h4>
                                <p class="help-block text-danger" id="farmer_ids_errors">
                                    @if ($errors->has('farmer_ids'))
                                        {{ $errors->first('farmer_ids') }}
                                    @endif
                                </p>

                                <input type="text" style="display: none;" name="farmer_ids" id="farmer_ids" value=""
                                    data-parsley-trigger="input" data-parsley-required='true'
                                    data-parsley-required-message="
                                    {{__('common.farmer_group.farmer_ids_parsley_validation')}}"
                                    data-parsley-errors-container="#farmer_ids_errors" />
                                <table class="table table-striped- table-bordered table-hover 
                                table-checkable data-table"
                                    id="farmer_added">

                                    <thead>
                                        <tr>
                                            <th>{{__('common.farmer_group.id')}}</th>
                                            <th>{{__('common.farmer_group.username')}}</th>
                                            <th>{{__('common.farmer_group.action')}}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                            <div class="" style='margin-top: 5%;'>
                                <h4 style='font-weight:bold'>{{__('common.farmer_group.farmers_not_in_group')}}</h4>
                                <table class="table table-striped- table-bordered table-hover table-checkable data-table"
                                    id="farmer_not_added">
                                    <thead>
                                        <tr>
                                            <th>{{__('common.farmer_group.id')}}</th>
                                            <th>{{__('common.farmer_group.username')}}</th>
                                            <th>{{__('common.farmer_group.action')}}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>


                        </div>
                    </div>

                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <button type="submit" class="btn btn-primary">{{__('common.submit')}}</button>
                            <button type="reset" class="btn btn-secondary">{{__('common.clear')}}</button>
                        </div>
                    </div>
                    @csrf
                    </form>
                    <!--end::Form-->

                </div>
                <!--en::Portlet-->

            </div>
        </div>

@endsection
@section('script')
    <script src="{{ asset('assets/plugins/general/moment/min/moment-timezone-with-data.min.js') }}"></script>

    <script type="text/javascript">
        (function() {
            window.parsley.addValidator('nonzero', function(value, requirement) {
                if (isNaN(value))
                    return false;
                $v = Number(value);
                return !($v <= 0);
            });


            let ids = [];
            $('#addFarmerGroup').parsley();

            const farmer_added_table = $('#farmer_added').DataTable({
                order: [
                    [1, "desc"]
                ],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: null,
                        render: function(row) {
                            return `<button type='button' class='btn btn-primary remove-farmer' data-farmer-id='${row.id}' data-farmer-account='${row.username}'>Remove</button>`;
                        },
                        orderable: false,
                        searchable: false
                    },
                ]
            });


            const farmer_not_added_table = $('#farmer_not_added').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [1, "desc"]
                ],
                ajax: {
                    url: '{{ url()->current() }}',
                    dataSrc: function(json) {
                        return json.data.filter(row => ids.indexOf(row.id) < 0);
                    },
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: null,
                        render: function(row) {
                            return `<button type='button' class='btn btn-primary add-farmer' data-farmer-id='${row.id}' data-farmer-account='${row.username}'>Add</button>`;
                        },
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $(document).on('click', 'button.add-farmer', function(e) {
                e.preventDefault();
                const data = this.dataset;
                const f = {
                    id: parseInt(data.farmerId),
                    username: data.farmerAccount
                };
                farmer_added_table.row.add(f).draw();
                farmer_not_added_table.row($(this).parents('tr')).remove().draw();
                ids.push(parseInt(f.id));
                console.log(ids);
                $('#farmer_ids').val(ids.join(',')).trigger('change');
            });

            $(document).on('click', 'button.remove-farmer', function(e) {
                e.preventDefault();
                const data = this.dataset;
                const f = {
                    id: parseInt(data.farmerId),
                    username: data.farmerAccount
                };
                farmer_not_added_table.row.add(f).draw();
                farmer_added_table.row($(this).parents('tr')).remove().draw();
                ids = ids.filter(id => id != f.id);
                $('#farmer_ids').val(ids.join(',')).trigger('change');
            });
        })();
    </script>


@endsection
