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
                        <a class="nav-link" id="baseIcon-tab4" data-toggle="tab" aria-controls="tabTingkatBanding" href="#tabTingkatBanding" aria-expanded="false"><i class="la la-cc-discover"></i> Tingkat Banding </a>
                    </li>
                </ul>
                <form class="m-form" action="{{ route($config["route"] . '.doVerif', $data->id) }}" method="POST" id="form">
                    {{ csrf_field() }}
                    <div class="tab-content pt-1">
                        @component('admin.components.form.alert') @endcomponent
                        <div class="tab-pane active" id="tabData" role="tabpanel" aria-expanded="true" aria-labelledby="baseIcon-tab1">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @include("admin.pengelolaan.penghapusan.show.data")
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabBarang" aria-labelledby="baseIcon-tab2">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @component('admin.components.usulan.tablebarangfill', ['config' => $config, 'barangs' => $barangs]) @endcomponent
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabTingkatBanding" aria-labelledby="baseIcon-tab3">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @if($isRevisi)
                                        <div class="m-alert m-alert--icon m-alert--outline alert alert-warning alert-dismissible fade show" role="alert">
                                            <div class="m-alert__icon">
                                                <i class="la la-warning"></i>
                                            </div>
                                            <div class="m-alert__text"><strong>Keterangan Ditolak : </strong>{!! nl2br($data->keterangan_verifadm) !!}</div>
                                            <div class="m-alert__close">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="m-form-custom-5 row">
                                        <div class="col-lg-6">
                                            <div class="form-group m-form__group">
                                                <label for="inputLetterNumber"> No Surat Pengajuan Banding  <span class="required">*</span> </label>
                                                <input type="text" class="form-control m-input required" id="inputLetterNumber" value="{{ $isRevisi ? $data->letter_number_banding : null }}" name="letter_number_banding" placeholder="No Surat Pengajuan Banding" />
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputPenandatangananSurat"> Penandatanganan Surat  <span class="required">*</span> </label>
                                                <select id="inputPenandatangananSurat" name="penandatangan_surat_banding" class="form-control m-input select2 required">
                                                    <option value="">Pilih Penandatanganan Surat</option>
                                                    @foreach($penandatanganSurat as $penandatangan)
                                                        <option {!! $isRevisi ? ($data->penandatangan_surat_banding == $penandatangan->id ? 'selected="selected"' : null) : null !!} value="{{ $penandatangan->id }}">{{ $penandatangan->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label> Surat Pengantar dari Tingkat Banding {!! $isRevisi ? null : '<span class="required">*</span>' !!} </label>
                                                <div class="custom-file">
                                                    <input name="surat_penghantar_banding" type="file" accept="application/pdf" class="custom-file-input {!! $isRevisi ? null : 'required' !!}">
                                                    <label class="custom-file-label">
                                                        Pilih File
                                                    </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                                @if($isRevisi)
                                                    <p class="form-control-static"><a target="_blank" href="{{ \App\Model\Penjualan\Penjualan::docLocation($data->id, $data->surat_penghantar_banding, true) }}">Surat Pengajuan Satuan Kerja</a></p>
                                                    @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group m-form__group">
                                                <label for="inputLetterDate"> Tanggal Surat  <span class="required">*</span> </label>

                                                <div class="input-group date">
                                                    <input type="text" class="form-control m-input required m_datepicker required" id="inputLetterDate" readonly value="{{ $isRevisi ? \Carbon\Carbon::parse($data->letter_date_banding)->format('j F Y') : null }}" name="letter_date_banding" placeholder="Tanggal Surat" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label for="inputPerihalSurat"> Perihal Surat  <span class="required">*</span> </label>
                                                <textarea class="form-control m-input required" id="inputPerihalSurat" name="perihal_banding" placeholder="Perihal Surat" rows="5">{{ $isRevisi ? $data->perihal_banding : null }}</textarea>
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
                                        <button type="submit" name="submit" value="1" class="btn btn-success"> Terima Verifikasi </button>
                                        <button type="submit" name="submit" value="0" class="btn btn-tolak btn-danger"> Tolak Verifikasi </button>
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

    <div class="modal fade" id="modalTolak" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Tolak Verifikasi </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> &times; </span>
                    </button>
                </div>
                <form class="m-form m-form--label-align-right" action="{{ route($config["route"] . '.doVerif', $data->id) }}" method="POST" id="formModal">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        @include("admin.components.form.alert")
                        <div class="form-group m-form__group">
                            <label for="inputKeterangan"> Keterangan </label>
                            <textarea class="form-control m-input" id="inputKeterangan" name="keterangan_veriftk" placeholder="Keterangan" rows="5"></textarea>
                        </div>
                    </div>
                    <a href="{{ route($config['route'] . '.index') }}" class="ajaxify" id="reload" style="display: none;"></a>
                    <div class="modal-footer">
                        <button type="submit" value="0" name="submit" class="btn btn-success"> Simpan </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> Tutup </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#form .btn-tolak').click(function () {
                $('#modalTolak').modal('show');

                return false;
            });

            FormValidation.init({ 'form': '#form' });
            FormValidation.init({ 'form': '#formModal', 'modal': '#modalTolak' });

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
            $('.select2').select2();
        });
    </script>
    @endpush