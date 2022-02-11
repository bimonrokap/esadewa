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
                                                <label for="inputLetterNumber"> No Surat Pengajuan Satker </label>
                                                <input type="text" class="form-control m-input required" id="inputLetterNumber" value="{{ $data->letter_number }}" name="letter_number" placeholder="No Surat Pengajuan Satker" />
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputPenandatangananSurat"> Penandatanganan Surat </label>
                                                <select id="inputPenandatangananSurat" name="penandatangan_surat" class="form-control m-input select2">
                                                    <option value="">Pilih Penandatanganan Surat</option>
                                                    @foreach($penandatanganSurat as $penandatangan)
                                                        <option {!! $penandatangan->id == $data->penandatangan_surat ? 'selected="selected"' : '' !!} value="{{ $penandatangan->id }}">{{ $penandatangan->name }}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputTotalNilai"> Total Nilai Limit </label>
                                                <div class="input-group m-input-group">
                                                    <div class="input-group-prepend">
														<span class="input-group-text"> Rp </span>
                                                    </div>
                                                    <input type="text" class="form-control m-input harga" id="inputTotalNilai" value="{{ $data->total_limit }}" name="total_limit" placeholder="Total Nilai Limit" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group m-form__group">
                                                <label for="inputLetterDate"> Tanggal Surat </label>

                                                <div class="input-group date">
                                                    <input type="text" class="form-control m-input m_datepicker" id="inputLetterDate" readonly value="{{ \Carbon\Carbon::parse($data->letter_date)->format('j F Y') }}" name="letter_date" placeholder="Tanggal Surat" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputPerihalSurat"> Perihal Surat </label>
                                                <textarea class="form-control m-input" id="inputPerihalSurat" name="perihal" placeholder="Perihal Surat" rows="3">{{ $data->perihal }}</textarea>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label> Surat Pengajuan Satuan Kerja </label>
                                                <div class="custom-file">
                                                    <input name="surat_pengajuan_satker" type="file" accept="application/pdf" class="custom-file-input">
                                                    <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                                <p class="form-control-static"><a target="_blank" href="{{ \App\Model\Penjualan\Penjualan::docLocation($data->id, $data->surat_pengajuan_satker, true) }}">Surat Pengajuan Satuan Kerja</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="spar">
                                    <div class="m-form-custom-5 row">
                                        <div class="col-lg-6">
                                            <div class="form-group m-form__group">
                                                <label> SK Panitia Penghapusan </label>
                                                <div class="custom-file">
                                                    <input name="sk_panitia_penghapusan" type="file" accept="application/pdf" class="custom-file-input">
                                                    <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                                <p class="form-control-static"><a target="_blank" href="{{ \App\Model\Penjualan\Penjualan::docLocation($data->id, $data->sk_panitia_penghapusan, true) }}">SK Panitia Penghapusan</a></p>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label>Daftar Penghentian Penggunaan </label>
                                                <div class="custom-file">
                                                    <input name="daftar_penghentian" type="file" accept="application/pdf" class="custom-file-input">
                                                    <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                                <p class="form-control-static"><a target="_blank" href="{{ \App\Model\Penjualan\Penjualan::docLocation($data->id, $data->daftar_penghentian, true) }}">Daftar Penghentian Penggunaan</a></p>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label>SK Penetapan Status Penggunaan atas barang yang akan diusulkan Penghapusan </label>
                                                <div class="custom-file">
                                                    <input name="sk_penetapan_status" type="file" accept="application/pdf" class="custom-file-input">
                                                    <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 50Mb</span>
                                                <p class="form-control-static"><a target="_blank" href="{{ \App\Model\Penjualan\Penjualan::docLocation($data->id, $data->sk_penetapan_status, true) }}">SK Penetapan Status Penggunaan atas barang yang akan diusulkan Penghapusan</a></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group m-form__group">
                                                <label>BA Hasil Penelitian dan Pemeriksaan </label>
                                                <div class="custom-file">
                                                    <input name="ba_hasil" type="file" accept="application/pdf" class="custom-file-input">
                                                    <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                                <p class="form-control-static"><a target="_blank" href="{{ \App\Model\Penjualan\Penjualan::docLocation($data->id, $data->ba_hasil, true) }}">BA Hasil Penelitian dan Pemeriksaan</a></p>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label>Surat Pernyataan Tanggung Jawab Atas Harga Taksiran </label>
                                                <div class="custom-file">
                                                    <input name="surat_pernyataan_tanggung" type="file" accept="application/pdf" class="custom-file-input">
                                                    <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                                <p class="form-control-static"><a target="_blank" href="{{ \App\Model\Penjualan\Penjualan::docLocation($data->id, $data->surat_pernyataan_tanggung, true) }}">SK Panitia Penghapusan</a></p>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label>ADK Simak BMN</label>
                                                @if($backupSimak === null)
                                                    <div class="custom-file">
                                                        <input name="backup_simak" type="file" class="custom-file-input">
                                                        <label class="custom-file-label"> Pilih File </label>
                                                    </div>
                                                    <p class="form-control-static"><a target="_blank" href="{{ \App\Model\Penjualan\Penjualan::docLocation($data->id, $data->backup_simak, true) }}">Simak BMN</a></p>
                                                @else
                                                    <p class="m-form__help"><a href="{{ route("admin.monitoring.simak.download", $backupSimak->id) }}" target="_blank">Backup SIMAK</a></p>
                                                @endif
                                                <span class="m-form__help">File ekstensi .BAC</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabBarang" aria-labelledby="baseIcon-tab2">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @component('admin.components.usulan.tablebarang', ['barangs' => $barangs]) @endcomponent
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabFoto" aria-labelledby="baseIcon-tab3">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @component('admin.components.usulan.foto', ['config' => $config, 'uuid' => $uuid, 'barangs' => $barangs, 'id' => $data->id]) @endcomponent

                                    <div style="margin-top: 10px;">
                                        @component('admin.components.usulan.fotoShow', ['config' => $config, 'fotos' => $data->foto, 'data' => $data, 'edit' => true]) @endcomponent
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

    @component('admin.components.usulan.modalbarang', ['kategoriBarang' => $kategoriBarang]) @endcomponent
    @endsection

@push('scripts')
    <script src="{{ asset('assets/app/js/datatable.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        var jmlBarang = {{ isset($barangs) ? (int)$barangs->count() : 0 }};
        $(document).ready(function () {
            Barang.init({
                url: "{{ route($config['route'] . '.gettable') }}",
                addons: { doc : 'penjualan' }
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