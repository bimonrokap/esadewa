@extends('template.admin.content')

@section('content')
    <div class="row">
        <div class="col-xl-12">

            <div id="con-head">
                <ul class="nav nav-pills nav-custom">
                    @include("admin.pengadaan.usulan.show.navitem", ['type' => $type])
                    <li class="nav-item">
                        <a class="nav-link" id="baseIcon-tab4" data-toggle="tab" aria-controls="tabTingkatBanding" href="#tabTingkatBanding" aria-expanded="false"><i class="la la-cc-discover"></i> Tingkat Banding </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="baseIcon-tab4" data-toggle="tab" aria-controls="tabPersetujuanPenjualan" href="#tabPersetujuanPenjualan" aria-expanded="false"><i class="la la-arrows-alt "></i> Hasil Kajian Pengadaan Barang </a>
                    </li>
                </ul>
                <form class="m-form" action="{{ route($config['route'] . '.doSelesai', $data->id) }}" method="POST" id="form">
                    {{ csrf_field() }}
                    <div class="tab-content pt-1">
                        @component('admin.components.form.alert') @endcomponent
                        @include("admin.pengadaan.usulan.show.tabcontent", ['type' => $type])
                        <div class="tab-pane" id="tabTingkatBanding" aria-labelledby="baseIcon-tab3">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @include("admin.pengelolaan.penghapusan.show.tkbanding")
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabPersetujuanPenjualan" aria-labelledby="baseIcon-tab3">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    <div class="m-form-custom-5 row">
                                        <div class="col-lg-6">
                                            <div class="form-group m-form__group">
                                                <label for="inputLetterNumber"> No Surat Persetujuan Izin Penjualan  <span class="required">*</span> </label>
                                                <input type="text" class="form-control m-input required" id="inputLetterNumber" name="letter_number_persetujuan" placeholder="No Surat Persetujuan Izin Penjualan" />
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputLetterDate"> Tanggal Surat Persetujuan Izin Penjualan  <span class="required">*</span> </label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control m-input required m_datepicker required" id="inputLetterDate" readonly name="letter_date_persetujuan" placeholder="Tanggal Surat" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label> Surat Hasil Kajian Pengadaan Barang <span class="required">*</span> </label>
                                                <div class="custom-file">
                                                    <input name="surat_persetujuan" type="file" accept="application/pdf" class="custom-file-input required">
                                                    <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group m-form__group">
                                                <label for="inputPerihalSurat"> Perihal Surat Persetujuan Izin Penjualan  <span class="required">*</span> </label>
                                                <textarea class="form-control m-input required" id="inputPerihalSurat" name="perihal_persetujuan" placeholder="Perihal Surat" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet m-portlet--mobile m-portlet--footer-only">
                        <a href="{{ route($config['route'] . '.index') }}" class="ajaxify" id="reload" style="display: none;"></a>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <div class="row">
                                    <div class="col-lg-12 text-right">
                                        <button type="submit" name="submit" value="1" class="btn btn-success"> Simpan </button>
                                        <a href="{{ route($config['route'] . '.index') }}" class="ajaxify"> <button type="button" class="btn btn-secondary"> Batal </button></a>
                                    </div>
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
    <script type="text/javascript">
        $(document).ready(function () {
            FormValidation.init({ 'form': '#form' });
            $('.m_datepicker').datepicker({
                autoclose: true,
                todayBtn: "linked",
                clearBtn: true,
                todayHighlight: true,
                format: 'd MM yyyy',
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            });
        });
    </script>
    @endpush