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
                </ul>
                <form class="m-form" action="{{ route($config['route'] . '.store') }}" method="POST" id="form">
                    <div class="tab-content pt-1">
                        {{ csrf_field() }}
                        @component('admin.components.form.alert') @endcomponent
                        <input type="hidden" value="{{ $uuid }}" name="uuid">
                        <div class="tab-pane active" id="tabData" role="tabpanel" aria-expanded="true" aria-labelledby="baseIcon-tab1">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    <div class="m-form-custom-5 row">
                                        <div class="col-lg-6">
                                            <div class="form-group m-form__group">
                                                <label for="inputLetterNumber"> No Surat Pengajuan Satker  <span class="required">*</span> </label>
                                                <input type="text" class="form-control m-input required" id="inputLetterNumber" name="letter_number" placeholder="No Surat Pengajuan Satker" />
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputPenandatangananSurat"> Penandatanganan Surat  <span class="required">*</span> </label>
                                                <select id="inputPenandatangananSurat" name="penandatangan_surat" class="form-control m-input select2 required">
                                                    <option value="">Pilih Penandatanganan Surat</option>
                                                    @foreach($penandatanganSurat as $penandatangan)
                                                        <option value="{{ $penandatangan->id }}">{{ $penandatangan->name }}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label> Surat Pengajuan Satuan Kerja  <span class="required">*</span> </label>
                                                <div class="custom-file">
                                                    <input name="surat_pengajuan_satker" type="file" accept="application/pdf" class="custom-file-input required">
                                                    <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group m-form__group">
                                                <label for="inputLetterDate"> Tanggal Surat  <span class="required">*</span> </label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control m-input required m_datepicker required" id="inputLetterDate" readonly name="letter_date" placeholder="Tanggal Surat" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputPerihalSurat"> Perihal Surat  <span class="required">*</span> </label>
                                                <textarea class="form-control m-input required" id="inputPerihalSurat" name="perihal" placeholder="Perihal Surat" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="spar">
                                    <div class="m-form-custom-5 row">
                                        <div class="col-lg-6">
                                            <div class="form-group m-form__group">
                                                <label for="inputLetterNumberPersetujuan"> No Surat Persetujuan Sewa Pengelola Barang  <span class="required">*</span> </label>
                                                <input type="text" class="form-control m-input required" id="inputLetterNumberPersetujuan" name="no_surat_persetujuan" placeholder="No Surat Persetujuan Sewa Pengelola Barang" />
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputPerihalSuratPersetujuan"> Perihal Surat Persetujuan Sewa Pengelola Barang  <span class="required">*</span> </label>
                                                <textarea class="form-control m-input required" id="inputPerihalSuratPersetujuan" name="perihal_surat_persetujuan" placeholder="Perihal Surat Persetujuan Sewa Pengelola Barang" rows="3"></textarea>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputPenandatangananSuratPersetujuan"> Penandatanganan Persetujuan Sewa Pengelola Barang  <span class="required">*</span> </label>
                                                <input type="text" class="form-control m-input required" id="inputPenandatangananSuratPersetujuan" name="penandatangan_persetujuan" placeholder="Penandatanganan Persetujuan Sewa Pengelola Barang" />
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputNilaiSewa"> Nilai Sewa  <span class="required">*</span> </label>
                                                <div class="input-group m-input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"> Rp </span>
                                                    </div>
                                                    <input type="text" class="form-control m-input harga required" id="inputNilaiSewa" name="nilai_sewa" placeholder="Nilai Sewa" />
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputJenisBmn"> Jenis BMN yang disewa  <span class="required">*</span> </label>
                                                <select id="inputJenisBmn" name="jenis_bmn[]" class="form-control m-input select2 required" multiple="multiple">
                                                    <option value="">Pilih Jenis BMN</option>
                                                    @foreach($jenisBmn as $kategori)
                                                        <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label> Surat Rekomendasi Persetujuan Sewa dari Pengelola Barang  <span class="required">*</span> </label>
                                                <div class="custom-file">
                                                    <input name="surat_rekomendasi" type="file" accept="application/pdf" class="custom-file-input required">
                                                    <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group m-form__group">
                                                <label for="inputLokasi"> Lokasi  <span class="required">*</span> </label>
                                                <textarea class="form-control m-input required" id="inputLokasi" name="lokasi" placeholder="Lokasi" rows="5"></textarea>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputLetterDatePersetujuan"> Tanggal Persetujuan Sewa Pengelola Barang  <span class="required">*</span> </label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control m-input required m_datepicker required" id="inputLetterDatePersetujuan" readonly name="tanggal_surat_persetujuan" placeholder="Tanggal Persetujuan Sewa Pengelola Barang" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputPeriodeSewa"> Periode Sewa  <span class="required">*</span> </label>
                                                <div class="input-group m-input-group">
                                                    <input type="text" class="form-control m-input required" id="inputPeriodeSewa" name="periode" placeholder="Periode Sewa" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"> Bulan </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputLuasAsset"> Luas / Unit Aset yang disewa  <span class="required">*</span> </label>
                                                <div class="input-group m-input-group">
                                                    <input type="text" class="form-control m-input decimal required" id="inputLuasAsset" name="luas_asset" placeholder="Luas / Unit Aset yang disewa" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"> m<sup>2</sup> </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputIdentitasPenyewa"> Identitas Penyewa  <span class="required">*</span> </label>
                                                <input type="text" class="form-control m-input required" id="inputIdentitasPenyewa" name="identitas_penyewa" placeholder="Identitas Penyewa" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabBarang" aria-labelledby="baseIcon-tab2">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @component('admin.components.usulan.tablebarang', ['config' => $config]) @endcomponent
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabFoto" aria-labelledby="baseIcon-tab3">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @component('admin.components.usulan.foto', ['config' => $config, 'uuid' => $uuid, 'param' => ['type' => 'sewa']]) @endcomponent
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
                                        <button type="submit" class="btn btn-success"> Simpan </button>
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

    @component('admin.components.usulan.modalbarang', ['kategoriBarang' => $kategoriBarang]) @endcomponent
    @endsection


@push('scripts')
    <script type="text/javascript">
        var jmlBarang = 0;
        $(document).ready(function () {
            Barang.init({
                url: "{{ route($config['route'] . '.gettable') }}",
                addons: { doc : 'sewa' }
            });

            FormValidation.init({
                'form': '#form',
                'data': {
                    'data' : function () {
                        var id = [];
                        var category = [];
                        $('.btn-hapus', '#con-barang').each(function (index, value) {
                            id.push($(this).data('id'));
                            category.push($(this).data('category'));
                        });

                        return JSON.stringify({'category': category, 'id': id});
                    }
                }
            });

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
            $('.decimal').inputmask('numeric', {
                digits: 3,
                groupSeparator: '.',
                radixPoint: ",",
                removeMaskOnSubmit: false,
                autoGroup: true
            });
        });
    </script>
    @endpush