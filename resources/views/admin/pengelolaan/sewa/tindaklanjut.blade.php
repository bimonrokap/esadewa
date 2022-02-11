@extends('template.admin.content')

@section('content')
    <div class="row">
        <div class="col-xl-12">

            <div id="con-head">
                <ul class="nav nav-pills nav-custom">
                    <li class="nav-item">
                        <a class="nav-link active" id="baseIcon-tab1" data-toggle="tab" aria-controls="tabData" href="#tabData" aria-expanded="true"><i class="la la-file"></i> Data </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="baseIcon-tab3" data-toggle="tab" aria-controls="tabFoto" href="#tabFoto" aria-expanded="false"><i class="la la-image"></i> Foto </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="baseIcon-tab4" data-toggle="tab" aria-controls="tabTingkatBanding" href="#tabTingkatBanding" aria-expanded="false"><i class="la la-cc-discover"></i> Tingkat Banding </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="baseIcon-tab4" data-toggle="tab" aria-controls="tabPersetujuanPenjualan" href="#tabPersetujuanPenjualan" aria-expanded="false"><i class="la la-arrows-alt "></i> Persetujuan Sewa </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="baseIcon-tab4" data-toggle="tab" aria-controls="tabTindakLanjut" href="#tabTindakLanjut" aria-expanded="false"><i class="la la-archive "></i> Tindak Lanjut </a>
                    </li>
                </ul>
                <form class="m-form" action="{{ route($config['route'] . '.doTindakLanjut', $data->id) }}" method="POST" id="form">
                    {{ csrf_field() }}
                    <div class="tab-content pt-1">
                        @component('admin.components.form.alert') @endcomponent
                        <div class="tab-pane active" id="tabData" role="tabpanel" aria-expanded="true" aria-labelledby="baseIcon-tab1">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @include("admin.pengelolaan.sewa.show.data")
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabFoto" aria-labelledby="baseIcon-tab3">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @component('admin.components.usulan.fotoShow', ['fotos' => $data->foto, 'data' => $data, 'param' => ['type' => 'sewa']]) @endcomponent
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabTingkatBanding" aria-labelledby="baseIcon-tab3">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @include("admin.pengelolaan.sewa.show.tkbanding")
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabPersetujuanPenjualan" aria-labelledby="baseIcon-tab3">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @include("admin.pengelolaan.sewa.show.persetujuan")
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabTindakLanjut" aria-labelledby="baseIcon-tab3">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    <div class="m-form-custom-5 row">
                                        <div class="col-lg-6">
                                            <div class="form-group m-form__group">
                                                <label for="inputTanggalPerjanjian"> Tanggal Pembayaran  <span class="required">*</span> </label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control m-input required m_datepicker required" id="inputTanggalPerjanjian" readonly name="tanggal_pembayaran" placeholder="Tanggal Pembayaran" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputNomorNtb"> Nomor NTB  <span class="required">*</span> </label>
                                                <input type="text" class="form-control m-input required" id="inputNomorNtb" name="nomor_ntb" placeholder="Nomor NTB" />
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputJumlahPembayaran"> Jumlah Pembayaran  <span class="required">*</span> </label>
                                                <div class="input-group m-input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"> Rp </span>
                                                    </div>
                                                    <input type="text" class="form-control m-input harga required" id="inputJumlahPembayaran" name="jumlah_pembayaran" placeholder="Jumlah Pembayaran" />
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputNomorPerjanjian"> Nomor Perjanjian  <span class="required">*</span> </label>
                                                <input type="text" class="form-control m-input required" id="inputNomorPerjanjian" name="nomor_perjanjian" placeholder="Nomor Perjanjian" />
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputPeriodePerjanjian"> Periode Perjanjian  <span class="required">*</span> </label>
                                                <div class="input-group m-input-group">
                                                    <input type="text" class="form-control m-input required" id="inputPeriodePerjanjian" name="periode_perjanjian" placeholder="Periode Perjanjian" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"> Bulan </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputNilaiPerjanjianSewa"> Nilai Perjanjuan Sewa  <span class="required">*</span> </label>
                                                <div class="input-group m-input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"> Rp </span>
                                                    </div>
                                                    <input type="text" class="form-control m-input harga required" id="inputNilaiPerjanjianSewa" name="nilai_perjanjian_sewa" placeholder="Nilai Perjanjuan Sewa" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group m-form__group">
                                                <label for="inputAkunPembayaran"> Akun Pembayaran  <span class="required">*</span> </label>
                                                <input type="text" class="form-control m-input required" id="inputAkunPembayaran" name="akun_pembayaran" placeholder="Akun Pembayaran" />
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputNomorNtpn"> Nomor NTPN  <span class="required">*</span> </label>
                                                <input type="text" class="form-control m-input required" id="inputNomorNtpn" name="nomor_ntpn" placeholder="Nomor NTBN" />
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label> Bukti Pembayaran <span class="required">*</span> </label>
                                                <div class="custom-file">
                                                    <input name="bukti_pembayaran" type="file" accept="application/pdf" class="custom-file-input required">
                                                    <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputTanggalPerjanjian"> Tanggal Perjanjian  <span class="required">*</span> </label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control m-input required m_datepicker required" id="inputTanggalPerjanjian" readonly name="tanggal_perjanjian" placeholder="Tanggal Perjanjian" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputJatuhTempo"> Tanggal Jatuh Tempo  <span class="required">*</span> </label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control m-input required m_datepicker required" id="inputJatuhTempo" readonly name="tanggal_jatuh_tempo" placeholder="Tanggal Jatuh Tempo" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label> Surat Perjanjian Sewa <span class="required">*</span> </label>
                                                <div class="custom-file">
                                                    <input name="surat_perjanjian_sewa" type="file" accept="application/pdf" class="custom-file-input required">
                                                    <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
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

            $('.harga').inputmask('numeric', {
                digits: 0,
                groupSeparator: '.',
                radixPoint: ",",
                removeMaskOnSubmit: false,
                autoGroup: true
            });
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