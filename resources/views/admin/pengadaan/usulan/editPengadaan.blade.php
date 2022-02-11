@extends('template.admin.content')

@section('content')
    <div class="row">
        <div class="col-xl-12">

            <div id="con-head">
                <ul class="nav nav-pills nav-custom">
                    <li class="nav-item">
                        <a class="nav-link active" id="baseIcon-tab1" data-toggle="tab" aria-controls="tabData" href="#tabData" aria-expanded="true"><i class="la la-file"></i> Data </a>
                    </li>
                    @for($i = 1; $i <= ($data->tanah->tanah_type == 2 ? 1 : 3); $i++)
                        <li class="nav-item">
                            <a class="nav-link" id="baseIcon-tab{{ 5+$i }}" data-toggle="tab" aria-controls="tabPenawaran{{ $i }}" href="#tabPenawaran{{ $i }}" aria-expanded="false"><i class="la la-square-o "></i> Penawaran
                                {{ $i }} </a>
                        </li>
                    @endfor
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
                                                <label for="inputJenisPengadaan"> Jenis Pengadaan  <span class="required">*</span> </label>
                                                <select id="inputJenisPengadaan" name="jenis_pengadaan" class="form-control m-input select2 required">
                                                    <option value="">Pilih Jenis Pengadaan</option>
                                                    @foreach($jenisPengadaan as $jenis)
                                                        <option {!! $data->tanah->jenis_pengadaan == $jenis->id ? 'selected="selected"' : '' !!} value="{{ $jenis->id }}">Tanah {{ $jenis->name }}</option>
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
                                                <label> TOR ditandatangani KPA </label>
                                                <div class="custom-file">
                                                    <input name="tor" type="file" accept="application/pdf" class="custom-file-input">
                                                    <label class="custom-file-label"> Pilih File </label>
                                                </div>
                                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                                <p class="form-control-static"><a target="_blank" href="{{ \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($data->id, $data->tanah->tor, true) }}">TOR ditandatangani KPA</a></p>
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
                                                <label for="inputPerihalSurat"> Perihal Surat  <span class="required">*</span> </label>
                                                <textarea class="form-control m-input required" id="inputPerihalSurat" name="perihal" placeholder="Perihal Surat" rows="5">{!! $data->perihal !!}</textarea>
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
                                    @component('admin.components.usulan.penawaranFill', ['config' => $config, 'uuid' => $uuid.'-'.$i, 'id' => $data->id, 'data' => $data->tanah->penawaran[$i-1], 'class' => $i, 'param' => ['type' => 'pengadaan']]) @endcomponent

                                </div>
                            </div>
                        </div>
                        @endfor
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