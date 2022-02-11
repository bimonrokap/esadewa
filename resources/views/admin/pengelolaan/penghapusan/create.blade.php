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
                </ul>
                <form class="m-form" action="{{ route($config['route'] . '.store', $type) }}" method="POST" id="form">
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
                                            @if($isMebelair)
                                                <div class="form-group m-form__group">
                                                    <label for="selectLetterNumberPenjualan"> No Surat Izin Penjualan  <span class="required">*</span> </label>
                                                    <select id="selectLetterNumberPenjualan" name="letter_number_penjualan" class="form-control m-input required">
                                                        <option value="">Pilih Penandatanganan Surat</option>
                                                    </select>
                                                </div>
                                            @else
                                                <div class="form-group m-form__group">
                                                    <label for="inputLetterNumberPenjualan"> No Surat Izin Penjualan  <span class="required">*</span> </label>
                                                    <input type="text" class="form-control m-input required" id="inputLetterNumberPenjualan" name="letter_number_penjualan" placeholder="No Surat Pengajuan Satker" />
                                                </div>
                                            @endif
                                            <div class="form-group m-form__group">
                                                <label for="inputPerihalSuratPenjualan"> Perihal Surat Izin Penjualan {!! !$isMebelair ? '<span class="required">*</span>' : '' !!}</label>
                                                <textarea class="form-control m-input required" id="inputPerihalSuratPenjualan" {{ $isMebelair ? 'disabled' : '' }} name="perihal_penjualan" placeholder="Perihal Surat Izin Penjualan" rows="3"></textarea>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputTotalNilai"> Total Nilai Limit {!! !$isMebelair ? '<span class="required">*</span>' : '' !!}</label>
                                                <div class="input-group m-input-group">
                                                    <div class="input-group-prepend">
														<span class="input-group-text"> Rp </span>
                                                    </div>
                                                    <input type="text" class="form-control m-input harga required" {{ $isMebelair ? 'disabled' : '' }} id="inputTotalNilai" name="total_limit" placeholder="Total Nilai Limit" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group m-form__group">
                                                <label for="inputLetterDatePenjualan"> Tanggal Surat Izin Penjualan {!! !$isMebelair ? '<span class="required">*</span>' : '' !!}</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control m-input required m_datepicker required" {{ $isMebelair ? 'disabled' : '' }} id="inputLetterDatePenjualan" readonly name="letter_date_penjualan" placeholder="Tanggal Izin Surat Penjualan" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label> Surat Izin Penjualan {!! !$isMebelair ? '<span class="required">*</span>' : '' !!}</label>
                                                @if($isMebelair)
                                                    <p id="inputSuratIzinPenjualan" class="form-control-static"><i>Empty</i></p>
                                                @else
                                                    <div class="custom-file">
                                                        <input name="surat_izin_penjualan" type="file" accept="application/pdf" {{ $isMebelair ? 'disabled' : '' }} class="custom-file-input required">
                                                        <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                                @endif
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputNilaiPerolehan"> Nilai Perolehan {!! !$isMebelair ? '<span class="required">*</span>' : '' !!}</label>
                                                <div class="input-group m-input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"> Rp </span>
                                                    </div>
                                                    <input type="text" class="form-control m-input harga required" id="inputNilaiPerolehan" name="nilai_perolehan" placeholder="Nilai Perolehan" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="spar">

                                    <div class="m-form-custom-5 row">
                                        <div class="col-lg-6">
                                            <div class="form-group m-form__group">
                                                <label for="inputRisalahLelang"> No Risalah Lelang  <span class="required">*</span> </label>
                                                <input type="text" class="form-control m-input required" id="inputRisalahLelang" name="risalah_lelang_number" placeholder="No Risalah Lelang" />
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputPenandatangananRisalahLelang"> Penandatanganan Risalah Lelang  <span class="required">*</span> </label>
                                                <input type="text" class="form-control m-input required" id="inputPenandatangananRisalahLelang" name="penandatangan_risalah" placeholder="Penandatanganan Risalah Lelang" />
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputTanggalBeritaAcara"> Tanggal Berita Acara Serah Terima  <span class="required">*</span> </label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control m-input m_datepicker required" id="inputTanggalBeritaAcara" readonly name="tanggal_berita_acara" placeholder="Tanggal Berita Acara Serah Terima" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label> Risalah Lelang  <span class="required">*</span> </label>
                                                <div class="custom-file">
                                                    <input name="risalah_lelang" type="file" accept="application/pdf" class="custom-file-input required">
                                                    <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group m-form__group">
                                                <label for="inputTotalNilaiTerjual"> Total Nilai Terjual  <span class="required">*</span> </label>
                                                <div class="input-group m-input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"> Rp </span>
                                                    </div>
                                                    <input type="text" class="form-control m-input harga required" id="inputTotalNilaiTerjual" name="total_terjual" placeholder="Total Nilai Terjual" />
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputRisalahLelangDate"> Tanggal Risalah Lelang  <span class="required">*</span> </label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control m-input required m_datepicker required" id="inputRisalahLelangDate" readonly name="risalah_lelang_date" placeholder="Tanggal Risalah Lelang" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputNomorBast"> Nomor Berita Acara Serah Terima  <span class="required">*</span> </label>
                                                <input type="text" class="form-control m-input required" id="inputNomorBast" name="nomor_berita_acara" placeholder="Nomor Berita Acara Serah Terima" />
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label> Surat Berta Acara  <span class="required">*</span> </label>
                                                <div class="custom-file">
                                                    <input name="surat_berita_acara" type="file" accept="application/pdf" class="custom-file-input required">
                                                    <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="spar">

                                    <div class="m-form-custom-5 row">
                                        <div class="col-lg-6">
                                            <div class="form-group m-form__group">
                                                <label> Daftar Barang yang Diusulkan {!! !$isMebelair ? '<span class="required">*</span>' : '' !!}</label>
                                                <div class="custom-file">
                                                    <input name="daftar_barang" type="file" accept="application/pdf" class="custom-file-input {{ !$isMebelair ? 'required' : '' }}">
                                                    <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label> Dokumen Lainnya </label>
                                                <div class="custom-file">
                                                    <input name="dokumen_lainnya" type="file" accept="application/pdf" class="custom-file-input">
                                                    <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            @if($isMebelair)
                                                <div class="form-group m-form__group">
                                                    <label> Surat Keterangan </label>
                                                    <div class="custom-file">
                                                        <input name="surat_keterangan" type="file" accept="application/pdf" class="custom-file-input">
                                                        <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                                </div>
                                            @endif
                                            <div class="form-group m-form__group">
                                                <label> Daftar Barang Rusak Berat {!! !$isMebelair ? '<span class="required">*</span>' : '' !!}</label>
                                                <div class="custom-file">
                                                    <input name="daftar_barang_rusak" type="file" accept="application/pdf" class="custom-file-input {{ !$isMebelair ? 'required' : '' }}">
                                                    <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabBarang" aria-labelledby="baseIcon-tab2">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @if($isMebelair)
                                        @component('admin.components.usulan.tablebarangfill', ['config' => $config]) @endcomponent
                                    @else
                                        @component('admin.components.usulan.tablebarang', ['config' => $config, 'type' => $type]) @endcomponent
                                    @endif
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

    @if(!$isMebelair)
        @component('admin.components.usulan.modalbarang', ['kategoriBarang' => $kategoriBarang]) @endcomponent
    @endif
    @endsection


@push('scripts')
    <script type="text/javascript">
        var jmlBarang = 0;
        $(document).ready(function () {
            @if(!$isMebelair)
                Barang.init({
                    url: "{{ route($config['route'] . '.gettable') }}",
                    addons: { doc : 'penghapusan' }
                });
            @endif

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
            $('#selectLetterNumberPenjualan').select2({
                allowClear: true,
                ajax: {
                    url: '{{ route($config['route'] . '.penjualan') }}',
                    data: function (params) {
                        let query = {
                            search: params.term,
                        }
                        return query;
                    }
                },
                placeholder: "Pilih No Surat Izin Penjualan",
            });
            $('#selectLetterNumberPenjualan').change(function () {
                mApp.block('#form');
                let val = $(this).val();
                $.get('{{ route($config['route'] . '.detailPenjualan') }}/'+val, function (res) {
                    $('#inputLetterDatePenjualan').val(res.data.letter_date);
                    $('#inputPerihalSuratPenjualan').val(res.data.perihal)
                    $('#inputSuratIzinPenjualan').html(`<a target="_blank" href="`+res.data.surat_persetujuan+`">Surat Izin Penjualan</a>`);
                    $('#inputTotalNilai').val(res.data.total_limit);
                    $('#inputNilaiPerolehan').val(res.nilaiPerolehan);

                    $('#con-barang #empty-row').hide();
                    jmlBarang++;
                    $.each(res.barang, function (index, value) {
                        $('#con-barang').append(`
                            <tr>
                                <td scope="row" class="text-center number"> `+jmlBarang+` </td>
                                <td class="text-center"> `+value.nup+` </td>
                                <td> `+value.kode_barang+` </td>
                                <td> `+value.nama_barang+` </td>
                                <td class="text-right"> Rp `+$.number( value.nilai_perolehan, 0, ',', '.' )+` </td>
                                <td> `+value.category+` </td>
                            </tr>
                        `);
                    });

                    mApp.unblock('#form');
                });
            });

            $('.m_selectpicker').selectpicker();
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