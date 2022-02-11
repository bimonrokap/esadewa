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
                                <a href="{{ route($config['route'] . '.index') }}" class="btn m-btn m-btn--icon m-btn--icon-only ajaxify">
                                    <i class="la la-arrow-left"></i>
                                </a>
                                Detail Kelengkapan Profil Asset {{ $asset->name }}
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="{{ route($config['route'] . '.asset.export', $asset->data) }}" class="m-portlet__nav-link btn btn-info m-btn m-btn--icon" id="btn-export">
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
                    <div class="table-responsive" style="min-height: 100px;">

                    </div>
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
                <form class="m-form m-form--label-align-right" action="{{ route($config['route'].'.asset.table', $asset->data) }}" method="POST" id="form-import">
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
                                                @if($viewAllAset)
                                                <option {!! $request['display'] == 'wilayah' ? 'selected="selected"' : '' !!} value="wilayah">Wilayah</option>
                                                <option {!! $request['display'] == 'satker' || $request['display'] == '' ? 'selected="selected"' : '' !!} value="satker" >Satker</option>
                                                <option {!! $request['display'] == 'lingkungan' ? 'selected="selected"' : '' !!} value="lingkungan">Lingkungan</option>
                                                <option {!! $request['display'] == 'asset' ? 'selected="selected"' : '' !!} value="asset">Asset</option>
                                                @elseif($viewAllLingkunganAsset)
                                                <option {!! $request['display'] == 'wilayah' ? 'selected="selected"' : '' !!} value="wilayah">Wilayah</option>
                                                <option {!! $request['display'] == 'satker' || $request['display'] == '' ? 'selected="selected"' : '' !!} value="satker" >Satker</option>
                                                <option {!! $request['display'] == 'asset' ? 'selected="selected"' : '' !!} value="asset">Asset</option>
                                                @elseif($viewAllWilayahAsset)
                                                <option {!! $request['display'] == 'satker' || $request['display'] == '' ? 'selected="selected"' : '' !!} value="satker" >Satker</option>
                                                <option {!! $request['display'] == 'lingkungan' ? 'selected="selected"' : '' !!} value="lingkungan">Lingkungan</option>
                                                <option {!! $request['display'] == 'asset' ? 'selected="selected"' : '' !!} value="asset">Asset</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label class="col-md-3 col-form-label"> Urutkan berdasarkan </label>
                                        <div class="col-md-3">
                                            <select name="order" class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="total">Total</option>
                                                <option value="low">Belum Lengkap</option>
                                                <option value="mid">Kurang Lengkap</option>
                                                <option value="high">Lengkap</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select name="order_opt" class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="asc">Kecil - Besar</option>
                                                <option value="desc">Besar - Kecil</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="m_tabs_6_3" role="tabpanel">
                                <div class="m-form__section m-form__section--first">
                                    @if($viewAllAset)
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
                                    @elseif($viewAllLingkunganAsset)
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
                                    @elseif($viewAllWilayahAsset)
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
                                    @endif
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
            $.get('{{ route($config['route'].'.asset.table', $asset->data) }}', $('#modalFilter form').serializeArray(), function (html) {
                $('.table-responsive').html(html);
                mApp.unblock('.table-responsive');
            });

            $('#btn-export').click(function () {
                var url = $(this).attr('href') + "?" + $('#modalFilter form').serialize();
                window.location = url;
                return false;
            });

            $('#modalFilter form').submit(function () {
                mApp.block('#modalFilter');
                $.get('{{ route($config['route'].'.asset.table', $asset->data) }}', $(this).serializeArray(), function (html) {
                    $('.table-responsive').html(html);
                    mApp.unblock('#modalFilter');
                    $('#modalFilter').modal('hide');
                }).fail(function() {
                    mApp.unblock('#modalFilter');
                });

                return false;
            });

            $('.select2').select2();
        })
    </script>
    @endpush