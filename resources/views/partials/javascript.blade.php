    <!-- begin::Global Config(global config for global JS sciprts) -->

    <script>
        var base_url = "{{ url('/') }}";
        let _token = "{{ csrf_token() }}";
        var KTAppOptions = {
            "colors": {
                "state": {
                    "brand": "#5d78ff",
                    "dark": "#282a3c",
                    "light": "#ffffff",
                    "primary": "#5867dd",
                    "success": "#34bfa3",
                    "info": "#36a3f7",
                    "warning": "#ffb822",
                    "danger": "#fd3995"
                },
                "base": {
                    "label": [
                        "#c5cbe3",
                        "#a1a8c3",
                        "#3d4465",
                        "#3e4466"
                    ],
                    "shape": [
                        "#f0f3ff",
                        "#d9dffa",
                        "#afb4d4",
                        "#646c9a"
                    ]
                }
            }
        };
    </script>

    <!-- end::Global Config -->

    <!--begin::Global Theme Bundle(used by all pages) -->

    <!--begin:: Vendor Plugins -->
    <script src="{{ asset('assets/plugins/general/jquery/dist/jquery.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/popper.js/dist/umd/popper.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/general/js-cookie/src/js.cookie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/moment/min/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/tooltip.js/dist/umd/tooltip.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/general/perfect-scrollbar/dist/perfect-scrollbar.js') }}"
        type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/general/sticky-js/dist/sticky.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/wnumb/wNumb.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/jquery-form/dist/jquery.form.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/general/block-ui/jquery.blockUI.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
        type="text/javascript"></script>


    <script src="{{ asset('assets/plugins/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js') }}"
        type="text/javascript"></script>

    <script src="{{ asset('assets/plugins/general/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/js/global/integration/plugins/bootstrap-timepicker.init.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/bootstrap-daterangepicker/daterangepicker.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/bootstrap-maxlength/src/bootstrap-maxlength.js') }}"
        type="text/javascript"></script>
    <script
        src="{{ asset('assets/plugins/general/plugins/bootstrap-multiselectsplitter/bootstrap-multiselectsplitter.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/bootstrap-select/dist/js/bootstrap-select.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/bootstrap-switch/dist/js/bootstrap-switch.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/js/global/integration/plugins/bootstrap-switch.init.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/select2/dist/js/select2.full.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/ion-rangeslider/js/ion.rangeSlider.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/general/typeahead.js/dist/typeahead.bundle.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/general/handlebars/dist/handlebars.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/inputmask/dist/jquery.inputmask.bundle.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/general/inputmask/dist/inputmask/inputmask.date.extensions.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/inputmask/dist/inputmask/inputmask.numeric.extensions.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/nouislider/distribute/nouislider.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/general/owl.carousel/dist/owl.carousel.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/general/autosize/dist/autosize.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/clipboard/dist/clipboard.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/dropzone/dist/dropzone.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/js/global/integration/plugins/dropzone.init.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/quill/dist/quill.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/@yaireo/tagify/dist/tagify.polyfills.min.js') }}"
        type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/general/@yaireo/tagify/dist/tagify.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/general/summernote/dist/summernote.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/markdown/lib/markdown.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/bootstrap-markdown/js/bootstrap-markdown.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/js/global/integration/plugins/bootstrap-markdown.init.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/bootstrap-notify/bootstrap-notify.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/general/js/global/integration/plugins/bootstrap-notify.init.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/jquery-validation/dist/jquery.validate.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/general/jquery-validation/dist/additional-methods.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/js/global/integration/plugins/jquery-validation.init.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/toastr/build/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/dual-listbox/dist/dual-listbox.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/general/raphael/raphael.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/morris.js/morris.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/chart.js/dist/Chart.bundle.js') }}" type="text/javascript"></script>
    <script
        src="{{ asset('assets/plugins/general/plugins/bootstrap-session-timeout/dist/bootstrap-session-timeout.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/plugins/jquery-idletimer/idle-timer.min.js') }}"
        type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/general/waypoints/lib/jquery.waypoints.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/general/counterup/jquery.counterup.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/es6-promise-polyfill/promise.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/general/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/general/js/global/integration/plugins/sweetalert2.init.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/jquery.repeater/src/lib.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/jquery.repeater/src/jquery.input.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/general/jquery.repeater/src/repeater.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/dompurify/dist/purify.js') }}" type="text/javascript"></script>

    <!--end:: Vendor Plugins -->
    <script src="{{ asset('assets/js/scripts.bundle.js') }}" type="text/javascript"></script>

    <!--begin:: Vendor Plugins for custom pages -->
    <script src="{{ asset('assets/plugins/custom/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/custom/@fullcalendar/core/main.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/plugins/custom/@fullcalendar/daygrid/main.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/@fullcalendar/google-calendar/main.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/custom/@fullcalendar/interaction/main.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/custom/@fullcalendar/list/main.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/@fullcalendar/timegrid/main.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/gmaps/gmaps.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/flot/dist/es5/jquery.flot.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/flot/source/jquery.flot.resize.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/custom/flot/source/jquery.flot.categories.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/custom/flot/source/jquery.flot.pie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/flot/source/jquery.flot.stack.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/flot/source/jquery.flot.crosshair.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/custom/flot/source/jquery.flot.axislabels.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/custom/datatables.net/js/jquery.dataTables.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/custom/datatables.net-bs4/js/dataTables.bootstrap4.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/js/global/integration/plugins/datatables.init.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/datatables.net-autofill/js/dataTables.autoFill.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/datatables.net-autofill-bs4/js/autoFill.bootstrap4.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/jszip/dist/jszip.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/pdfmake/build/pdfmake.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/pdfmake/build/vfs_fonts.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/datatables.net-buttons/js/dataTables.buttons.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/datatables.net-buttons/js/buttons.colVis.js') }}"
        type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/custom/datatables.net-buttons/js/buttons.flash.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/custom/datatables.net-buttons/js/buttons.html5.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/custom/datatables.net-buttons/js/buttons.print.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/custom/datatables.net-colreorder/js/dataTables.colReorder.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/datatables.net-fixedcolumns/js/dataTables.fixedColumns.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/datatables.net-responsive/js/dataTables.responsive.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/datatables.net-rowgroup/js/dataTables.rowGroup.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/datatables.net-rowreorder/js/dataTables.rowReorder.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/datatables.net-scroller/js/dataTables.scroller.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/datatables.net-select/js/dataTables.select.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/jstree/dist/jstree.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/jqvmap/dist/jquery.vmap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/custom/jqvmap/dist/maps/jquery.vmap.world.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/custom/jqvmap/dist/maps/jquery.vmap.russia.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/custom/jqvmap/dist/maps/jquery.vmap.usa.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/custom/jqvmap/dist/maps/jquery.vmap.germany.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/custom/jqvmap/dist/maps/jquery.vmap.europe.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/custom/uppy/dist/uppy.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/parsley_new.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/image-uploader.js') }}" type="text/javascript"></script>
    <!--end:: Vendor Plugins for custom pages -->

    <!--end::Global Theme Bundle -->

    <!--begin::Page Vendors(used by this page) -->
    <script src="//maps.google.com/maps/api/js?key=AIzaSyBTGnKT7dt597vo9QgeQ7BFhvSRP4eiMSM" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <!--end::Page Vendors -->

    <!-- custom script -->
    <script src="{{ asset('js/custom.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/language.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/general/moment/min/moment-timezone-with-data.min.js') }}"></script>

    <script>
        $(".select2").select2({
            placeholder: "Select Countries",
            width: '100%',
            allowClear: true,
        });
        $('.input-daterange').datepicker({
                todayBtn: 'linked',
                format: 'dd-M-yyyy',
                endDate: "today",
               // todayHighlight: true,
                autoclose: true,  
            });
        $('.date-time-picker').val(moment().format('YYYY-MM-DD HH:mm'));
        $('.date-time-picker').datetimepicker({
                autoclose: true,
                startDate: '-0d',
                format: 'yyyy-mm-dd hh:ii'
            })
            .on('change', function(e) {
                let vdt = new Date(e.target.value);
            })
            .on('hide', function(e) {
                $(e.target).blur();
                $(e.target).parsley().validate();
            });

        function readURL(input, placeToInsertImagePreview) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    $($.parseHTML(
                        '<img class="slectedImage">'
                    )).attr('src', e.target.result).appendTo(placeToInsertImagePreview);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function imageView(input, img_id, img_err) {
            $('#storedImagePreview').hide();
            var input_file = input.files[0];
            if (input.files && input_file) {
                var fsize = input_file.size;
                var fname = input_file.name;
                var fextension = fname.split('.').pop();
                var validExtensions = ["jpg", "jpeg", "png", "bmp", "gif"];
                var reader = new FileReader();

                if ($.inArray(fextension, validExtensions) == -1) {
                    $('#' + img_err).css('display', 'block').html('Only photo is allowed');
                    input.value = "";
                    $('#' + img_id).css('display', 'block').attr('src', '');
                    return false;
                }

                if (fsize > 2097152) {
                    $('#' + img_err).css('display', 'block').html('Photo should be less than 2mb');
                    input.value = "";
                    $('#' + img_id).css('display', 'block').attr('src', '');
                    return false;
                }

                $('#' + img_err).css('display', 'none').html('');

                reader.onload = function(e) {
                    $('#' + img_id).css('display', 'block').attr('src', e.target.result);
                }

                reader.readAsDataURL(input_file);

                return true;
            } else {
                $('#' + img_id).css('display', 'none').attr('src', '');
            }
        }
    </script>

    @yield('script')

    <!--end::Page Scripts -->
