<!DOCTYPE html>
<html lang="en" >
    <!-- begin::Head -->
    <head>
        <meta charset="utf-8" />
        <title>Halaman Login | {{ config("app.name") }}</title>
        <meta name="description" content="Latest updates and statistic charts">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--begin::Web font -->
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
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
        <link href="{{ asset('assets/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css" />

        <link href="{{ asset('assets/demo/default/base/login.css') }}" rel="stylesheet" type="text/css" />
        <!--end::Base Styles -->

        <link rel="shortcut icon" href="{{ asset('assets/demo/default/media/img/logo/favicon.ico') }}" />
    </head>
    <!-- end::Head -->

    <!-- end::Body -->
    <body  class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-3" id="m_login">
            <div class="m-grid__item m-grid__item--fluid m-login__wrapper">
                <div class="m-login__container">
                    <div class="m-login__logo" style="margin-bottom: 20px;">
                        <img src="{{ asset('assets/demo/default/media/img/logo/logo_ma.png') }}" width="100" style="margin-bottom: 50px" />
                        <a href="#" style="display: block;">
                            <img style="width: 200px; height: auto;" src="{{ asset('assets/demo/default/media/img/logo/logo_new.png') }}">
                        </a>
                    </div>
                    <div class="m-login__signin">
                        <form class="m-login__form m-form" action="#" method="POST">
{{--                            <div class="text-center" style="color: white; font-size: 18px;font-weight: bold;"> BIRO PERLENGKAPAN <br>--}}
{{--                                MAHKAMAH AGUNG REPUBLIK INDONESIA</div>--}}
                            <div class="m-login__form-action" style="margin-top: 0; text-align: center;">
                                <div>
                                    <button type="button" class="btn btn-green m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn" data-toggle="modal" data-target="#modalLogin">Login</button>
                                    <a href="{{ asset('FORMULIR SIPERMARI.docx') }}" class="btn btn-warning btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn" style="color: white;">
                                        Registrasi
                                    </a>
                                </div>
                                <div class="text-center font-weight-bold" style="color: #585858;font-size: 14px; padding-top: 10px;">
                                    MAHKAMAH AGUNG REPUBLIK INDONESIA<br>
                                    e-Sadewa v.1.0 &copy; {{ date('Y') }}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalLogin" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 410px;" role="document">
            <div class="modal-content">
                <form class="m-login__form m-form" action="{{ route('doLogin') }}" method="POST">
                    <div class="modal-body" style="padding: 25px 30px;">
                        <div class="m-form__section m-form__section--first">
                            <div class="text-center" style="margin-bottom: 50px; margin-top: 10px;">
                                <img style="width: 35%; height: auto;" src="{{ asset('assets/demo/default/media/img/logo/logo_new.png') }}">
                            </div>

                            <div class="form-group m-form__group">
                                <input class="form-control m-input input-login" type="email" placeholder="Email" name="username" autocomplete="off">
                            </div>
                            <div class="form-group m-form__group">
                                <input class="form-control m-input m-login__form-input--last input-login" type="password" placeholder="Password" name="password">
                            </div>
                            <div class="row m-login__form-sub" style="margin: 5px 0;">
                                <div class="col col-md-12 m--align-left m-login__form-left" style="padding-top: 9px;">
                                    <label class="m-checkbox  m-checkbox--light" style="color: white;">
                                        <input type="checkbox" name="remember">
                                        Ingat Saya
                                        <span style="border: 1px solid white"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="m-login__form-action" style="margin-top: 0; text-align: center;">
                                <div>
                                    <button id="m_login_signin_submit" class="btn btn-warning m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn" style="border: 1px solid #707070;">
                                        {{ __('form.login') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- end:: Page -->
    <!--begin::Base Scripts -->
    <script src="{{ asset('assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/demo/default/base/scripts.bundle.js') }}" type="text/javascript"></script>
    <!--end::Base Scripts -->
    <!--begin::Page Snippets -->
    <script src="{{ asset('assets/snippets/custom/pages/user/login.js') }}" type="text/javascript"></script>
    <!--end::Page Snippets -->
    </body>
    <!-- end::Body -->
</html>
