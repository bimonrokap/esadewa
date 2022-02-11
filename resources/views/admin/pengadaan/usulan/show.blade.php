@extends('template.admin.content')

@section('content')
    <div class="row">
        <div class="col-xl-12">

            <div id="con-head">
                <ul class="nav nav-pills nav-custom">
                    @include("admin.pengadaan.usulan.show.navitem", ['type' => $type])
                    @if(in_array($data->id_pengadaan_status, [\App\Model\Pengadaan\Usulan\StatusPengadaan::DITERIMA_TK, \App\Model\Pengadaan\Usulan\StatusPengadaan::DITERIMA_ADM, \App\Model\Pengadaan\Usulan\StatusPengadaan::DITOLAK_ADM, \App\Model\Pengadaan\Usulan\StatusPengadaan::PROSES, \App\Model\Pengadaan\Usulan\StatusPengadaan::SELESAI]))
                        <li class="nav-item">
                            <a class="nav-link" id="baseIcon-tab4" data-toggle="tab" aria-controls="tabTingkatBanding" href="#tabTingkatBanding" aria-expanded="false"><i class="la la-cc-discover"></i> Tingkat Banding </a>
                        </li>
                    @endif
                    @if(in_array($data->id_pengadaan_status, [\App\Model\Pengadaan\Usulan\StatusPengadaan::SELESAI]))
                        <li class="nav-item">
                            <a class="nav-link" id="baseIcon-tab5" data-toggle="tab" aria-controls="tabPersetujuanPengadaan" href="#tabPersetujuanPengadaan" aria-expanded="false"><i class="la la-arrows-alt "></i> Hasil Kajian Pengadaan Barang </a>
                        </li>
                        @endif
                    <li class="nav-item">
                        <a class="nav-link" id="baseIcon-tab10" data-toggle="tab" aria-controls="tabLog" href="#tabLog" aria-expanded="false"><i class="la la-lock"></i> Log </a>
                    </li>
                </ul>
                <form class="m-form" action="#" method="POST" id="form">
                    <div class="tab-content pt-1">
                        @component('admin.components.form.alert') @endcomponent
                        @include("admin.pengadaan.usulan.show.tabcontent", ['type' => $type])
                        @if(in_array($data->id_pengadaan_status, [\App\Model\Pengadaan\Usulan\StatusPengadaan::DITERIMA_TK, \App\Model\Pengadaan\Usulan\StatusPengadaan::DITERIMA_ADM, \App\Model\Pengadaan\Usulan\StatusPengadaan::DITOLAK_ADM, \App\Model\Pengadaan\Usulan\StatusPengadaan::PROSES, \App\Model\Pengadaan\Usulan\StatusPengadaan::SELESAI]))
                            <div class="tab-pane" id="tabTingkatBanding" aria-labelledby="baseIcon-tab4">
                                <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                    <div class="m-portlet__body">
                                        @include("admin.pengadaan.usulan.show.tkbanding")
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(in_array($data->id_pengadaan_status, [\App\Model\Pengadaan\Usulan\StatusPengadaan::SELESAI]))
                            <div class="tab-pane" id="tabPersetujuanPengadaan" aria-labelledby="baseIcon-tab5">
                                <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                    <div class="m-portlet__body">
                                        @include("admin.pengadaan.usulan.show.selesai")
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="tab-pane" id="tabLog" aria-labelledby="baseIcon-tab10">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @component('admin.pengadaan.usulan.show.log', ['logs' => $logs]) @endcomponent
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