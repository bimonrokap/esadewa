<!DOCTYPE html>
<html lang="en" >
    <!-- begin::Head -->
    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>
            {{ $config['title'] or 'Dashboard'  }} | {{ config('app.name') }}
        </title>
        <meta name="description" content="Latest updates and statistic charts">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!--begin::Web font -->
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/highcharts-3d.js"></script>
        <script src="https://code.highcharts.com/modules/data.js"></script>
        <script>
            WebFont.load({
                google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
                active: function() {
                    sessionStorage.fonts = true;
                }
            });
        </script>
        <!--end::Web font -->

        <!--begin::Base Styles -->
        <!--begin::Page Vendors -->
        <link href="{{ asset('assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/vendors/custom/magnific-popup/magnific-popup.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css" />
        @stack('css')
        <!--end::Page Vendors -->

        <link href="{{ asset('assets/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/demo/demo12/base/style.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/demo/demo12/base/custom.css') }}" rel="stylesheet" type="text/css" />
        <!--end::Base Styles -->

        <link rel="shortcut icon" href="{{ asset('assets/demo/default/media/img/logo/favicon.ico') }}" />
    </head>
    <!-- end::Head -->

    <!-- end::Body -->
    <body  class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <!-- BEGIN: Header -->
            <header id="m_header" class="m-grid__item m-header" m-minimize-offset="200" m-minimize-mobile-offset="200" >
                <div class="m-container m-container--fluid m-container--full-height">
                    <div class="m-stack m-stack--ver m-stack--desktop">
                        <!-- BEGIN: Brand -->
                        <div class="m-stack__item m-brand  m-brand--skin-dark ">
                            <div class="m-stack m-stack--ver m-stack--general">
                                <div class="m-stack__item m-stack__item--middle m-brand__logo">
                                    <a href="{{ route('admin.dashboard.index') }}" class="m-brand__logo-wrapper ajaxify">
                                        <img alt="" src="{{ asset('assets/demo/default/media/img/logo/esadewa_tulisan.png') }}" style="height: 21px;"/>
                                    </a>
                                </div>
                                <div class="m-stack__item m-stack__item--middle m-brand__tools">
                                    <!-- BEGIN: Left Aside Minimize Toggle -->
                                    <a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block ">
                                        <span></span>
                                    </a>
                                    <!-- END -->
                                    <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                                    <a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                                        <span></span>
                                    </a>
                                    <!-- END -->
                                    <a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                                        <span></span>
                                    </a>
                                    <!-- BEGIN: Topbar Toggler -->
                                    <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                                        <i class="flaticon-more"></i>
                                    </a>
                                    <!-- BEGIN: Topbar Toggler -->
                                </div>
                            </div>
                        </div>
                        <!-- END: Brand -->
                        <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                            <!-- BEGIN: Horizontal Menu -->
                                @include('template.admin.horizontalmenu')
                            <!-- END: Horizontal Menu -->

                            <!-- BEGIN: Topbar -->
                                @include('template.admin.toolbar')
                            <!-- END: Topbar -->
                        </div>
                    </div>
                </div>
            </header>
            <!-- END: Header -->

            <!-- begin::Body -->
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
                <!-- BEGIN: Left Aside -->
                    @include('template.admin.leftmenu')
                <!-- END: Left Aside -->

                <div class="m-grid__item m-grid__item--fluid m-wrapper">
                    <!-- BEGIN: Subheader -->
{{--                        @include('template.admin.subheader')--}}
                    <!-- END: Subheader -->

                    <div class="m-content">
                        @yield('fullcontent')
                    </div>
                </div>
            </div>
            <!-- end:: Body -->

            <!-- begin::Footer -->
                @include('template.admin.footer')
            <!-- end::Footer -->
        </div>
        <!-- end:: Page -->

        <!-- begin::Scroll Top -->
        <div id="m_scroll_top" class="m-scroll-top">
            <i class="la la-arrow-up"></i>
        </div>
        <!-- end::Scroll Top -->

        <!--begin::Base Scripts -->
        <script src="{{ asset('assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/demo/demo12/base/scripts.bundle.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/custom/numberformat/jquery.number.min.js') }}" type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>
        <script src="{{ asset('assets/vendors/custom/validation/localization/messages_id.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/custom/magnific-popup/jquery.magnific-popup.min.js') }}" type="text/javascript"></script>
        <!--end::Base Scripts -->

        <!--begin::Page Vendors -->
        <script src="{{ asset('assets/app/js/ajaxify.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/app/js/datatable.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/app/js/form-validation.js') }}" type="text/javascript"></script>
        @stack('js')
        <!--end::Page Vendors -->

        <!--begin::Page Snippets -->
        <script type="text/javascript">
            var appName = '{{ config('app.name') }}';
            var baseUrl = '{{ url('/') }}';
            Flying.ajaxify();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            Dropzone.autoDiscover = false;
        </script>
        @stack('scripts')
        <!--end::Page Snippets -->

    </body>
    <!-- end::Body -->

</html>
