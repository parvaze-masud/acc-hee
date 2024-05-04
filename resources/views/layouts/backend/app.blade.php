<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') {{ config('app.name', 'Account') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <script type="text/javascript" src="{{asset('js/app.js')}}"></script> --}}
    <link rel="icon" href="{{asset('libraries\assets\images\favicon.ico')}}" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{asset('libraries/bower_components/bootstrap/css/bootstrap5.css')}}">
    <!-- feather Awesome -->
    <link rel="stylesheet" type="text/css" href="{{asset('libraries/assets\icon\feather\css\feather.css')}}">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="{{asset('libraries\assets\icon\themify-icons\themify-icons.css')}}">
    <!-- Syntax highlighter Prism css -->
    <link rel="stylesheet" type="text/css" href="{{asset('libraries\assets\pages\prism\prism.css')}}">
    <!-- Select 2 css -->
    <link rel="stylesheet" href="{{asset('libraries\bower_components\select2\css\select2.min.css')}}">
    <!-- Multi Select css -->
    <link rel="stylesheet" type="text/css" href="{{asset('libraries\bower_components\bootstrap-multiselect\css\bootstrap-multiselect.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('libraries\bower_components\multiselect\css\multi-select.css')}}">
    <!-- Date-time picker css -->
    <link rel="stylesheet" type="text/css" href="{{asset('libraries\assets\pages\advance-elements\css\bootstrap-datetimepicker.css')}}">
    <!-- Date-range picker css  -->
    <link rel="stylesheet" type="text/css" href="{{asset('libraries\bower_components\bootstrap-daterangepicker\css\daterangepicker.css')}}">
    <!-- Date-Dropper css -->
    <link rel="stylesheet" type="text/css" href="{{asset('libraries\bower_components\datedropper\css\datedropper.min.css')}}">
    <!-- Color Picker css -->
    <link rel="stylesheet" type="text/css" href="{{asset('libraries\bower_components\spectrum\css\spectrum.css')}}">
    <!-- Mini-color css -->
    <link rel="stylesheet" type="text/css" href="{{asset('libraries\bower_components\jquery-minicolors\css\jquery.minicolors.css')}}">
    <!-- Tags css -->
    <link rel="stylesheet" type="text/css" href="{{asset('libraries\bower_components\bootstrap-tagsinput\css\bootstrap-tagsinput.css')}}">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{asset('libraries\assets\css\style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('libraries\assets\css\jquery.mCustomScrollbar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('libraries\assets\css\pcoded-horizontal.min.css')}}">
    <!-- feather Awesome -->
    <link rel="stylesheet" href="{{asset('font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('libraries\assets\icon\feather\css\feather.css')}}">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="{{asset('libraries\assets\icon\themify-icons\themify-icons.css')}}">
     <!--common.css -->
     <link rel="stylesheet" type="text/css" href="{{asset('common_css/common.css')}}">
     <link rel="stylesheet" type="text/css" href="{{asset('common_css/jquery-ui.css')}}">
    <script type="text/javascript" src="{{asset('libraries\bower_components\jquery\js\jquery.min.js')}}"></script>
    <script>
    </script>
    @stack('css')
</head>

<body themebg-pattern="pattern6">
    <!-- Pre-loader start -->
    <!-- Pre-loader end -->
    <!-- Main Header Container -->
    @include('layouts.backend.partials.head')
    <!-- End Main Header Container -->
    <!-- Main Navbar Container -->
    @include('layouts.backend.partials.navbar')
    <!-- End Main Navbar Container -->
    <!-- Main Content -->
    <div style="margin-top: 50px;">
        @yield('admin_content')
    </div>
    </div>
    <!-- End Main Footer Container -->
    @include('layouts.backend.partials.footer')
    {{-- <div id="styleSelector"> --}}
    </div>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{asset('libraries\bower_components\jquery-slimscroll\js\jquery.slimscroll.js')}}"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="{{asset('libraries\bower_components\modernizr\js\modernizr.js')}}"></script>
    <script type="text/javascript" src="{{asset('libraries\bower_components\modernizr\js\css-scrollbars.js')}}"></script>
    <!-- Select 2 js -->
    <script type="text/javascript" src="{{asset('libraries\bower_components\select2\js\select2.full.min.js')}}"></script>
    <!-- Multiselect js -->
    <script type="text/javascript" src="{{asset('libraries\bower_components\bootstrap-multiselect\js\bootstrap-multiselect.js')}}"></script>
    <script type="text/javascript" src="{{asset('libraries\bower_components\multiselect\js\jquery.multi-select.js')}}"></script>
    <script type="text/javascript" src="{{asset('libraries\assets\js\jquery.quicksearch.js')}}"></script>
    <!-- Tags js -->
    <script type="text/javascript" src="{{asset('libraries\bower_components\bootstrap-tagsinput\js\bootstrap-tagsinput.js')}}"></script>
    <!-- Date-range picker js -->
    <script type="text/javascript" src="{{asset('libraries\bower_components\bootstrap-daterangepicker\js\daterangepicker.js')}}"></script>
    <!-- Date-dropper js -->
    <script type="text/javascript" src="{{asset('libraries\bower_components\datedropper\js\datedropper.min.js')}}"></script>
    <!-- Color picker js -->
    <script type="text/javascript" src="{{asset('libraries\bower_components\spectrum\js\spectrum.js')}}"></script>
    <script type="text/javascript" src="{{asset('libraries\bower_components\jscolor\js\jscolor.js')}}"></script>
    <!-- Mini-color js -->
    <script type="text/javascript" src="{{asset('libraries\bower_components\jquery-minicolors\js\jquery.minicolors.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('libraries\assets\pages\advance-elements\select2-custom.js')}}"></script>
    <!-- data-table js -->
    <script src="{{asset('libraries\assets\js\pcoded.min.js')}}"></script>
    <script src="{{asset('libraries\assets\js\horizontal-layout.min.js')}}"></script>
    <script src="{{asset('libraries\assets\js\jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('libraries\assets\js\script.js')}}"></script>
    <script src="{{asset('common_js\sweetalert2.js')}}"></script>
    <script src="{{asset('common_js/jspdf.min.js')}}"></script>
    <script src="{{asset('common_js/jspdf.plugin.autotable.min.js')}}"></script>
    <script src="{{asset('common_js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('common_js/jquery-ui.js')}}"></script>
     <!-- common  js -->
    <script src="{{asset('common_js\common_other.js')}}"></script>
    <script src="{{asset('common_js\navber_active.js')}}"></script>
    <script src="{{asset('common_js\pdf_excel_print.js')}}"></script>
    <script>
        // jquery date formate
        $(document).ready(function () {
            $( ".setup_date" ).datepicker({
                    dateFormat:"yy-mm-dd",
                    minDate:"{{company()->financial_year_start}}",
                    maxDate:"{{company()->financial_year_end}}",
                    changeMonth: true,
                    changeYear: true
            });
        });

        // value divide calculation
        function dividevalue(dividend, divisor) {
            if (divisor!== 0) {
                return dividend / divisor;
            } else {

              return 0;
            }
       }
        // ledger commission liline search
        $(document).ready(function () {
            $(document).on('change click keyup ','.select2-search__field',function(){
                if($('.select2-results__options').text()=='No results found'){
                    if($(document).find('.commission_select2_'+lilineComRowCount).length){
                        $.ajax({
                            url: '{{url("ledger_name") }}',
                            method: 'GET',
                            dataType: 'json',
                            async: false,
                            data: {
                                ledger_head_name:$('.select2-search__field').val()
                            },
                            success: (response)=>{
                                $.each(response, function(key, value) {
                                        $('.select2-results__options').text('');
                                        $('.commission_select2_'+lilineComRowCount).empty();
                                        $('.commission_select2_'+lilineComRowCount).append('<option value="' + value.ledger_head_id + '">' + value.ledger_name + '</option>');
                                });
                            }
                    });
                    }
                }
            });
        });
    </script>

@stack('js')
</body>

</html>
