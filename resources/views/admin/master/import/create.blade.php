@extends('template.admin.content')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-plus"></i>
                            </span>
                            <h3 class="m-portlet__head-text"> {{ $config['pageTitle'] }} Data </h3>
                        </div>
                    </div>
                </div>
                <form class="m-form m-form--label-align-right" action="{{ route($config['route'] . '.store') }}" method="POST" id="form">
                    {{ csrf_field() }}
                    <div class="m-portlet__body">
                        @component('admin.components.form.alert') @endcomponent
                        <div class="m-form__section m-form__section--first">
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label"> File </label>
                                <div class="col-lg-4">
                                    <div class="custom-file">
                                        <input name="file" type="file" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label" for="customFile">
                                            Pilih File
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route($config['route'] . '.index') }}" id="reload" class="ajaxify" style="display: none;"></a>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <div class="row">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-success"> Upload </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection

@push('scripts')
    <script src="{{ asset('assets/app/js/datatable.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2').select2();
            $('.select2-role').select2({
                placeholder: 'Pilih Role'
            });

            var options = {
                'form' : '#form',
                'rules' : {
                    password: "required",
                    password_match: {
                        equalTo: "#password"
                    }
                },
                'message' : {
                    password_match: {
                        equalTo: "Password not match!"
                    }
                }
            };

            FormValidation.init(options);

            $('#pusat').change(function () {
               if($(this).is(':checked')) {
                   $('#con-satker').hide();
               } else {
                   $('#con-satker').show();
               }
            });
        });
    </script>
    @endpush