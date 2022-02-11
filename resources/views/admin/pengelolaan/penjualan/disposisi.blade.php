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
                    <li class="nav-item">
                        <a class="nav-link" id="baseIcon-tab4" data-toggle="tab" aria-controls="tabTingkatBanding" href="#tabTingkatBanding" aria-expanded="false"><i class="la la-cc-discover"></i> Tingkat Banding </a>
                    </li>
                </ul>
                <form class="m-form" action="#" method="POST" id="form">
                    {{ csrf_field() }}
                    <div class="tab-content pt-1">
                        @component('admin.components.form.alert') @endcomponent
                        <div class="tab-pane active" id="tabData" role="tabpanel" aria-expanded="true" aria-labelledby="baseIcon-tab1">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @include("admin.pengelolaan.penjualan.show.data")
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
                        <div class="tab-pane" id="tabFoto" aria-labelledby="baseIcon-tab3">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @component('admin.components.usulan.fotoShow', ['fotos' => $data->foto, 'data' => $data]) @endcomponent
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabTingkatBanding" aria-labelledby="baseIcon-tab3">
                            <div class="m-portlet m-portlet--mobile" style="margin-bottom: 0;">
                                <div class="m-portlet__body">
                                    @include("admin.pengelolaan.penjualan.show.tkbanding")
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
                                        @if($isDispo)
                                            <button type="submit" name="submit" value="1" class="btn btn-success"> Disposisi </button>
                                            @else
                                            <button type="submit" name="submit" value="1" class="btn btn-success"> Terima Verifikasi </button>
                                            <button type="submit" name="submit" value="0" class="btn btn-tolak btn-danger"> Tolak Verifikasi </button>
                                            @endif
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
                <form class="m-form m-form--label-align-right" action="{{ route($config["route"] . '.doDisposisi', $data->id) }}" method="POST" id="formModal">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        @include("admin.components.form.alert")
                        <div class="form-group m-form__group">
                            <label for="inputKeterangan"> Keterangan </label>
                            <textarea class="form-control m-input" id="inputKeterangan" name="keterangan" placeholder="Keterangan" rows="5"></textarea>
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