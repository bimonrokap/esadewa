@switch($type)
    @case(1)
        <div class="tab-pane active" id="tabData" role="tabpanel" aria-expanded="true" aria-labelledby="baseIcon-tab1">
            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                <div class="m-portlet__body">
                    <div class="m-form-custom-5 row">
                        <div class="col-lg-6">
                            <div class="form-group m-form__group">
                                <label for="inputLetterNumber"> No Surat Pengajuan Satker </label>
                                <p class="form-control-static">{{ $data->letter_number }}</p>
                            </div>
                            <div class="form-group m-form__group">
                                <label for="inputJenisPengadaan"> Jenis Pengadaan </label>
                                <p class="form-control-static">Tanah {{ $data->tanah->jenisPengadaan->name }}</p>
                            </div>
                            <div class="form-group m-form__group">
                                <label for="inputPenandatangananSurat"> Penandatanganan Surat </label>
                                <p class="form-control-static">{{ $data->penandatanganSurat->name }}</p>
                            </div>
                            <div class="form-group m-form__group">
                                <label> TOR ditandatangani KPA </label>
                                <p class="form-control-static">
                                    @include('components.form.fileButton', ['title' => 'TOR ditandatangani KPA', 'type' => 'pdf', 'url' => \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($data->id, $data->tanah->tor, true)])
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group m-form__group">
                                <label for="inputLetterDate"> Tanggal Surat </label>
                                <p class="form-control-static">{{ \Carbon\Carbon::parse($data->letter_date)->format('j F Y') }}</p>
                            </div>
                            <div class="form-group m-form__group">
                                <label for="inputRkbmn"> Informasi RKBMN </label>
                                <p class="form-control-static">{!! $data->rkbmnUraian != null ? '<a href="javascript:;" id="btn-exist-detail">'.($data->rkbmnUraian->no_pengadaan.'/'.$data->rkbmnUraian->kode_barang.'/'.$data->rkbmnUraian->kode_satker).'</a>' : '' !!}</p>
                            </div>
                            <div class="form-group m-form__group">
                                <label for="inputPerihalSurat"> Perihal Surat </label>
                                <p class="form-control-static">{!! nl2br($data->perihal) !!} </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @for($i = 1; $i <= ($data->tanah->tanah_type == 2 ? 1 : 3); $i++)
        <div class="tab-pane" id="tabPenawaran{{ $i }}" aria-labelledby="baseIcon-tab{{ $i+5 }}">
            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                <div class="m-portlet__body">
                    @component('admin.components.usulan.penawaranShow', ['config' => $config, 'id' => $data->id, 'data' => $data->tanah->penawaran[$i-1]]) @endcomponent
                </div>
            </div>
        </div>
        @endfor
    @break
    @case(2)
        <div class="tab-pane active" id="tabData" role="tabpanel" aria-expanded="true" aria-labelledby="baseIcon-tab1">
            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                <div class="m-portlet__body">
                    <div class="m-form-custom-5 row">
                        <div class="col-lg-6">
                            <div class="form-group m-form__group">
                                <label for="inputLetterNumber"> No Surat Pengajuan Satker </label>
                                <p class="form-control-static">{{ $data->letter_number }}</p>
                            </div>
                            <div class="form-group m-form__group">
                                <label for="inputJenisPembangunan"> Jenis Pembangunan </label>
                                <p class="form-control-static">{{ $jenisPembangunan[$data->pembangunan->jenis_pembangunan] }}</p>
                            </div>
                            <div class="form-group m-form__group">
                                <label for="inputPenandatangananSurat"> Penandatanganan Surat </label>
                                <p class="form-control-static">{{ $data->penandatanganSurat->name }}</p>
                            </div>
                            <div class="form-group m-form__group">
                                <label> Surat Pengajuan Satker </label>
                                <p class="form-control-static">
                                    @include('components.form.fileButton', ['title' => 'Surat Pengajuan Satker', 'type' => 'pdf', 'url' => \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($data->id, $data->pembangunan->surat_pengajuan, true)])
                                </p>
                            </div>
                            <div class="form-group m-form__group">
                                <label> Penetapan Status Penggunaan (PSP) barang (Tanah yang akan Dibangun) </label>
                                <p class="form-control-static">
                                    @include('components.form.fileButton', ['title' => 'Penetapan Status Penggunaan (PSP) barang (Tanah yang akan Dibangun)', 'type' => 'pdf', 'url' => \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($data->id, $data->pembangunan->surat_psp, true)])
                                </p>
                            </div>
                            <div class="form-group m-form__group">
                                <label> Harga Satuan Gedung Bangunan Negara (HSBGN) Tahun Terakhir dari Pemerintah Daerah Setempat </label>
                                <p class="form-control-static">
                                    @include('components.form.fileButton', ['title' => 'Harga Satuan Gedung Bangunan Negara (HSBGN) Tahun Terakhir dari Pemerintah Daerah Setempat', 'type' => 'pdf', 'url' => \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($data->id, $data->pembangunan->surat_harga_satuan, true)])
                                </p>
                            </div>
                            <div class="form-group m-form__group">
                                <label> TOR dan RAB dari PU </label>
                                <p class="form-control-static">
                                    @include('components.form.fileButton', ['title' => 'TOR dan RAB dari PU', 'type' => 'pdf', 'url' => \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($data->id, $data->pembangunan->tor, true)])
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group m-form__group">
                                <label for="inputLetterDate"> Tanggal Surat </label>
                                <p class="form-control-static">{{ \Carbon\Carbon::parse($data->letter_date)->format('j F Y') }}</p>
                            </div>
                            <div class="form-group m-form__group">
                                <label for="inputRkbmn"> Informasi RKBMN </label>
                                <p class="form-control-static">{!! $data->rkbmnUraian != null ? '<a href="javascript:;" id="btn-exist-detail">'.($data->rkbmnUraian->no_pengadaan.'/'.$data->rkbmnUraian->kode_barang.'/'.$data->rkbmnUraian->kode_satker).'</a>' : '' !!}</p>
                            </div>
                            <div class="form-group m-form__group">
                                <label for="inputPerihalSurat"> Perihal Surat </label>
                                <p class="form-control-static">{!! nl2br($data->perihal) !!}</p>
                            </div>
                            <div class="form-group m-form__group">
                                <label> Rencana Tata Ruang Wilayah (RTRW) Pemerintah Daerah Setempat</label>
                                <p class="form-control-static">
                                    @include('components.form.fileButton', ['title' => 'Rencana Tata Ruang Wilayah (RTRW) Pemerintah Daerah Setempat', 'type' => 'pdf', 'url' => \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($data->id, $data->pembangunan->surat_rencana, true)])
                                </p>
                            </div>
                            <div class="form-group m-form__group">
                                <label> Analisa Pembianyaan dari PU</label>
                                <p class="form-control-static">
                                    @include('components.form.fileButton', ['title' => 'Analisa Pembianyaan dari PU', 'type' => 'pdf', 'url' => \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($data->id, $data->pembangunan->surat_analisa, true)])
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="tabBarang" aria-labelledby="baseIcon-tab2">
            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                <div class="m-portlet__body">
                    @component('admin.components.usulan.tablebarangfill', ['barangs' => $barangs]) @endcomponent
                    <hr>
                    <table class="table m-table ">
                        <tbody>
                        <tr>
                            <td colspan="2"><strong>Luas Bangunan</strong></td>
                            <td width="300px">
                                <p class="form-control-static">{{ numberFormatIndo($data->pembangunan->luas_bangunan) }} m<up>2</up></p>
                            </td>
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td colspan="6"><strong>Total Biaya Pembangunan</strong></td>
                        </tr>
                        <tr>
                            <td width="30px"></td>
                            <td width="200px"><strong>Biaya Pekerjaan Fisik</strong></td>
                            <td>
                                <p class="form-control-static">Rp {{ numberFormatIndo($data->pembangunan->biaya_fisik) }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><strong>Biaya Perencanaan</strong></td>
                            <td>
                                <p class="form-control-static">Rp {{ numberFormatIndo($data->pembangunan->biaya_perencanaan) }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><strong>Biaya Pengawasan</strong></td>
                            <td>
                                <p class="form-control-static">Rp {{ numberFormatIndo($data->pembangunan->biaya_pengawasan) }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><strong>Biaya Pengelolaan Kegiatan</strong></td>
                            <td>
                                <p class="form-control-static">Rp {{ numberFormatIndo($data->pembangunan->biaya_pengelolaan) }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><strong>Pajak Pembangunan</strong></td>
                            <td>
                                <p class="form-control-static">Rp {{ numberFormatIndo($data->pembangunan->pajak_pembangunan) }}</p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="tabFoto" aria-labelledby="baseIcon-tab3">
            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                <div class="m-portlet__body">
                    <div style="margin-top: 10px;">
                        @component('admin.components.usulan.fileShow', ['config' => $config, 'files' => $data->pembangunan->gambar, 'data' => $data]) @endcomponent
                    </div>
                </div>
            </div>
        </div>
    @break
    @case(3)
        <div class="tab-pane active" id="tabData" role="tabpanel" aria-expanded="true" aria-labelledby="baseIcon-tab1">
            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                <div class="m-portlet__body">
                    <div class="m-form-custom-5 row">
                        <div class="col-lg-6">
                            <div class="form-group m-form__group">
                                <label for="inputLetterNumber"> No Surat Pengajuan Satker </label>
                                <p class="form-control-static">{{ $data->letter_number }}</p>
                            </div>
                            <div class="form-group m-form__group">
                                <label for="inputJenisBarang"> Jenis Barang </label>
                                <p class="form-control-static">{{ $jenisBarang[$data->renovasi->jenis_barang] }}</p>
                            </div>
                            <div class="form-group m-form__group">
                                <label for="inputPenandatangananSurat"> Penandatanganan Surat </label>
                                <p class="form-control-static">{{ $data->penandatanganSurat->name }}</p>
                            </div>
                            <div class="form-group m-form__group">
                                <label for="inputRkbmn"> Informasi RKBMN </label>
                                <p class="form-control-static">{!! $data->rkbmnUraian != null ? '<a href="javascript:;" id="btn-exist-detail">'.($data->rkbmnUraian->no_pengadaan.'/'.$data->rkbmnUraian->kode_barang.'/'.$data->rkbmnUraian->kode_satker).'</a>' : '' !!}</p>
                            </div>
                            <div class="form-group m-form__group">
                                <label> Luas Bangunan Sebelum Direnovasi / Rehabilitasi / Restorasi <span class="required">*</span></label>
                                <p class="form-control-static">{{ $data->renovasi->luas_bangunan }} m<sup>2</sup></p>
                            </div>
                            <div class="form-group m-form__group">
                                <label for="inputTingkatKerusakan"> Tingkat Kerusakan </label>
                                <p class="form-control-static">{{ $tingkatKerusakan[$data->renovasi->tingkat_kerusakan] }} m<sup>2</sup></p>
                            </div>
                            <div class="form-group m-form__group">
                                <label for="inputBiayaFisik"> Biaya Pekerjaan Fisik </label>
                                <p class="form-control-static">Rp {{ numberFormatIndo($data->renovasi->biaya_fisik) }}</p>
                            </div>
                            <div class="form-group m-form__group">
                                <label for="inputBiayaPerencanaan"> Biaya Perencanaan </label>
                                <p class="form-control-static">Rp {{ numberFormatIndo($data->renovasi->biaya_perencanaan) }}</p>
                            </div>
                            <div class="form-group m-form__group">
                                <label for="inputBiayaPengawasan"> Biaya Pengawasan </label>
                                <p class="form-control-static">Rp {{ numberFormatIndo($data->renovasi->biaya_pengawasan) }}</p>
                            </div>
                            <div class="form-group m-form__group">
                                <label for="inputBiayaPengelolaan"> Biaya Pengelolaan Kegiatan </label>
                                <p class="form-control-static">Rp {{ numberFormatIndo($data->renovasi->biaya_pengelolaan) }}</p>
                            </div>
                            <div class="form-group m-form__group">
                                <label for="inputPajakPembangunan"> Pajak Pembangunan </label>
                                <p class="form-control-static">Rp {{ numberFormatIndo($data->renovasi->pajak_pembangunan) }}</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group m-form__group">
                                <label for="inputLetterDate"> Tanggal Surat </label>
                                <p class="form-control-static">{{ \Carbon\Carbon::parse($data->letter_date)->format('j F Y') }}</p>
                            </div>
                            <div class="form-group m-form__group">
                                <label for="inputJenisPekerjaan"> Jenis Pekerjaan </label>
                                <p class="form-control-static">{{ $jenisPekerjaan[$data->renovasi->jenis_pekerjaan] }}</p>
                            </div>
                            <div class="form-group m-form__group">
                                <label for="inputPerihalSurat"> Perihal Surat </label>
                                <p class="form-control-static">{!! nl2br($data->perihal) !!} </p>
                            </div>
                            <div class="form-group m-form__group">
                                <label> Rencana Luas Bangunan setelah Direnovasi / Rehabilitasi / Restorasi <span class="required">*</span></label>
                                <p class="form-control-static">{{ $data->renovasi->luas_bangunan_rencana }} m<sup>2</sup></p>
                            </div>
                            <div class="form-group m-form__group">
                                <label> Surat Pengajuan Satker </label>
                                <p class="form-control-static">
                                    @include('components.form.fileButton', ['title' => 'Surat Pengajuan Satker', 'type' => 'pdf', 'url' => \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($data->id, $data->renovasi->surat_pengajuan, true)])
                                </p>
                            </div>
                            <div class="form-group m-form__group">
                                <label> Penetapan Status Pengguna (PSP) barang (Tanah dan Bangunan) </label>
                                <p class="form-control-static">
                                    @include('components.form.fileButton', ['title' => 'Penetapan Status Pengguna (PSP) barang (Tanah dan Bangunan)', 'type' => 'pdf', 'url' => \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($data->id, $data->renovasi->surat_psp, true)])
                                </p>
                            </div>
                            <div class="form-group m-form__group">
                                <label> Harga Satuan Gedung Bangunan Negara (HSBGN) Tahun Terakhir dari Pemerintah Daerah Setempat </label>
                                <p class="form-control-static">
                                    @include('components.form.fileButton', ['title' => 'Harga Satuan Gedung Bangunan Negara (HSBGN) Tahun Terakhir dari Pemerintah Daerah Setempat', 'type' => 'pdf', 'url' => \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($data->id, $data->renovasi->surat_harga, true)])
                                </p>
                            </div>
                            <div class="form-group m-form__group">
                                <label> Analisa Tingkat Kerusakan Bangunan </label>
                                <p class="form-control-static">
                                    @include('components.form.fileButton', ['title' => 'Analisa Tingkat Kerusakan Bangunan', 'type' => 'pdf', 'url' => \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($data->id, $data->renovasi->analisa_kerusakan, true)])
                                </p>
                            </div>
                            <div class="form-group m-form__group">
                                <label> Analisa Pembianyaan dari PU </label>
                                <p class="form-control-static">
                                    @include('components.form.fileButton', ['title' => 'Analisa Pembianyaan dari PU', 'type' => 'pdf', 'url' => \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($data->id, $data->renovasi->analisa_pu, true)])
                                </p>
                            </div>
                            <div class="form-group m-form__group">
                                <label> TOR dan RAB dari PU </label>
                                <p class="form-control-static">
                                    @include('components.form.fileButton', ['title' => 'TOR dan RAB dari PU', 'type' => 'pdf', 'url' => \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($data->id, $data->renovasi->tor, true)])
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="tabFoto" aria-labelledby="baseIcon-tab3">
            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                <div class="m-portlet__body">
                    <div style="margin-top: 10px;">
                        @component('admin.components.usulan.fotoShow', ['config' => $config, 'fotos' => $data->renovasi->foto, 'data' => $data, 'param' => ['type' => 'pengadaan-renovasi']]) @endcomponent
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="tabGambarDenah" aria-labelledby="baseIcon-tab7">
            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                <div class="m-portlet__body">
                    <div style="margin-top: 10px;">
                        @component('admin.components.usulan.fileShow', ['config' => $config, 'files' => $data->renovasi->gambarEksisting, 'data' => $data, 'param' => ['type' => 'pengadaan-renovasi-eksisting']]) @endcomponent
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="tabGambarRencana" aria-labelledby="baseIcon-tab8">
            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                <div class="m-portlet__body">
                    <div style="margin-top: 10px;">
                        @component('admin.components.usulan.fileShow', ['config' => $config, 'files' => $data->renovasi->gambarRencana, 'data' => $data, 'param' => ['type' => 'pengadaan-renovasi-rencana']]) @endcomponent
                    </div>
                </div>
            </div>
        </div>
    @break
@endswitch

@push('scripts')

    <div class="modal fade" id="modalRkbmnDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="max-width: 1000px" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Detail RKBMN </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> &times; </span>
                    </button>
                </div>
                <form class="m-form m-form--label-align-right" action="#" method="POST" id="form">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="con-data"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-pilih"> Pilih </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> Tutup </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#btn-exist-detail').click(function () {

                @if($data->rkbmnUraian != null)
                let id = '{{ $data->rkbmnUraian->id }}';

                $.get('{{ route($config['route'] . '.detailRkbmn') }}/'+id, {type : 'detail'}, function (html) {
                    $('#modalRkbmnDetail .con-data').html(html);
                    $('#modalRkbmnDetail .btn-pilih').hide();
                    $('#modalRkbmnDetail').modal('show');
                });
                @endif

                return false;
            });
        });
    </script>
    @endpush