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
                    @if(in_array($data->id_penghapusan_status, [\App\Model\Penghapusan\StatusPenghapusan::DITERIMA_TK, \App\Model\Penghapusan\StatusPenghapusan::DITERIMA_ADM, \App\Model\Penghapusan\StatusPenghapusan::DITOLAK_ADM, \App\Model\Penghapusan\StatusPenghapusan::PROSES, \App\Model\Penghapusan\StatusPenghapusan::SELESAI]))
                        <li class="nav-item">
                            <a class="nav-link" id="baseIcon-tab4" data-toggle="tab" aria-controls="tabTingkatBanding" href="#tabTingkatBanding" aria-expanded="false"><i class="la la-cc-discover"></i> Tingkat Banding </a>
                        </li>

                        @if($data->id_penghapusan_status == \App\Model\Penghapusan\StatusPenghapusan::PROSES && \Auth::user()->isPusat())
                            <li class="nav-item">
                                <a class="nav-link" id="baseIcon-tab11" data-toggle="tab" aria-controls="tabDraftSurat" href="#tabDraftSurat" aria-expanded="false"><i class="la la-folder-open"></i> Draft Surat </a>
                            </li>
                            @endif
                        @endif
                    @if(in_array($data->id_penghapusan_status, [\App\Model\Penghapusan\StatusPenghapusan::SELESAI]))
                        <li class="nav-item">
                            <a class="nav-link" id="baseIcon-tab5" data-toggle="tab" aria-controls="tabPersetujuanPenghapusan" href="#tabPersetujuanPenghapusan" aria-expanded="false"><i class="la la-arrows-alt "></i> Persetujuan Penghapusan </a>
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
                                    @include('admin.pengelolaan.penghapusan.show.data')
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabBarang" aria-labelledby="baseIcon-tab2">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @component('admin.components.usulan.tablebarangfill', ['barangs' => $barangs]) @endcomponent
                                </div>
                            </div>
                        </div>
                        @if(in_array($data->id_penghapusan_status, [\App\Model\Penghapusan\StatusPenghapusan::DITERIMA_TK, \App\Model\Penghapusan\StatusPenghapusan::DITERIMA_ADM, \App\Model\Penghapusan\StatusPenghapusan::DITOLAK_ADM, \App\Model\Penghapusan\StatusPenghapusan::PROSES, \App\Model\Penghapusan\StatusPenghapusan::SELESAI]))
                            <div class="tab-pane" id="tabTingkatBanding" aria-labelledby="baseIcon-tab4">
                                <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                    <div class="m-portlet__body">
                                        @include("admin.pengelolaan.penghapusan.show.tkbanding")
                                    </div>
                                </div>
                            </div>

                                @if($data->id_penghapusan_status == \App\Model\Penghapusan\StatusPenghapusan::PROSES && \Auth::user()->isPusat())
                                    <div class="tab-pane" id="tabDraftSurat" aria-labelledby="baseIcon-tab11">
                                        <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                            <div class="m-portlet__body">
                                                @include("admin.pengelolaan.penghapusan.show.draft")
                                            </div>
                                        </div>
                                    </div>
                                @endif
                        @endif
                        @if(in_array($data->id_penghapusan_status, [\App\Model\Penghapusan\StatusPenghapusan::SELESAI]))
                            <div class="tab-pane" id="tabPersetujuanPenghapusan" aria-labelledby="baseIcon-tab5">
                                <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                    <div class="m-portlet__body">
                                        @include("admin.pengelolaan.penghapusan.show.selesai")
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="tab-pane" id="tabLog" aria-labelledby="baseIcon-tab10">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @component('admin.pengelolaan.penghapusan.show.log', ['logs' => $logs]) @endcomponent
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