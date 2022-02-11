@extends('template.admin.content')

@section('content')

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <!--begin::Portlet-->
            <div class="m-portlet m--margin-bottom-15">
                <div class="m-portlet__body block-chart">
                    @if(!$isSatker)
                    <a href="{{ route('admin.monitoring.kelengkapan.index') }}" class="btn m-btn m-btn--icon m-btn--icon-only ajaxify">
                        <i class="la la-arrow-left"></i>
                    </a>
                    @endif
                    <strong>{{ $satker->name . ' ('.$satker->kode.')' }}</strong>
                    Update data per <strong>{{ is_null($satker->tanggal_update) ? ' - ' : \Carbon\Carbon::parse($satker->tanggal_update)->format('j F Y') }}</strong>
                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>

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
                                <a href="{{ route('admin.export', ['type' => 'kelengkapan', 'value' => 'asset', 'satker' => $satker->kode]) }}" class="m-portlet__nav-link btn btn-info m-btn m-btn--icon">
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
                                        <td> <a style="color: black" href="{{ route($config['route'] . '.asset', ['satker' => $satker->kode, 'asset' => $category['data'], 'from' => 'satker']) }}" class="ajaxify">{{ $k }}</a> </td>
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
        </div>
    </div>
@endsection