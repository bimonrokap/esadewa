@extends('template.admin.content')

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <!--begin::Portlet-->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide"> <i class="la la-gear"></i> </span>
                            <h3 class="m-portlet__head-text">
                                <a href="{{ $from == 'satker' ? route('admin.monitoring.kelengkapan.satker', $satker->kode) : route('admin.monitoring.kelengkapan.asset.detail', $asset->data) }}" class="btn m-btn m-btn--icon m-btn--icon-only ajaxify">
                                    <i class="la la-arrow-left"></i>
                                </a>
                                List Asset {{ $asset->name }} untuk Satker {{ $satker->name }}
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="{{ route($config['route'] . '.asset.export', ['asset' => $asset->data, 'satker' => $satker->kode]) }}" class="m-portlet__nav-link btn btn-info m-btn m-btn--icon" id="btn-export">
                                    <i class="la la-download"></i> Export Excel
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <button type="button" class="m-portlet__nav-link btn btn-success m-btn m-btn--icon" data-toggle="modal" data-target="#modalFilter">
                                    <i class="la la-filter"></i> Filter & Group
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body block-chart">
                    <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                        <div class="row align-items-center">
                            <div class="col-xl-8 order-2 order-xl-1">
                                <div class="form-group m-form__group row align-items-center">
                                    <div class="col-md-4">
                                        <div class="m-input-icon m-input-icon--left">
                                            <input type="text" class="form-control m-input" placeholder="Search..." id="generalSearch">
                                            <span class="m-input-icon__icon m-input-icon__icon--left">
                                                <span>
                                                    <i class="la la-search"></i>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive" style="min-height: 100px"></div>
                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>

    <div class="modal fade" id="modalFilter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Filter & Group  </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> &times; </span>
                    </button>
                </div>
                <form class="m-form m-form--label-align-right" action="{{ route($config['route'].'.asset.table', ['asset' => $asset->data, 'satker' => $satker->kode]) }}" method="POST" id="form-import">
                    <div class="modal-body">
                        <div class="m-form__section m-form__section--first">
                            <div class="form-group m-form__group row">
                                <label class="col-md-3 col-form-label"> Nilai Perolehan </label>
                                <div class="col-md-3">
                                    <div class="input-group m-input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> Rp </span>
                                        </div>
                                        <input type="text" value="{{ isset($request['filter']['perolehan'][0]) ? $request['filter']['perolehan'][0] : '' }}" class="form-control text-right" name="filter[perolehan][0]" placeholder="0">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="input-group m-input-group font-weight-bold" style="margin-top: 5px;"> s/d </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group m-input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> Rp </span>
                                        </div>
                                        <input type="text" value="{{ isset($request['filter']['perolehan'][1]) ? $request['filter']['perolehan'][1] : '' }}" class="form-control text-right" name="filter[perolehan][1]" placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-md-3 col-form-label"> Luas Tanah </label>
                                <div class="col-md-3">
                                    <div class="input-group m-input-group">
                                        <input type="text" value="{{ isset($request['filter']['luastanah'][0]) ? $request['filter']['luastanah'][0] : '' }}" class="form-control text-right" name="filter[luastanah][0]" placeholder="0">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> m<sup>2</sup> </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="input-group m-input-group font-weight-bold" style="margin-top: 5px;"> s/d </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group m-input-group">
                                        <input type="text" value="{{ isset($request['filter']['luastanah'][1]) ? $request['filter']['luastanah'][1] : '' }}" class="form-control text-right" name="filter[luastanah][1]" placeholder="0">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> m<sup>2</sup> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> Tutup </button>
                        <button type="submit" class="btn btn-primary"> Simpan Filter  </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            mApp.block('.table-responsive');
            $.get('{{ route($config['route'].'.asset.table', ['asset' => $asset->data, 'satker' => $satker->kode]) }}', $('#modalFilter form').serializeArray(), function (html) {
                $('.table-responsive').html(html);

                mApp.unblock('.table-responsive');
            });

            $('#modalFilter form').submit(function () {
                mApp.block('#modalFilter');
                $.get('{{ route($config['route'].'.asset.table', ['asset' => $asset->data, 'satker' => $satker->kode]) }}', $(this).serializeArray(), function (html) {
                    $('.table-responsive').html(html);

                    mApp.unblock('#modalFilter');
                    $('#modalFilter').modal('hide');
                }).fail(function() {
                    mApp.unblock('#modalFilter');
                });

                return false;
            });

            $('#btn-export').click(function () {
                var url = $(this).attr('href') + "?" + $('#modalFilter form').serialize();
                window.location = url;
                return false;
            });
        })
    </script>
@endpush