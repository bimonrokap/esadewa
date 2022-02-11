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
                        <a class="nav-link" id="baseIcon-tab2" data-toggle="tab" aria-controls="tabBarang" href="#tabBarang" aria-expanded="false"><i class="la la-square-o "></i> Barang </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="baseIcon-tab3" data-toggle="tab" aria-controls="tabFoto" href="#tabFoto" aria-expanded="false"><i class="la la-image"></i> Foto </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="baseIcon-tab4" data-toggle="tab" aria-controls="tabTingkatBanding" href="#tabTingkatBanding" aria-expanded="false"><i class="la la-cc-discover"></i> Tingkat Banding </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="baseIcon-tab4" data-toggle="tab" aria-controls="tabPersetujuanBongkaran" href="#tabPersetujuanBongkaran" aria-expanded="false"><i class="la la-arrows-alt "></i> Persetujuan Bongkaran </a>
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
                                    @include("admin.pengelolaan.bongkaran.show.data")
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabBarang" aria-labelledby="baseIcon-tab2">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @component('admin.components.usulan.tablebarangfill', ['barangs' => $barangs, 'uraians' => $uraians]) @endcomponent
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabFoto" aria-labelledby="baseIcon-tab3">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @component('admin.components.usulan.fotoShow', ['fotos' => $data->foto, 'data' => $data, 'param' => ['type' => 'bongkaran']]) @endcomponent
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabTingkatBanding" aria-labelledby="baseIcon-tab3">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @include("admin.pengelolaan.bongkaran.show.tkbanding")
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabPersetujuanBongkaran" aria-labelledby="baseIcon-tab3">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @include("admin.pengelolaan.bongkaran.show.persetujuan")
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabTindakLanjut" aria-labelledby="baseIcon-tab3">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    <div class="m-form-custom-5 row">
                                        <div class="col-lg-6">
                                            <div class="form-group m-form__group">
                                                <label for="inputHasilBongkaran"> Hasil Bongkaran  <span class="required">*</span> </label>
                                                <select id="inputHasilBongkaran" name="hasil_bongkaran" class="form-control m-input select2 required">
                                                    <option value="">Pilih Hasil Bongkaran</option>
                                                    <option value="1">Terjual</option>
                                                    <option value="2">Tidak Terjual</option>
                                                </select>
                                            </div>

                                            <div class="con-selected conTerjual">
                                                <div class="form-group m-form__group">
                                                    <label for="inputNomorRisalah"> Nomor Risalah Lelang  <span class="required">*</span> </label>
                                                    <input type="text" class="form-control m-input" id="inputNomorRisalah" name="nomor_risalah_lelang" placeholder="Nomor Risalah Lelang" />
                                                </div>
                                                <div class="form-group m-form__group">
                                                    <label for="inputTanggalPerjanjian"> Tanggal Risalah Lelang  <span class="required">*</span> </label>
                                                    <div class="input-group date">
                                                        <input type="text" class="form-control m-input m_datepicker" id="inputTanggalPerjanjian" readonly name="tanggal_risalah_lelang" placeholder="Tanggal Risalah Lelang" />
                                                        <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar"></i>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group">
                                                    <label for="inputPenandaTangan"> Penandatangan Risalah Lelang  <span class="required">*</span> </label>
                                                    <input type="text" class="form-control m-input" id="inputPenandaTangan" name="penandatangan_risalah_lelang" placeholder="Penandatangan Risalah Lelang" />
                                                </div>
                                                <div class="form-group m-form__group">
                                                    <label> Dokumen Risalah Lelang <span class="required">*</span> </label>
                                                    <div class="custom-file">
                                                        <input name="dokumen_risalah_lelang" type="file" accept="application/pdf" class="custom-file-input">
                                                        <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                                </div>
                                            </div>
                                            <div class="con-selected conTidakTerjual">
                                                <div class="form-group m-form__group">
                                                    <label for="inputNomorIzinPemusnahan"> Nomor Izin Pemusnahan  <span class="required">*</span> </label>
                                                    <input type="text" class="form-control m-input" id="inputNomorIzinPemusnahan" name="nomor_izin_pemusnahan" placeholder="Nomor Izin Pemusnahan" />
                                                </div>
                                                <div class="form-group m-form__group">
                                                    <label for="inputTanggalPemusnahan"> Tanggal Izin Pemusnahan  <span class="required">*</span> </label>
                                                    <div class="input-group date">
                                                        <input type="text" class="form-control m-input m_datepicker" id="inputTanggalPemusnahan" readonly name="tanggal_izin_pemusnahan" placeholder="Tanggal Izin Pemusnahan" />
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                <i class="la la-calendar"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group">
                                                    <label for="inputPerihalSurat"> Perihal Surat  <span class="required">*</span> </label>
                                                    <textarea class="form-control m-input" id="inputPerihalSurat" name="perihal_pemusnahan" placeholder="Perihal Surat" rows="5"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 con-selected conTerjual">
                                            <div class="form-group m-form__group">
                                                <label for="inputNomorBast"> Nomor Berita Acara  <span class="required">*</span> </label>
                                                <input type="text" class="form-control m-input" id="inputNomorBast" name="nomor_berita_acara" placeholder="Nomor Berita Acara" />
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputTanggalBeritaAcara"> Tanggal Berita Acara  <span class="required">*</span> </label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control m-input m_datepicker" id="inputTanggalBeritaAcara" readonly name="tanggal_berita_acara" placeholder="Tanggal Berita Acara" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputNilaiLimit"> Nilai Limit  <span class="required">*</span> </label>
                                                <div class="input-group m-input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"> Rp </span>
                                                    </div>
                                                    <input type="text" class="form-control m-input harga" id="inputNilaiLimit" name="nilai_limit" placeholder="Nilai Limit" />
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputNilaiTerjual"> Nilai yang Terjual  <span class="required">*</span> </label>
                                                <div class="input-group m-input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"> Rp </span>
                                                    </div>
                                                    <input type="text" class="form-control m-input harga" id="inputNilaiTerjual" name="nilai_terjual" placeholder="Nilai yang Terjual" />
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label> Dokumen Berita Acara <span class="required">*</span> </label>
                                                <div class="custom-file">
                                                    <input name="dokumen_berita_acara" type="file" accept="application/pdf" class="custom-file-input">
                                                    <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 con-selected conTidakTerjual">
                                            <div class="form-group m-form__group">
                                                <label for="inputNomorBeritaAcaraPemusnahan"> Nomor Berita Acara Pemusnahan  <span class="required">*</span> </label>
                                                <input type="text" class="form-control m-input" id="inputNomorBeritaAcaraPemusnahan" name="nomor_berita_acara_pemusnahan" placeholder="Nomor Berita Acara Pemusnahan" />
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputTanggalBeritaAcaraPemusnahan"> Tanggal Berita Acara Pemusnahan  <span class="required">*</span> </label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control m-input m_datepicker" id="inputTanggalBeritaAcaraPemusnahan" readonly name="tanggal_berita_acara_pemusnahan" placeholder="Tanggal Berita Acara Pemusnahan" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label> Dokumen Surat Persetujuan Pemusnahan <span class="required">*</span> </label>
                                                <div class="custom-file">
                                                    <input name="dokumen_persetujuan_pemusnahan" type="file" accept="application/pdf" class="custom-file-input">
                                                    <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label> Dokumen Berita Acara Pemusnahan Pemusnahan <span class="required">*</span> </label>
                                                <div class="custom-file">
                                                    <input name="dokumen_berita_acara_pemusnahan" type="file" accept="application/pdf" class="custom-file-input">
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

            $('.con-selected').hide();
            $('.select2').select2();
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

            $('#inputHasilBongkaran').change(function () {
                let val = $(this).val();
                if(val == '1') {
                    $('.conTerjual').show();
                    $('.conTidakTerjual').hide();
                } else {
                    $('.conTerjual').hide();
                    $('.conTidakTerjual').show();
                }
            })
        });
    </script>
    @endpush