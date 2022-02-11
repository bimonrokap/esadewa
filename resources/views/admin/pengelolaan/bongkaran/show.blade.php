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
                    @if(in_array($data->id_bongkaran_status, [\App\Model\Bongkaran\StatusBongkaran::DITERIMA_TK, \App\Model\Bongkaran\StatusBongkaran::DITERIMA_ADM, \App\Model\Bongkaran\StatusBongkaran::DITOLAK_ADM, \App\Model\Bongkaran\StatusBongkaran::PROSES, \App\Model\Bongkaran\StatusBongkaran::SELESAI]))
                        <li class="nav-item">
                            <a class="nav-link" id="baseIcon-tab4" data-toggle="tab" aria-controls="tabTingkatBanding" href="#tabTingkatBanding" aria-expanded="false"><i class="la la-cc-discover"></i> Tingkat Banding </a>
                        </li>
                        @if($data->id_bongkaran_status == \App\Model\Bongkaran\StatusBongkaran::PROSES && \Auth::user()->isPusat())
                            <li class="nav-item">
                                <a class="nav-link" id="baseIcon-tab11" data-toggle="tab" aria-controls="tabDraftSurat" href="#tabDraftSurat" aria-expanded="false"><i class="la la-folder-open"></i> Draft Surat </a>
                            </li>
                            @endif
                        @endif
                    @if(in_array($data->id_bongkaran_status, [\App\Model\Bongkaran\StatusBongkaran::MENUNGGU, \App\Model\Bongkaran\StatusBongkaran::SELESAI]))
                        <li class="nav-item">
                            <a class="nav-link" id="baseIcon-tab5" data-toggle="tab" aria-controls="tabPersetujuanBongkaran" href="#tabPersetujuanBongkaran" aria-expanded="false"><i class="la la-arrows-alt "></i> Persetujuan Bongkaran </a>
                        </li>
                        @endif
                    @if(in_array($data->id_bongkaran_status, [\App\Model\Bongkaran\StatusBongkaran::SELESAI]))
                        <li class="nav-item">
                            <a class="nav-link" id="baseIcon-tab4" data-toggle="tab" aria-controls="tabTindakLanjut" href="#tabTindakLanjut" aria-expanded="false"><i class="la la-archive "></i> Tindak Lanjut </a>
                        </li>
                        @endif
                    <li class="nav-item">
                        <a class="nav-link" id="baseIcon-tab10" data-toggle="tab" aria-controls="tabLog" href="#tabLog" aria-expanded="false"><i class="la la-lock"></i> Log </a>
                    </li>
                </ul>
                <form class="m-form" action="#" method="POST" id="form">
                    <div class="tab-content pt-1">
                        @component('admin.components.form.alert') @endcomponent
                        <div class="tab-pane active" id="tabData" role="tabpanel" aria-expanded="true" aria-labelledby="baseIcon-tab1">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @include('admin.pengelolaan.bongkaran.show.data')
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
                        @if(in_array($data->id_bongkaran_status, [\App\Model\Bongkaran\StatusBongkaran::DITERIMA_TK, \App\Model\Bongkaran\StatusBongkaran::DITERIMA_ADM, \App\Model\Bongkaran\StatusBongkaran::DITOLAK_ADM, \App\Model\Bongkaran\StatusBongkaran::PROSES, \App\Model\Bongkaran\StatusBongkaran::SELESAI]))
                            <div class="tab-pane" id="tabTingkatBanding" aria-labelledby="baseIcon-tab4">
                                <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                    <div class="m-portlet__body">
                                        @include("admin.pengelolaan.bongkaran.show.tkbanding")
                                    </div>
                                </div>
                            </div>

                            @if($data->id_bongkaran_status == \App\Model\Bongkaran\StatusBongkaran::PROSES && \Auth::user()->isPusat())
                                <div class="tab-pane" id="tabDraftSurat" aria-labelledby="baseIcon-tab11">
                                    <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                        <div class="m-portlet__body">
                                            @include("admin.pengelolaan.bongkaran.show.draft")
                                        </div>
                                    </div>
                                </div>
                                @endif
                        @endif
                        @if(in_array($data->id_bongkaran_status, [\App\Model\Bongkaran\StatusBongkaran::MENUNGGU, \App\Model\Bongkaran\StatusBongkaran::SELESAI]))
                            <div class="tab-pane" id="tabPersetujuanBongkaran" aria-labelledby="baseIcon-tab5">
                                <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                    <div class="m-portlet__body">
                                        @include("admin.pengelolaan.bongkaran.show.persetujuan")
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(in_array($data->id_bongkaran_status, [\App\Model\Bongkaran\StatusBongkaran::SELESAI]))
                            <div class="tab-pane" id="tabTindakLanjut" aria-labelledby="baseIcon-tab5">
                                <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                    <div class="m-portlet__body">
                                        @include("admin.pengelolaan.bongkaran.show.tindaklanjut")
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="tab-pane" id="tabLog" aria-labelledby="baseIcon-tab10">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @component('admin.pengelolaan.bongkaran.show.log', ['logs' => $logs]) @endcomponent
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet m-portlet--mobile m-portlet--footer-only">
                        <a href="{{ route($config['route'] . '.index') }}" id="reload" style="display: none;"></a>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <div class="row">
                                    <div class="col-lg-12 text-right">
                                        <a href="{{ route($config['route'] . '.index') }}" class="ajaxify"> <button type="button" class="btn btn-secondary"> Kembali </button></a>
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

        });
    </script>
    @endpush