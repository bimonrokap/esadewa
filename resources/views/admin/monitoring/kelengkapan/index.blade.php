@extends('template.admin.content')

@section('content')

    <div class="row justify-content-md-center m--padding-bottom-15 m-row--col-separator-xl">
        <div class="bg-white col-md-12 col-lg-6 col-xl-2">
            <!--begin::Total Profit-->
            <div class="m-widget24">
                <div class="m-widget24__item">
                    <h4 class="m-widget24__title"> Tanah </h4> <br>
                    <span class="m-widget24__desc"> Lengkap / Total Asset </span>
                    <div class="m--space-5"></div> <br>
                    <span class="m-widget24__stats m--font-brand m--margin-bottom-15"> <span class="non"> {{ $tanah['total']-$tanah['belum'] }} </span> <span class="sparator">/</span> {{ $tanah['total'] }} </span>
                </div>
            </div>
            <!--end::Total Profit-->
        </div>
        <div class="bg-white col-md-12 col-lg-6 col-xl-2">
            <!--begin::Total Profit-->
            <div class="m-widget24">
                <div class="m-widget24__item">
                    <h4 class="m-widget24__title"> Gedung Kantor </h4> <br>
                    <span class="m-widget24__desc"> Lengkap / Total Asset </span>
                    <div class="m--space-5"></div> <br>
                    <span class="m-widget24__stats m--font-info m--margin-bottom-15"> <span class="non"> {{ $gedung_kantor['total']-$gedung_kantor['belum'] }} </span> <span class="sparator">/</span> {{ $gedung_kantor['total'] }} </span>
                </div>
            </div>
            <!--end::Total Profit-->
        </div>
        <div class="bg-white col-md-12 col-lg-6 col-xl-2">
            <!--begin::Total Profit-->
            <div class="m-widget24">
                <div class="m-widget24__item">
                    <h4 class="m-widget24__title"> Rumah Negara </h4> <br>
                    <span class="m-widget24__desc"> Lengkap / Total Asset </span>
                    <div class="m--space-5"></div> <br>
                    <span class="m-widget24__stats m--font-success m--margin-bottom-15"> <span class="non"> {{ $rumah_negara['total']-$rumah_negara['belum'] }} </span> <span class="sparator">/</span> {{ $rumah_negara['total'] }} </span>
                </div>
            </div>
            <!--end::Total Profit-->
        </div>
        <div class="bg-white col-md-12 col-lg-6 col-xl-2">
            <!--begin::Total Profit-->
            <div class="m-widget24">
                <div class="m-widget24__item">
                    <h4 class="m-widget24__title"> Kendaraan </h4> <br>
                    <span class="m-widget24__desc"> Lengkap / Total Asset </span>
                    <div class="m--space-5"></div> <br>
                    <span class="m-widget24__stats m--font-danger m--margin-bottom-15"> <span class="non"> {{ $kendaraan_bermotor['total']-$kendaraan_bermotor['belum'] }} </span> <span class="sparator">/</span> {{ $kendaraan_bermotor['total'] }} </span>
                </div>
            </div>
            <!--end::Total Profit-->
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <!--begin::Portlet-->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide"> <i class="la la-gear"></i> </span>
                            <h3 class="m-portlet__head-text"> Rekapitulasi Kelengkapan Profil Asset Per Kategori </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="{{ route('admin.export', ['type' => 'kelengkapan', 'value' => 'asset']) }}" class="m-portlet__nav-link btn btn-info m-btn m-btn--icon">
                                    <i class="la la-download"></i> Export Excel
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body block-chart">
                    <div class="table-responsive">
                        <table class="table m-table m-table--head-bg-metal table-hover">
                            <thead>
                                <tr>
                                    <th rowspan="2" width="50px" class="text-center align-middle"> No  </th>
                                    <th rowspan="2" class="text-center align-middle"> Kategori Asset </th>
                                    <th colspan="3" class="text-center m--bg-brand">Kelengkapan Data Asset</th>
                                    <th rowspan="2" width="80px" class="bg-info text-center align-middle"> Total </th>
                                </tr>
                                <tr>
                                    <th width="130px" class="bg-danger text-center"> Belum Lengkap </th>
                                    <th width="130px" class="bg-warning text-center"> Kurang Lengkap </th>
                                    <th width="80px" class="bg-success text-center"> Lengkap </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; $totLow=0;$totMid=0;$totHigh=0;$tot=0;?>
                                @foreach($categories as $k => $category)
                                    <tr {!! $i == 1 ? 'class="top-border-double"' : '' !!}>
                                        <td scope="row" class="text-center"> {{ $i }} </td>
                                        <td> <a style="color: black" href="{{ route($config['route'].'.asset.detail', $category['data']) }}" class="ajaxify">{{ $k }}</a> </td>
                                        <td class="text-right bg-danger-soft"> {{ numberFormatIndo($category['low']) }} </td>
                                        <td class="text-right bg-warning-soft"> {{ numberFormatIndo($category['mid']) }} </td>
                                        <td class="text-right bg-success-soft"> {{ numberFormatIndo($category['high']) }} </td>
                                        <td class="text-right bg-info-soft"> {{ numberFormatIndo($category['total']) }} </td>
                                    </tr>
                                    <?php $i++;$totLow += $category['low'];$totMid += $category['mid'];$totHigh += $category['high'];$tot += $category['total']; ?>
                                @endforeach
                                <tr class="top-border-double">
                                    <td colspan="2" class="text-center font-weight-bold m--bg-metal"> Total </td>
                                    <td class="text-right bg-danger font-weight-bold"> {{ numberFormatIndo($totLow) }} </td>
                                    <td class="text-right bg-warning font-weight-bold"> {{ numberFormatIndo($totMid) }} </td>
                                    <td class="text-right bg-success font-weight-bold"> {{ numberFormatIndo($totHigh) }} </td>
                                    <td class="text-right bg-info font-weight-bold"> {{ numberFormatIndo($tot) }} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end::Portlet-->

            <!--begin::Portlet-->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide"> <i class="la la-gear"></i> </span>
                            <h3 class="m-portlet__head-text"> Rekapitulasi Kelengkapan Profil Asset Per Satker </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="{{ route('admin.monitoring.kelengkapan.export') }}" class="m-portlet__nav-link btn btn-info m-btn m-btn--icon" id="btn-export">
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
                <div class="m-portlet__body" id="con-asset-table"></div>
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
                <form class="m-form m-form--label-align-right" action="{{ route($config['route'].'.table') }}" method="POST" id="form-import">
                    <div class="modal-body" style="padding: 0 25px 10px;">
                        <ul class="nav nav-tabs m-tabs-line m-tabs-line--success" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_6_1" role="tab"> Group & Order </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_3" role="tab"> Filter </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="m_tabs_6_1" role="tabpanel">
                                <div class="m-form__section m-form__section--first">
                                    <div class="form-group m-form__group row">
                                        <label class="col-md-3 col-form-label"> Tampilan Per </label>
                                        <div class="col-md-3">
                                            <select name="display" class="form-control">
                                                @if($viewAllAsset)
                                                <option {!! $request['display'] == 'wilayah' ? 'selected="selected"' : '' !!} value="wilayah">Wilayah</option>
                                                <option {!! $request['display'] == 'satker' || $request['display'] == '' ? 'selected="selected"' : '' !!} value="satker" >Satker</option>
                                                <option {!! $request['display'] == 'lingkungan' ? 'selected="selected"' : '' !!} value="lingkungan">Lingkungan</option>
                                                @elseif($viewAllLingkunganAsset && $viewAllWilayahAsset)
                                                    <option {!! $request['display'] == 'satker' || $request['display'] == '' ? 'selected="selected"' : '' !!} value="satker" >Satker</option>
                                                @elseif($viewAllLingkunganAsset)
                                                    <option {!! $request['display'] == 'wilayah' ? 'selected="selected"' : '' !!} value="wilayah">Wilayah</option>
                                                    <option {!! $request['display'] == 'satker' || $request['display'] == '' ? 'selected="selected"' : '' !!} value="satker" >Satker</option>
                                                @elseif($viewAllWilayahAsset)
                                                    <option {!! $request['display'] == 'satker' || $request['display'] == '' ? 'selected="selected"' : '' !!} value="satker" >Satker</option>
                                                    <option {!! $request['display'] == 'lingkungan' ? 'selected="selected"' : '' !!} value="lingkungan">Lingkungan</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="m_tabs_6_3" role="tabpanel">
                                <div class="m-form__section m-form__section--first">
                                    @if($viewAllAsset)
                                        <div class="form-group m-form__group row">
                                            <label class="col-md-3 col-form-label"> Wilayah </label>
                                            <div class="col-md-4">
                                                <select name="filter[wilayah]" class="form-control select2" style="width: 100%;">
                                                    <option value="">Pilih</option>
                                                    @foreach($wilayahs as $wilayah)
                                                        <option {!! isset($request['filter']['wilayah']) && $request['filter']['wilayah'] == $wilayah->id ? 'selected="selected"' : '' !!} value="{{ $wilayah->id }}">{{ $wilayah->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-md-3 col-form-label"> Lingkungan </label>
                                            <div class="col-md-4">
                                                <select name="filter[lingkungan]" class="form-control select2" style="width: 100%;">
                                                    <option value="">Pilih</option>
                                                    @foreach($lingkungans as $k => $lingkungan)
                                                        <option {!! isset($request['filter']['lingkungan']) && $request['filter']['lingkungan'] == $k ? 'selected="selected"' : '' !!} value="{{ $k }}">{{ $lingkungan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @elseif($viewAllLingkunganAsset && $viewAllWilayahAsset)

                                    @elseif($viewAllLingkunganAsset)
                                        <div class="form-group m-form__group row">
                                            <label class="col-md-3 col-form-label"> Wilayah </label>
                                            <div class="col-md-4">
                                                <select name="filter[wilayah]" class="form-control select2" style="width: 100%;">
                                                    <option value="">Pilih</option>
                                                    @foreach($wilayahs as $wilayah)
                                                        <option {!! isset($request['filter']['wilayah']) && $request['filter']['wilayah'] == $wilayah->id ? 'selected="selected"' : '' !!} value="{{ $wilayah->id }}">{{ $wilayah->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @elseif($viewAllWilayahAsset)
                                        <div class="form-group m-form__group row">
                                            <label class="col-md-3 col-form-label"> Lingkungan </label>
                                            <div class="col-md-4">
                                                <select name="filter[lingkungan]" class="form-control select2" style="width: 100%;">
                                                    <option value="">Pilih</option>
                                                    @foreach($lingkungans as $k => $lingkungan)
                                                        <option {!! isset($request['filter']['lingkungan']) && $request['filter']['lingkungan'] == $k ? 'selected="selected"' : '' !!} value="{{ $k }}">{{ $lingkungan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group m-form__group row">
                                        <label class="col-md-3 col-form-label"> Asset </label>
                                        <div class="col-md-4">
                                            <select name="filter[asset]" class="form-control select2" style="width: 100%;">
                                                <option value="">Pilih</option>
                                                @foreach($assets as $asset)
                                                    <option {!! isset($request['filter']['asset']) && $request['filter']['asset'] == $asset->data ? 'selected="selected"' : '' !!} value="{{ $asset->data }}">{{ $asset->name }}</option>
                                                @endforeach
                                            </select>
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
            mApp.block('#con-asset-table');
            $.get('{{ route($config['route'] . '.table') }}', function (html) {
               $('#con-asset-table').html(html);
                mApp.unblock('#con-asset-table');
            });

            $('#btn-export').click(function () {
                var url = $(this).attr('href') + "?" + $('#modalFilter form').serialize();
                window.location = url;
                return false;
            });

            $('#modalFilter form').submit(function () {
                mApp.block('#modalFilter');
                $.get('{{ route($config['route'].'.table') }}', $(this).serializeArray(), function (html) {
                    $('#con-asset-table').html(html);
                    mApp.unblock('#modalFilter');
                    $('#modalFilter').modal('hide');
                }).fail(function() {
                    mApp.unblock('#modalFilter');
                });

                return false;
            });
        });
    </script>
@endpush