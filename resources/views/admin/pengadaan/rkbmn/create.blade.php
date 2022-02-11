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
                            <h3 class="m-portlet__head-text"> Tambah {{ $config['pageTitle'] }}</h3>
                        </div>
                    </div>
                </div>
                <form class="m-form m-form--label-align-right" action="{{ route($config['route'] . '.store') }}" method="POST" id="form">
                    {{ csrf_field() }}
                    <div class="m-portlet__body">
                        @component('admin.components.form.alert') @endcomponent
                        <div class="m-form__section m-form__section--first">
                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label"> Jenis <span class="required">*</span> </label>
                                <div class="col-lg-3">
                                    <select name="type" class="form-control m-input select2">
                                        <option value="">Pilih Jenis</option>
                                        <option value="1">Pengadaan</option>
                                        <option value="2">Pemeliharaan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label"> Tahun <span class="required">*</span> </label>
                                <div class="col-lg-2">
                                    <div class="input-group date">
                                        <input type="text" class="form-control m-input m_datepicker required" readonly name="year" placeholder="Tahun" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label"> File <span class="required">*</span> </label>
                                <div class="col-lg-4">
                                    <div class="custom-file">
                                        <input name="file" type="file" class="custom-file-input required">
                                        <label class="custom-file-label"> Pilih File </label>
                                    </div>
                                    <span class="m-form__help">File ekstensi XLSX</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route($config['route'] . '.index') }}" id="reload" class="ajaxify" style="display: none;"></a>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button type="submit" class="btn btn-success"> Simpan </button>
                                    <a href="{{ route($config['route'] . '.index') }}" class="ajaxify"> <button type="button" class="btn btn-secondary"> Kembali </button></a>
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
            $('.m_datepicker').datepicker({
                autoclose: true,
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                todayBtn: "linked",
                clearBtn: true,
                todayHighlight: true,
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            });

            FormValidation.init({ 'form' : '#form' });
        });
    </script>
    @endpush