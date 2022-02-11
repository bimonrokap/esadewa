@extends('template.admin.content')

@section('content')

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="m-portlet m--margin-bottom-15">
                <div class="m-portlet__body" style="padding: 10px;">
                    <div class="row">
                        <div class="col-md-{{ $filterOn ? '11' : '12' }}">
                            <h3 class="text-center font-weight-bold" style="margin: 0;" id="titleDashboard"> {{ $title }} </h3>
                        </div>
                        @if($filterOn)
                        <div class="col-md-1 text-right">
                            <button type="button" class="m-portlet__nav-link btn btn-success btn-sm m-btn m-btn--icon" data-toggle="modal" data-target="#modalFilter">
                                <i class="la la-filter"></i> Filter
                            </button>
                        </div>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-md-center m--padding-bottom-15 m-row--col-separator-xl m-widget__custom" style="margin: 0">
        <div class="bg-white col-sm-6 col-md-6 col-lg-3 col-xl-3 no-padding brand">
            <div data-category="tanah" class="m-widget24">
                <div class="m-widget__item">
                    <h4 class="m-widget__title"> Tanah </h4>
                    <div class="list">
                        <div class="item-1">
                            <span data-type="kantor" class="data detail">Tanah Kantor Pemerintah</span>
                            <span class="value number"> {{ numberFormatIndo($tanah['kantor']) }} </span>
                        </div>
                        <div class="item-2">
                            <span data-type="rumah_negara" class="data detail">Tanah Rumah Negara</span>
                            <span class="value number"> {{ numberFormatIndo($tanah['rumah']) }} </span>
                        </div>
                        <div class="item-3">
                            <span data-type="lainnya" class="data detail">Tanah Lainnya</span>
                            <span class="value number">{{ numberFormatIndo($tanah['total'] - $tanah['kantor'] - $tanah['rumah']) }}</span>
                        </div>
                    </div>
                    <div class="total">
                        <span data-type="total" class="data detail">Total</span>
                        <span class="value number">{{ numberFormatIndo($tanah['total']) }}</span>
                    </div>
                    <a href="{{ route('admin.dashboard.asset', 'tanah') }}" class="ajaxify"> Detail </a>
                </div>
            </div>
        </div>
        <div class="bg-white col-sm-6 col-md-6 col-lg-3 col-xl-3 no-padding info">
            <div data-category="gedung" class="m-widget24">
                <div class="m-widget__item">
                    <h4 class="m-widget__title"> Gedung & Bangunan </h4>
                    <div class="list">
                        <div class="item-1">
                            <span data-type="kantor" class="data detail">Bangunan Gedung Kantor</span>
                            <span class="value number"> {{ numberFormatIndo($gedung['kantor']) }} </span>
                        </div>
                        <div class="item-2">
                            <span data-type="zitting" class="data detail">Bangunan Zitting Plaat</span>
                            <span class="value number"> {{ numberFormatIndo($gedung['zitting']) }} </span>
                        </div>
                        <div class="item-3">
                            <span data-type="lainnya" class="data detail">Bangunan Lainnya</span>
                            <span class="value number"> {{ numberFormatIndo($gedung['total'] - $gedung['zitting'] - $gedung['kantor']) }} </span>
                        </div>
                    </div>
                    <div class="total">
                        <span data-type="total" class="data detail">Total</span>
                        <span class="value number">{{ numberFormatIndo($gedung['total']) }}</span>
                    </div>
                    <a href="{{ route('admin.dashboard.asset', 'gedung') }}" class="ajaxify"> Detail </a>
                </div>
            </div>
        </div>
        <div class="bg-white col-sm-6 col-md-6 col-lg-3 col-xl-3 no-padding success">
            <div data-category="rumah" class="m-widget24">
                <div class="m-widget__item">
                    <h4 class="m-widget__title"> Rumah Negara </h4>
                    <div class="list">
                        <div class="item-1">
                            <span data-type="gol_1" class="data detail">Golongan I</span>
                            <span class="value number"> {{ numberFormatIndo($rumah['gol_1']) }} </span>
                        </div>
                        <div class="item-2">
                            <span data-type="gol_2" class="data detail">Golongan II</span>
                            <span class="value number"> {{ numberFormatIndo($rumah['gol_2']) }} </span>
                        </div>
                        <div class="item-3">
                            <span data-type="lainnya" class="data detail">Mess & Lainnya</span>
                            <span class="value number"> {{ numberFormatIndo($rumah['total'] - $rumah['gol_1'] - $rumah['gol_2']) }} </span>
                        </div>
                    </div>
                    <div class="total">
                        <span data-type="total" class="data detail">Total</span>
                        <span class="value number">{{ numberFormatIndo($rumah['total']) }}</span>
                    </div>
                    <a href="{{ route('admin.dashboard.asset', 'rumahnegara') }}" class="ajaxify"> Detail </a>
                </div>
            </div>
        </div>
        <div class="bg-white col-sm-6 col-md-6 col-lg-3 col-xl-3 no-padding danger">
            <div data-category="kendaraan" class="m-widget24">
                <div class="m-widget__item">
                    <h4 class="m-widget__title"> Kendaraan </h4>
                    <div class="list">
                        <div class="item-1">
                            <span data-type="roda2" class="data detail">Roda 2</span>
                            <span class="value number"> {{ numberFormatIndo($kendaraan['roda_2']) }} </span>
                        </div>
                        <div class="item-2">
                            <span data-type="roda4" class="data detail">Roda 4</span>
                            <span class="value number"> {{ numberFormatIndo($kendaraan['roda_4']) }} </span>
                        </div>
                        <div class="item-3">
                            <span data-type="lainnya" class="data detail">Lainnya</span>
                            <span class="value number"> {{ numberFormatIndo($kendaraan['total'] - $kendaraan['roda_2'] - $kendaraan['roda_4']) }} </span>
                        </div>
                    </div>
                    <div class="total">
                        <span data-type="total" class="data detail">Total</span>
                        <span class="value number">{{ numberFormatIndo($kendaraan['total']) }}</span>
                    </div>
                    <a href="{{ route('admin.dashboard.asset', 'kendaraan') }}" class="ajaxify"> Detail </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-lg-3">
            <!--begin::Portlet-->
            <div class="m-portlet m-portlet--tab tanah">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                Tanah <span class="sub-title"></span>
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <div class="btn-toolbar justify-content-between  pull-right" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">
                                <button type="button" class="m-btn btn btn-sm btn-primary" onclick="batangtanah()">
                                    <i class="la la-bar-chart-o"></i>
                                </button>
                                <button type="button" class="m-btn btn btn-sm btn-success" onclick="pietanah()">
                                    <i class="la la-pie-chart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body block-chart">
                    <select class="form-control m-bootstrap-select m_selectpicker select" data-category="tanah" name="select-tanah" title="Sertifikat" data-style="btn-brand">
                        <option selected value="sertifikat"> Sertifikat </option>
                        <option value="kondisi"> Kondisi </option>
                        <option value="luasan"> Luasan </option>
                    </select>

                    <div id="chart-tanah" style="height: 300px;"></div>
                    <div id="pie-chart-tanah" style="height: 300px; display: none"></div>
                </div>
            </div>
            <!--end::Portlet-->
        </div>
        <div class="col-md-3 col-lg-3">
            <!--begin::Portlet-->
            <div class="m-portlet m-portlet--tab gedung">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                Gedung & Bangunan <span class="sub-title"></span>
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <div class="btn-toolbar justify-content-between  pull-right" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">
                                <button type="button" class="m-btn btn btn-sm btn-primary" onclick="batanggedung()">
                                    <i class="la la-bar-chart-o"></i>
                                </button>
                                <button type="button" class="m-btn btn btn-sm btn-success" onclick="piegedung()">
                                    <i class="la la-pie-chart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body block-chart">
                    <select class="form-control m-bootstrap-select m_selectpicker select" data-category="gedung" name="select-gedung" title="Prototype" data-style="btn-info">
                        <option selected value="luasan"> Luasan </option>
                        <option value="kondisi"> Kondisi </option>
                    </select>

                    <div id="chart-gedung-kantor" style="height: 300px;"></div>
                    <div id="pie-chart-gedung-kantor" style="height: 300px; display: none"></div>
                </div>
            </div>
            <!--end::Portlet-->

        </div>
        <div class="col-md-3 col-lg-3">
            <!--begin::Portlet-->
            <div class="m-portlet m-portlet--tab rumah">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                Rumah Negara <span class="sub-title"></span>
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <div class="btn-toolbar justify-content-between  pull-right" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">
                                <button type="button" class="m-btn btn btn-sm btn-primary" onclick="batangrumah()">
                                    <i class="la la-bar-chart-o"></i>
                                </button>
                                <button type="button" class="m-btn btn btn-sm btn-success" onclick="pierumah()">
                                    <i class="la la-pie-chart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body block-chart">
                    <select class="form-control m-bootstrap-select m_selectpicker select" data-category="rumah" name="select-rumah" title="Golongan" data-style="btn-success">
                        <option selected value="golongan"> Golongan </option>
                        <option value="luasan"> Luasan </option>
                        <option value="kondisi"> Kondisi </option>
                    </select>

                    <div id="chart-rumah-negara" style="height: 300px;"></div>
                    <div id="pie-chart-rumah-negara" style="height: 300px; display: none"></div>
                </div>
            </div>
            <!--end::Portlet-->

        </div>
        <div class="col-md-3 col-lg-3">
            <!--begin::Portlet-->
            <div class="m-portlet m-portlet--tab kendaraan">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                Kendaraan Bermotor <span class="sub-title"></span>
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <div class="btn-toolbar justify-content-between  pull-right" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">
                                <button type="button" class="m-btn btn btn-sm btn-primary" onclick="batangkendaraan()">
                                    <i class="la la-bar-chart-o"></i>
                                </button>
                                <button type="button" class="m-btn btn btn-sm btn-success" onclick="piekendaraan()">
                                    <i class="la la-pie-chart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body block-chart">
                    <select class="form-control m-bootstrap-select m_selectpicker select" data-category="kendaraan" name="select-kendaraan" title="Klasifikasi" data-style="btn-danger">
                        <option selected value="klasifikasi"> Klasifikasi </option>
                        <option value="kondisi"> Kondisi </option>
                    </select>

                    <div id="chart-kendaraan-bermotor" style="height: 300px;"></div>
                    <div id="pie-chart-kendaraan-bermotor" style="height: 300px; display: none"></div>
                </div>
            </div>
            <!--end::Portlet-->

        </div>
    </div>

    {{--<div class="row justify-content-md-center m--padding-bottom-15 m-row--col-separator-xl">--}}
        {{--<div class="bg-white col-md-12 col-lg-6 col-xl-3">--}}
            {{--<!--begin::Total Profit-->--}}
            {{--<div class="m-widget24">--}}
                {{--<div class="m-widget24__item">--}}
                    {{--<h4 class="m-widget24__title"> Penetapan Status Penggunaan </h4>--}}
                    {{--<br>--}}
                    {{--<span class="m-widget24__desc"> Total Usulan </span>--}}
                    {{--<div class="m--space-5"></div>--}}
                    {{--<br>--}}
                    {{--<span class="m-widget24__stats m--font-brand m--margin-bottom-15">--}}
                        {{--{{ $total_usulan_psp }}--}}
                    {{--</span>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<!--end::Total Profit-->--}}
        {{--</div>--}}
        {{--<div class="bg-white col-md-12 col-lg-6 col-xl-3">--}}
            {{--<!--begin::Total Profit-->--}}
            {{--<div class="m-widget24">--}}
                {{--<div class="m-widget24__item">--}}
                    {{--<h4 class="m-widget24__title">--}}
                        {{--Penghapusan--}}
                    {{--</h4>--}}
                    {{--<br>--}}
                    {{--<span class="m-widget24__desc">--}}
                        {{--Total Usulan--}}
                    {{--</span>--}}
                    {{--<div class="m--space-5"></div>--}}
                    {{--<br>--}}
                    {{--<span class="m-widget24__stats m--font-info m--margin-bottom-15">--}}
                        {{--{{ $total_usulan_penghapusan }}--}}
                    {{--</span>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<!--end::Total Profit-->--}}
        {{--</div>--}}
    {{--</div>--}}

    {{--<div class="row justify-content-md-center">--}}
        {{--<div class="col-lg-4 col-md-4">--}}
            {{--<!--begin::Portlet-->--}}
            {{--<div class="m-portlet m-portlet--tab">--}}
                {{--<div class="m-portlet__head">--}}
                    {{--<div class="m-portlet__head-caption">--}}
                        {{--<div class="m-portlet__head-title">--}}
                            {{--<span class="m-portlet__head-icon m--hide">--}}
                                {{--<i class="la la-gear"></i>--}}
                            {{--</span>--}}
                            {{--<h3 class="m-portlet__head-text"> Penetapan Status Penggunaan </h3>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="m-portlet__head-tools">--}}
                        {{--<div class="btn-toolbar justify-content-between  pull-right" role="toolbar" aria-label="Toolbar with button groups">--}}
                            {{--<div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">--}}
                                {{--<button type="button" class="m-btn btn btn-sm btn-primary" onclick="batangpsp()">--}}
                                    {{--<i class="la la-bar-chart-o"></i>--}}
                                {{--</button>--}}
                                {{--<button type="button" class="m-btn btn btn-sm btn-success" onclick="piepsp()" >--}}
                                    {{--<i class="la la-pie-chart"></i>--}}
                                {{--</button>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="m-portlet__body block-chart">--}}
                    {{--<div id="chart-usulan-psp" style="height: 300px;"></div>--}}
                    {{--<div id="pie-chart-usulan-psp" style="height: 300px; display: none"></div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<!--end::Portlet-->--}}
        {{--</div>--}}
        {{--<div class="col-lg-4 col-md-4">--}}
            {{--<!--begin::Portlet-->--}}
            {{--<div class="m-portlet m-portlet--tab">--}}
                {{--<div class="m-portlet__head">--}}
                    {{--<div class="m-portlet__head-caption">--}}
                        {{--<div class="m-portlet__head-title">--}}
                            {{--<span class="m-portlet__head-icon m--hide">--}}
                                {{--<i class="la la-gear"></i>--}}
                            {{--</span>--}}
                            {{--<h3 class="m-portlet__head-text">--}}
                                {{--Penghapusan--}}
                            {{--</h3>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="m-portlet__head-tools">--}}
                        {{--<div class="btn-toolbar justify-content-between  pull-right" role="toolbar" aria-label="Toolbar with button groups">--}}
                            {{--<div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">--}}
                                {{--<button type="button" class="m-btn btn btn-sm btn-primary" onclick="batangpenghapusan()">--}}
                                    {{--<i class="la la-bar-chart-o"></i>--}}
                                {{--</button>--}}
                                {{--<button type="button" class="m-btn btn btn-sm btn-success" onclick="piepenghapusan()">--}}
                                    {{--<i class="la la-pie-chart"></i>--}}
                                {{--</button>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="m-portlet__body block-chart">--}}
                    {{--<div id="chart-usulan-penghapusan" style="height: 300px;"></div>--}}
                    {{--<div id="pie-chart-usulan-penghapusan" style="height: 300px; display: none"></div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<!--end::Portlet-->--}}
        {{--</div>--}}
    {{--</div>--}}

    <div class="modal fade" id="modalFilter" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Tampilkan  </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> &times; </span>
                    </button>
                </div>
                <form class="m-form m-form--label-align-right" action="#" method="POST" id="form-import">
                    <div class="modal-body">
                        <div class="m-form__section m-form__section--first">
                            <div class="form-group m-form__group row">
                                <label class="col-md-3 col-form-label"> Reset </label>
                                <div class="col-md-3">
                                    <a href="{{ route($config['route'] . '.index') }}" class="btn btn-danger btn-sm">
                                        <i class="la la-times"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-md-3 col-form-label"> Tampilkan berdasarkan </label>
                                <div class="col-md-3">
                                    <select name="filterData" class="form-control select2" style="width: 100%;">
                                        @if($viewAllAsset)
                                            <option value="satker">Satker</option>
                                            <option value="lingkungan">Lingkungan</option>
                                            <option value="wilayah">Wilayah</option>
                                        @elseif($viewAllWilayahAsset && $viewAllLingkunganAsset)
                                            <option value="satker">Satker</option>
                                        @elseif($viewAllWilayahAsset)
                                            <option value="satker">Satker</option>
                                            <option value="lingkungan">Lingkungan</option>
                                        @elseif($viewAllLingkunganAsset)
                                            <option value="satker">Satker</option>
                                            <option value="wilayah">Wilayah</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            @if($viewAllAsset)
                                <div class="form-group m-form__group row filter" data-id="satker">
                                    <label class="col-md-3 col-form-label"> Satker </label>
                                    <div class="col-md-7">
                                        <select name="filter[satker]" class="form-control select2" style="width: 100%;">
                                            <option value="">Pilih</option>
                                            @foreach($satkers as $satker)
                                                <option {!! isset($request['filter']['satker']) && $request['filter']['satker'] == $satker->kode ? 'selected="selected"' : '' !!} value="{{ $satker->kode }}">{{ $satker->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row filter" data-id="lingkungan" style="display: none;">
                                    <label class="col-md-3 col-form-label"> Lingkungan </label>
                                    <div class="col-md-6">
                                        <select name="filter[lingkungan]" class="form-control select2" style="width: 100%;">
                                            <option value="">Pilih</option>
                                            @foreach($lingkungans as $k => $lingkungan)
                                                <option {!! isset($request['filter']['lingkungan']) && $request['filter']['lingkungan'] == $k ? 'selected="selected"' : '' !!} value="{{ $k }}">{{ $lingkungan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row filter" data-id="wilayah" style="display: none;">
                                    <label class="col-md-3 col-form-label"> Wilayah </label>
                                    <div class="col-md-6">
                                        <select name="filter[wilayah]" class="form-control select2" style="width: 100%;">
                                            <option value="">Pilih</option>
                                            @foreach($wilayahs as $wilayah)
                                                <option {!! isset($request['filter']['wilayah']) && $request['filter']['wilayah'] == $wilayah->id ? 'selected="selected"' : '' !!} value="{{ $wilayah->id }}">{{ $wilayah->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @elseif($viewAllWilayahAsset && $viewAllLingkunganAsset)
                                <div class="form-group m-form__group row filter" data-id="satker">
                                    <label class="col-md-3 col-form-label"> Satker </label>
                                    <div class="col-md-7">
                                        <select name="filter[satker]" class="form-control select2" style="width: 100%;">
                                            <option value="">Pilih</option>
                                            @foreach($satkers as $satker)
                                                <option {!! isset($request['filter']['satker']) && $request['filter']['satker'] == $satker->kode ? 'selected="selected"' : '' !!} value="{{ $satker->kode }}">{{ $satker->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @elseif($viewAllWilayahAsset)
                                <div class="form-group m-form__group row filter" data-id="satker">
                                    <label class="col-md-3 col-form-label"> Satker </label>
                                    <div class="col-md-7">
                                        <select name="filter[satker]" class="form-control select2" style="width: 100%;">
                                            <option value="">Pilih</option>
                                            @foreach($satkers as $satker)
                                                <option {!! isset($request['filter']['satker']) && $request['filter']['satker'] == $satker->kode ? 'selected="selected"' : '' !!} value="{{ $satker->kode }}">{{ $satker->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row filter" data-id="lingkungan" style="display: none;">
                                    <label class="col-md-3 col-form-label"> Lingkungan </label>
                                    <div class="col-md-6">
                                        <select name="filter[lingkungan]" class="form-control select2" style="width: 100%;">
                                            <option value="">Pilih</option>
                                            @foreach($lingkungans as $k => $lingkungan)
                                                <option {!! isset($request['filter']['lingkungan']) && $request['filter']['lingkungan'] == $k ? 'selected="selected"' : '' !!} value="{{ $k }}">{{ $lingkungan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @elseif($viewAllLingkunganAsset)
                                <div class="form-group m-form__group row filter" data-id="satker">
                                    <label class="col-md-3 col-form-label"> Satker </label>
                                    <div class="col-md-7">
                                        <select name="filter[satker]" class="form-control select2" style="width: 100%;">
                                            <option value="">Pilih</option>
                                            @foreach($satkers as $satker)
                                                <option {!! isset($request['filter']['satker']) && $request['filter']['satker'] == $satker->kode ? 'selected="selected"' : '' !!} value="{{ $satker->kode }}">{{ $satker->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row filter" data-id="wilayah" style="display: none;">
                                    <label class="col-md-3 col-form-label"> Wilayah </label>
                                    <div class="col-md-6">
                                        <select name="filter[wilayah]" class="form-control select2" style="width: 100%;">
                                            <option value="">Pilih</option>
                                            @foreach($wilayahs as $wilayah)
                                                <option {!! isset($request['filter']['wilayah']) && $request['filter']['wilayah'] == $wilayah->id ? 'selected="selected"' : '' !!} value="{{ $wilayah->id }}">{{ $wilayah->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
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
        var filter = {!! json_encode($filter) !!};

        function pietanah(){
            $("#chart-tanah").css("display","none");
            $("#pie-chart-tanah").css("display","block");
        }
        function batangtanah(){
            $("#chart-tanah").css("display","block");
            $("#pie-chart-tanah").css("display","none");
        }

        function piegedung(){
            $("#chart-gedung-kantor").css("display","none");
            $("#pie-chart-gedung-kantor").css("display","block");
        }
        function batanggedung(){
            $("#chart-gedung-kantor").css("display","block");
            $("#pie-chart-gedung-kantor").css("display","none");
        }

        function pierumah(){
            $("#chart-rumah-negara").css("display","none");
            $("#pie-chart-rumah-negara").css("display","block");
        }
        function batangrumah(){
            $("#chart-rumah-negara").css("display","block");
            $("#pie-chart-rumah-negara").css("display","none");
        }

        function piekendaraan(){
            $("#chart-kendaraan-bermotor").css("display","none");
            $("#pie-chart-kendaraan-bermotor").css("display","block");
        }
        function batangkendaraan(){
            $("#chart-kendaraan-bermotor").css("display","block");
            $("#pie-chart-kendaraan-bermotor").css("display","none");
        }

        function piepsp(){
            $("#chart-usulan-psp").css("display","none");
            $("#pie-chart-usulan-psp").css("display","block");
        }
        function batangpsp(){
            $("#chart-usulan-psp").css("display","block");
            $("#pie-chart-usulan-psp").css("display","none");
        }

        function piepenghapusan(){
            $("#chart-usulan-penghapusan").css("display","none");
            $("#pie-chart-usulan-penghapusan").css("display","block");
        }
        function batangpenghapusan(){
            $("#chart-usulan-penghapusan").css("display","block");
            $("#pie-chart-usulan-penghapusan").css("display","none");
        }

        Highcharts.setOptions({
            lang: {
                decimalPoint: ',',
                thousandsSep: '.'
            },
            title: {
                text: ''
            },
            yAxis: {
                title: {
                    text: ''
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                column: {
                    depth: 25,
                    dataLabels: {
                        enabled: true
                    }
                },
                pie: {
                    depth: 35,
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '{point.percentage:.1f} %',
                        distance: -50,
                        filter: {
                            property: 'percentage',
                            operator: '>',
                            value: 4
                        }
                    },
                    showInLegend: true
                }
            },
            colors: ["#01b8aa", "#fd625e", "#374649", "#f2c80f"]
        });

        var type = {'tanah': 'total', 'gedung': 'total', 'rumah': 'total', 'kendaraan':'total',};

        $(document).ready(function () {
            $('.select2').select2();

            $("select[name='filterData']").change(function () {
                $('#modalFilter .filter').hide();
                $('[data-id="'+$(this).val()+'"]').show();
            });

            $('#modalFilter form').submit(function () {
                mApp.block('#modalFilter');
                var url = '{{ route($config['route'] . '.index') }}';
                window.location = url + '?' + $(this).serialize();
                return false;
            });

            var chart = [];
            mApp.block('.block-chart');
            $.ajax(
                {
                    type: 'GET',
                    url : "{{ route('admin.dashboard.diagram') }}",
                    data: { filter: filter }
                })
                .done(function (response) {
                var TanahSertifikat = response.TanahSertifikat;
                var TanahTidakSertifikat = response.TanahTidakSertifikat;
                var RumahNegaraGol1 = response.RumahNegaraGol1;
                var RumahNegaraGol2 = response.RumahNegaraGol2;
                var RumahNegaraLainnya = response.RumahNegaraLainnya;
                var KendaraanRoda2 = response.KendaraanRoda2;
                var KendaraanRoda4 = response.KendaraanRoda4;
                var KendaraanLainnya = response.KendaraanLainnya;

                chart['tanah'] = [];
                chart['tanah']['col'] = Highcharts.chart('chart-tanah', {
                    chart: {
                        type: 'column',
                        options3d: {
                            enabled: true,
                            alpha: 15,
                            beta: 15,
                            depth: 50,
                            viewDistance: 25
                        }
                    },
                    xAxis: {
                        type: 'category'
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
                    },

                    series: [
                        {
                            name: "Tanah",
                            colorByPoint: true,
                            data: [
                                {
                                    name: "Sertifikat",
                                    y: TanahSertifikat
                                },
                                {
                                    name: "Belum",
                                    y: TanahTidakSertifikat
                                }
                            ]
                        }
                    ]
                });
                chart['tanah']['pie'] = Highcharts.chart('pie-chart-tanah', {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie',
                        options3d: {
                            enabled: true,
                            alpha: 45,
                            beta: 0,
                            depth: 50,
                            viewDistance: 25
                        }
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    legend: {
                        enabled: true
                    },
                    series: [{
                        name: 'Tanah',
                        colorByPoint: true,
                        data: [{
                            name: 'Sertifikat',
                            y: TanahSertifikat
                        }, {
                            name: 'Belum',
                            y: TanahTidakSertifikat
                        }]
                    }]
                });

                chart['gedung'] = [];
                chart['gedung']['col'] = Highcharts.chart('chart-gedung-kantor', {
                    chart: {
                        type: 'column',
                        options3d: {
                            enabled: true,
                            alpha: 15,
                            beta: 15,
                            depth: 50,
                            viewDistance: 25
                        }
                    },
                    xAxis: {
                        type: 'category'
                    },

                    tooltip: {
                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
                    },

                    series: [
                        {
                            name: "Gedung Kantor",
                            colorByPoint: true,
                            data: [
                                {
                                    name: "<= 3000 m2",
                                    y: response.m1
                                },
                                {
                                    name: "> 3000 m2",
                                    y: response.m2
                                }
                            ]
                        }
                    ]
                });
                chart['gedung']['pie'] = Highcharts.chart('pie-chart-gedung-kantor', {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie',
                        options3d: {
                            enabled: true,
                            alpha: 45,
                            beta: 0,
                            depth: 50,
                            viewDistance: 25
                        }
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    legend: {
                        enabled: true
                    },
                    series: [{
                        name: 'Gedung Kantor',
                        colorByPoint: true,
                        data: [{
                            name: '<= 3000 m2',
                            y: response.m1
                        }, {
                            name: '> 3000 m2',
                            y: response.m2
                        }]
                    }]
                });

                chart['rumah'] = [];
                chart['rumah']['col'] = Highcharts.chart('chart-rumah-negara', {
                    chart: {
                        type: 'column',
                        options3d: {
                            enabled: true,
                            alpha: 15,
                            beta: 15,
                            depth: 50,
                            viewDistance: 25
                        }
                    },
                    xAxis: {
                        type: 'category'
                    },

                    tooltip: {
                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
                    },

                    series: [
                        {
                            name: "Rumah Negara",
                            colorByPoint: true,
                            data: [
                                {
                                    name: "Golongan I",
                                    y: RumahNegaraGol1
                                },
                                {
                                    name: "Golongan II",
                                    y: RumahNegaraGol2
                                },
                                {
                                    name: "Lainnya",
                                    y: RumahNegaraLainnya
                                }
                            ]
                        }
                    ]
                });
                chart['rumah']['pie'] = Highcharts.chart('pie-chart-rumah-negara', {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie',
                        options3d: {
                            enabled: true,
                            alpha: 45,
                            beta: 0,
                            depth: 50,
                            viewDistance: 25
                        }
                    },
                    legend: {
                        enabled: true
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    series: [{
                        name: 'Rumah Negara',
                        colorByPoint: true,
                        data: [{
                            name: 'Golongan I',
                            y: RumahNegaraGol1
                        }, {
                            name: 'Golongan II',
                            y: RumahNegaraGol2
                        }]
                    }]
                });

                chart['kendaraan'] = [];
                chart['kendaraan']['col'] = Highcharts.chart('chart-kendaraan-bermotor', {
                    chart: {
                        type: 'column',
                        options3d: {
                            enabled: true,
                            alpha: 15,
                            beta: 15,
                            depth: 50,
                            viewDistance: 25
                        }
                    },
                    xAxis: {
                        type: 'category'
                    },

                    tooltip: {
                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
                    },

                    series: [
                        {
                            name: "Kendaraan Bermotor",
                            colorByPoint: true,
                            data: [
                                {
                                    name: "Roda 2",
                                    y: KendaraanRoda2
                                },
                                {
                                    name: "Roda 4",
                                    y: KendaraanRoda4
                                },
                                {
                                    name: "Lainnya",
                                    y: KendaraanLainnya
                                }
                            ]
                        }
                    ]
                });
                chart['kendaraan']['pie'] = Highcharts.chart('pie-chart-kendaraan-bermotor', {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie',
                        options3d: {
                            enabled: true,
                            alpha: 45,
                            beta: 0,
                            depth: 50,
                            viewDistance: 25
                        }
                    },
                    legend: {
                        enabled: true
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    series: [{
                        name: 'Kendaraan Bermotor',
                        colorByPoint: true,
                        data: [{
                            name: 'Roda 2',
                            y: KendaraanRoda2
                        }, {
                            name: 'Roda 4',
                            y: KendaraanRoda4
                        }, {
                            name: 'Lainnya',
                            y: KendaraanLainnya
                        }]
                    }]
                });

                // Batang Chart Usulan PSP
                // Highcharts.chart('chart-usulan-psp', {
                //     chart: {
                //         type: 'column',
                //         options3d: {
                //             enabled: true,
                //             alpha: 15,
                //             beta: 15,
                //             depth: 50,
                //             viewDistance: 25
                //         }
                //     },
                //     title: {
                //         text: ''
                //     },
                //     xAxis: {
                //         type: 'category'
                //     },
                //     yAxis: {
                //         title: {
                //             text: ''
                //         }
                //
                //     },
                //     legend: {
                //         enabled: false
                //     },
                //     plotOptions: {
                //         series: {
                //             borderWidth: 0,
                //             dataLabels: {
                //                 enabled: true
                //             }
                //         }
                //     },
                //
                //     tooltip: {
                //         headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                //         pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
                //     },
                //
                //     series: [
                //         {
                //             name: "Usulan PSP",
                //             colorByPoint: true,
                //             data: [
                //                 {
                //                     name: "Sudah",
                //                     y: 58
                //                 },
                //                 {
                //                     name: "Belum",
                //                     y: 23
                //                 }
                //             ]
                //         }
                //     ]
                // });

                // Pie Chart Usulan PSP
                // Highcharts.chart('pie-chart-usulan-psp', {
                //     chart: {
                //         plotBackgroundColor: null,
                //         plotBorderWidth: null,
                //         plotShadow: false,
                //         type: 'pie',
                //         options3d: {
                //             enabled: true,
                //             alpha: 45,
                //             beta: 0,
                //             depth: 50,
                //             viewDistance: 25
                //         }
                //     },
                //     legend: {
                //         enabled: true
                //     },
                //     tooltip: {
                //         pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                //     },
                //     plotOptions: {
                //         pie: {
                //             allowPointSelect: true,
                //             cursor: 'pointer',
                //             dataLabels: {
                //                 enabled: false
                //             },
                //             showInLegend: true
                //         }
                //     },
                //     series: [{
                //         name: 'Usulan PSP',
                //         colorByPoint: true,
                //         data: [{
                //             name: 'Sudah',
                //             y: 58
                //         }, {
                //             name: 'Belum',
                //             y: 23
                //         }]
                //     }]
                // });

                // Create the chart Usulan Penghapusan
                // Highcharts.chart('chart-usulan-penghapusan', {
                //     chart: {
                //         type: 'column',
                //         options3d: {
                //             enabled: true,
                //             alpha: 15,
                //             beta: 15,
                //             depth: 50,
                //             viewDistance: 25
                //         }
                //     },
                //     xAxis: {
                //         type: 'category'
                //     },
                //     tooltip: {
                //         headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                //         pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
                //     },
                //     series: [
                //         {
                //             name: "Usulan Penghapusan",
                //             colorByPoint: true,
                //             data: [
                //                 {
                //                     name: "Proses",
                //                     y: 43
                //                 },
                //                 {
                //                     name: "Terbit",
                //                     y: 69
                //                 }
                //             ]
                //         }
                //     ]
                // });

                // Pie Chart Usulan PSP
                // Highcharts.chart('pie-chart-usulan-penghapusan', {
                //     chart: {
                //         plotBackgroundColor: null,
                //         plotBorderWidth: null,
                //         plotShadow: false,
                //         type: 'pie',
                //         options3d: {
                //             enabled: true,
                //             alpha: 45,
                //             beta: 0,
                //             depth: 50,
                //             viewDistance: 25
                //         }
                //     },
                //     legend: {
                //         enabled: true
                //     },
                //     tooltip: {
                //         pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                //     },
                //     plotOptions: {
                //         pie: {
                //             allowPointSelect: true,
                //             cursor: 'pointer',
                //             dataLabels: {
                //                 enabled: false
                //             },
                //             showInLegend: true
                //         }
                //     },
                //     series: [{
                //         name: 'Usulan Penghapusan',
                //         colorByPoint: true,
                //         data: [{
                //             name: 'Proses',
                //             y: 43
                //         }, {
                //             name: 'Terbit',
                //             y: 69
                //         }]
                //     }]
                // });
            })
                .always(function (respone) {
                mApp.unblock('.block-chart');
            });

            $('.select').change(function () {
                let category = $(this).data('category');
                typeB = type[category];
                let series = $(this).val();

                getDetail(typeB, category, series);
            });

            $('.detail').click(function () {
                let typeB = $(this).data('type');
                let category = $(this).closest('.m-widget24').data('category');
                let series = $('select[name="select-'+category+'"]').val();

                type[category] = typeB;

                getDetail(typeB, category, series);
            });

            function getDetail(type, category, series) {
                let url = '{{ route($config['route'] . '.detail') }}';
                $.get(url, {type: type, category: category, series: series, filter: filter}, function (res) {
                    $('.'+res.category+' .sub-title').text(res.title);

                    chart[res.category]['col'].series[0].update({
                        data: res.data
                    }, true);
                    chart[res.category]['pie'].series[0].update({
                        data: res.data
                    }, true);
                }, 'json');
            };

            $('.m_selectpicker').selectpicker();
        });
    </script>
@endpush