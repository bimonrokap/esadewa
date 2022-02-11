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
                        <a class="nav-link" id="baseIcon-tab3" data-toggle="tab" aria-controls="tabFoto" href="#tabFoto" aria-expanded="false"><i class="la la-image"></i> Foto Bangunan </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="baseIcon-tab7" data-toggle="tab" aria-controls="tabGambarDenah" href="#tabGambarDenah" aria-expanded="false"><i class="la la-map"></i> Gambar Denah Eksisting </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="baseIcon-tab8" data-toggle="tab" aria-controls="tabGambarRencana" href="#tabGambarRencana" aria-expanded="false"><i class="la la-map-marker"></i> Gambar Rencana Usulan </a>
                    </li>
                </ul>
                <form class="m-form" action="{{ route($config['route'] . '.update', $data->id) }}" method="POST" id="form">
                    <div class="tab-content pt-1">
                        {{ csrf_field() }}
                        {{ method_field("PATCH") }}
                        @component('admin.components.form.alert') @endcomponent
                        <input type="hidden" value="{{ $uuid }}" name="uuid">
                        @if($isRevisi)
                            <div class="m-alert m-alert--icon m-alert--outline alert alert-warning alert-dismissible fade show" role="alert">
                                <div class="m-alert__icon">
                                    <i class="la la-warning"></i>
                                </div>
                                <div class="m-alert__text"><strong>Keterangan Ditolak : </strong>{!! nl2br($data->keterangan_veriftk) !!}</div>
                            </div>
                        @endif
                        <div class="tab-pane active" id="tabData" role="tabpanel" aria-expanded="true" aria-labelledby="baseIcon-tab1">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    <div class="m-form-custom-5 row">
                                        <div class="col-lg-6">
                                            <div class="form-group m-form__group">
                                                <label for="inputLetterNumber"> No Surat Pengajuan Satker  <span class="required">*</span> </label>
                                                <input type="text" class="form-control m-input required" id="inputLetterNumber" value="{{ $data->letter_number }}" name="letter_number" placeholder="No Surat Pengajuan Satker" />
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputJenisBarang"> Jenis Barang  <span class="required">*</span> </label>
                                                <select id="inputJenisBarang" name="jenis_barang" class="form-control m-input select2 required">
                                                    <option value="">Pilih Jenis Barang</option>
                                                    @foreach($jenisBarang as $k => $jenis)
                                                        <option {!! $data->renovasi->jenis_barang == $k ? 'selected="selected"' : '' !!} value="{{ $k }}">{{ $jenis }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputPenandatangananSurat"> Penandatanganan Surat  <span class="required">*</span> </label>
                                                <select id="inputPenandatangananSurat" name="penandatangan_surat" class="form-control m-input select2 required">
                                                    <option value="">Pilih Penandatanganan Surat</option>
                                                    @foreach($penandatanganSurat as $penandatangan)
                                                        <option {!! $data->penandatangan_surat == $penandatangan->id ? 'selected="selected"' : '' !!} value="{{ $penandatangan->id }}">{{ $penandatangan->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputRkbmn"> Informasi RKBMN </label>
                                                <div class="input-group date">
                                                    <input value="{{ $data->rkbmnUraian != null ? $data->rkbmnUraian->no_pengadaan.'/'.$data->rkbmnUraian->kode_barang.'/'.$data->rkbmnUraian->kode_satker : '' }}" type="text" class="form-control m-input" id="inputRkbmn" readonly placeholder="Informasi RKBMN" />
                                                    <input type="hidden" name="id_rkbmn_uraian" value="{{ $data->id_rkbmn_uraian }}" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-align-center "></i>
                                                        </span>
                                                        <button disabled type="button" class="btn btn-primary m-btn m-btn--icon-only"  id="btn-exist-detail">
                                                            <span> <i class="la la-eye"></i></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group m-form__group">
                                                <label> Luas Bangunan Sebelum Direnovasi / Rehabilitasi / Restorasi <span class="required">*</span></label>
                                                <div class="input-group m-input-group">
                                                    <input type="text" class="form-control m-input harga required" value="{{ $data->renovasi->luas_bangunan }}" name="luas_bangunan" placeholder="Luas Bangunan Sebelum Direnovasi / Rehabilitasi / Restorasi" />
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"> m<sup>2</sup> </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputTingkatKerusakan"> Tingkat Kerusakan  <span class="required">*</span> </label>
                                                <select id="inputTingkatKerusakan" name="tingkat_kerusakan" class="form-control m-input select2 required">
                                                    <option value="">Pilih Tingkat Kerusakan</option>
                                                    @foreach($tingkatKerusakan as $k => $tingkat)
                                                        <option {!! $data->renovasi->tingkat_kerusakan == $k ? 'selected="selected"' : '' !!} value="{{ $k }}">{{ $tingkat }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputBiayaFisik"> Biaya Pekerjaan Fisik </label>
                                                <div class="input-group m-input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"> Rp </span>
                                                    </div>
                                                    <input type="text" class="form-control m-input harga" id="inputBiayaFisik" value="{{ $data->renovasi->biaya_fisik }}" name="biaya_fisik" placeholder="Biaya Pekerjaan Fisik" />
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputBiayaPerencanaan"> Biaya Perencanaan  <span class="required">*</span> </label>
                                                <div class="input-group m-input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"> Rp </span>
                                                    </div>
                                                    <input type="text" class="form-control m-input harga required" id="inputBiayaPerencanaan" value="{{ $data->renovasi->biaya_perencanaan }}" name="biaya_perencanaan" placeholder="Biaya Perencanaan" />
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputBiayaPengawasan"> Biaya Pengawasan  <span class="required">*</span> </label>
                                                <div class="input-group m-input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"> Rp </span>
                                                    </div>
                                                    <input type="text" class="form-control m-input harga required" id="inputBiayaPengawasan" value="{{ $data->renovasi->biaya_pengawasan }}" name="biaya_pengawasan" placeholder="Biaya Pengawasan" />
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputBiayaPengelolaan"> Biaya Pengelolaan Kegiatan  <span class="required">*</span> </label>
                                                <div class="input-group m-input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"> Rp </span>
                                                    </div>
                                                    <input type="text" class="form-control m-input harga required" id="inputBiayaPengelolaan" value="{{ $data->renovasi->biaya_pengelolaan }}" name="biaya_pengelolaan" placeholder="Biaya Pengelolaan Kegiatan" />
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputPajakPembangunan"> Pajak Pembangunan  <span class="required">*</span> </label>
                                                <div class="input-group m-input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"> Rp </span>
                                                    </div>
                                                    <input type="text" class="form-control m-input harga required" id="inputPajakPembangunan" value="{{ $data->renovasi->pajak_pembangunan }}" name="pajak_pembangunan" placeholder="Pajak Pembangunan" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group m-form__group">
                                                <label for="inputLetterDate"> Tanggal Surat  <span class="required">*</span> </label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control m-input required m_datepicker required" id="inputLetterDate" readonly value="{{ \Carbon\Carbon::parse($data->letter_date)->format('j F Y') }}" name="letter_date" placeholder="Tanggal Surat" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputJenisPekerjaan"> Jenis Pekerjaan  <span class="required">*</span> </label>
                                                <select id="inputJenisPekerjaan" name="jenis_pekerjaan" class="form-control m-input select2 required">
                                                    <option value="">Pilih Jenis Pekerjaan</option>
                                                    @foreach($jenisPekerjaan as $k => $jenis)
                                                        <option {{ $data->renovasi->jenis_pekerjaan == $k ? 'selected="selected"' : '' }} value="{{ $k }}">{{ $jenis }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputPerihalSurat"> Perihal Surat  <span class="required">*</span> </label>
                                                <textarea class="form-control m-input required" id="inputPerihalSurat" name="perihal" placeholder="Perihal Surat" rows="5">{!! $data->perihal !!}</textarea>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label> Rencana Luas Bangunan setelah Direnovasi / Rehabilitasi / Restorasi <span class="required">*</span></label>
                                                <div class="input-group m-input-group">
                                                    <input type="text" class="form-control m-input harga required" value="{{ $data->renovasi->luas_bangunan_rencana }}" name="luas_bangunan_rencana" placeholder="Rencana Luas Bangunan setelah Direnovasi / Rehabilitasi / Restorasi" />
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"> m<sup>2</sup> </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label> Surat Pengajuan Satker </label>
                                                <div class="custom-file">
                                                    <input name="surat_pengajuan" type="file" accept="application/pdf" class="custom-file-input">
                                                    <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                                <p class="form-control-static"><a target="_blank" href="{{ \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($data->id, $data->renovasi->surat_pengajuan, true) }}">Surat Pengajuan Satker</a></p>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label> Penetapan Status Pengguna (PSP) barang (Tanah dan Bangunan) </label>
                                                <div class="custom-file">
                                                    <input name="surat_psp" type="file" accept="application/pdf" class="custom-file-input">
                                                    <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                                <p class="form-control-static"><a target="_blank" href="{{ \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($data->id, $data->renovasi->surat_psp, true) }}">Penetapan Status Pengguna (PSP) barang (Tanah dan Bangunan)</a></p>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label> Harga Satuan Gedung Bangunan Negara (HSBGN) Tahun Terakhir dari Pemerintah Daerah Setempat </label>
                                                <div class="custom-file">
                                                    <input name="surat_harga" type="file" accept="application/pdf" class="custom-file-input">
                                                    <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                                <p class="form-control-static"><a target="_blank" href="{{ \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($data->id, $data->renovasi->surat_harga, true) }}">Harga Satuan Gedung Bangunan Negara (HSBGN) Tahun Terakhir dari Pemerintah Daerah Setempat</a></p>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label> Analisa Tingkat Kerusakan Bangunan </label>
                                                <div class="custom-file">
                                                    <input name="analisa_kerusakan" type="file" accept="application/pdf" class="custom-file-input">
                                                    <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                                <p class="form-control-static"><a target="_blank" href="{{ \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($data->id, $data->renovasi->analisa_kerusakan, true) }}">Analisa Tingkat Kerusakan Bangunan</a></p>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label> Analisa Pembianyaan dari PU </label>
                                                <div class="custom-file">
                                                    <input name="analisa_pu" type="file" accept="application/pdf" class="custom-file-input">
                                                    <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                                <p class="form-control-static"><a target="_blank" href="{{ \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($data->id, $data->renovasi->analisa_pu, true) }}">Analisa Pembianyaan dari PU</a></p>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label> TOR dan RAB dari PU </label>
                                                <div class="custom-file">
                                                    <input name="tor" type="file" accept="application/pdf" class="custom-file-input">
                                                    <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                                <p class="form-control-static"><a target="_blank" href="{{ \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($data->id, $data->renovasi->tor, true) }}">TOR dan RAB dari PU</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabFoto" aria-labelledby="baseIcon-tab3">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @component('admin.components.usulan.foto', ['config' => $config, 'uuid' => $uuid, 'id' => $data->id, 'param' => ['type' => 'pengadaan-renovasi']]) @endcomponent

                                    <div style="margin-top: 10px;">
                                        @component('admin.components.usulan.fotoShow', ['config' => $config, 'fotos' => $data->renovasi->foto, 'data' => $data, 'edit' => true, 'param' => ['type' => 'pengadaan-renovasi']]) @endcomponent
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabGambarDenah" aria-labelledby="baseIcon-tab7">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @component('admin.components.usulan.file', ['config' => $config, 'id' => $data->id, 'uuid' => $uuid.'-1', 'ext' => '.pdf', 'maxFileSize' => 30, 'param' => ['type' => 'pengadaan-renovasi-eksisting']]) @endcomponent

                                    <div style="margin-top: 10px;">
                                        @component('admin.components.usulan.fileShow', ['config' => $config, 'files' => $data->renovasi->gambarEksisting, 'data' => $data, 'edit' => true, 'param' => ['type' => 'pengadaan-renovasi-eksisting']]) @endcomponent
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabGambarRencana" aria-labelledby="baseIcon-tab8">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @component('admin.components.usulan.file', ['config' => $config, 'id' => $data->id, 'uuid' => $uuid.'-2', 'ext' => '.pdf', 'maxFileSize' => 30, 'param' => ['type' => 'pengadaan-renovasi-rencana']]) @endcomponent

                                    <div style="margin-top: 10px;">
                                        @component('admin.components.usulan.fileShow', ['config' => $config, 'files' => $data->renovasi->gambarRencana, 'data' => $data, 'edit' => true, 'param' => ['type' => 'pengadaan-renovasi-rencana']]) @endcomponent
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet m-portlet--mobile m-portlet--footer-only">
                        <a href="{{ route($config['route'] . '.edit', $data->id) }}" class="ajaxify" id="reload" style="display: none;"></a>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <div class="row">
                                    <div class="col-lg-12 text-right">
                                        <button type="submit" class="btn btn-success"> Ubah </button>
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
    @component('admin.components.usulan.rkbmn', ['table' => $table, 'config' => $config]) @endcomponent
    @endsection

@push('scripts')
    <script type="text/javascript">
        var jmlBarang = 0;
        $(document).ready(function () {
            FormValidation.init({ 'form': '#form' });

            $('.select2').select2();
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
            $('.harga').inputmask('numeric', {
                digits: 0,
                groupSeparator: '.',
                radixPoint: ",",
                removeMaskOnSubmit: false,
                autoGroup: true
            });
        });
    </script>
    @endpush