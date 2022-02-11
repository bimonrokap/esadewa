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
                            <h3 class="m-portlet__head-text"> Monitoring PSP Keseluruhan </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            @if($filterOn)
                            <li class="m-portlet__nav-item">
                                <button type="button" class="m-portlet__nav-link btn btn-info m-btn m-btn--icon" data-toggle="modal" data-target="#modalFilter">
                                    <i class="la la-filter"></i> Filter
                                </button>
                            </li>
                            @endif
                            <li class="m-portlet__nav-item">
                                <a href="{{ route($config['route'] . '.export') }}" class="m-portlet__nav-link btn btn-success m-btn m-btn--icon" id="btn-export">
                                    <i class="la la-download"></i> Export
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    @isset($filter)
                        <div style="margin-bottom: 10px;text-align: right;">
                            @foreach($filter as $k => $f)
                                @if($f != '')
                                <div style="display: inline-block; margin-right: 10px;">
                                    <div class="input-group">
                                        <span class="input-group-text"> <strong>{{ ucwords($k) }}</strong> </span>
                                        <span class="input-group-text">
                                            @switch($k)
                                                @case('lingkungan')
                                                {{ $lingkungans[$f] }}
                                                @break
                                                @case('wilayah')
                                                {{ $wilayahs->pluck('name', 'id')->all()[$f] }}
                                                @break
                                            @endswitch
                                        </span>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    @endisset
                    <div class="table-responsive">
                        <table class="table m-table m-table--head-bg-metal table-hover table-bordered" id="table-monitoring-psp">
                            <thead>
                                <tr>
                                    <th rowspan="3" width="50px" class="text-center align-middle"> No  </th>
                                    <th rowspan="3" class="text-center align-middle"> Satker </th>
                                    <th class="text-center bg-danger" colspan="6">Total Keselurunah</th>
                                    <th rowspan="3" class="text-center align-middle" width="120px">Kategori</th>
                                </tr>
                                <tr>
                                    <th class="text-center bg-warning" colspan="2">Total</th>
                                    <th class="text-center bg-info" colspan="2">Sudah PSP</th>
                                    <th class="text-center bg-success" colspan="2">Belum PSP</th>
                                </tr>
                                <tr>
                                    <th class="text-center bg-dark" width="60px">Unit</th>
                                    <th class="text-center bg-dark" width="150px">Nilai</th>
                                    <th class="text-center bg-dark" width="60px">Unit</th>
                                    <th class="text-center bg-dark" width="150px">Nilai</th>
                                    <th class="text-center bg-dark" width="60px">Unit</th>
                                    <th class="text-center bg-dark" width="150px">Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($satkers as $k => $satker)
                                    @php
                                        $totalNilaiPspPersen = $satker->total_nilai != 0 ? round(($satker->total_nilai_psp / $satker->total_nilai) * 100) : 0;
                                        if ($totalNilaiPspPersen > 90) { $state = 'success'; $stateName = 'Baik'; }
                                        else if ($totalNilaiPspPersen > 70 && $totalNilaiPspPersen <= 90 ) { $state = 'info'; $stateName = 'Sedang'; }
                                        else if ($totalNilaiPspPersen > 50 && $totalNilaiPspPersen <= 70 ) { $state = 'warning'; $stateName = 'Buruk'; }
                                        else { $state = 'danger'; $stateName = 'Sangat Buruk'; }
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $k+1 }}</td>
                                        <td>{!! "<a class='ajaxify' href='".route($config['route'] . '.show', $satker->kode)."'>$satker->name</a><br><strong>(".$satker->kode.')</strong>' !!}</td>
                                        <td class="text-right">{{ numberFormatIndo($satker->total_unit) }}</td>
                                        <td class="text-right">Rp {{ numberFormatIndo($satker->total_nilai) }}</td>
                                        <td class="text-right">{{ numberFormatIndo($satker->total_unit_psp) }}<br><strong>({{ $satker->total_unit != 0 ? round(($satker->total_unit_psp / $satker->total_unit) * 100) : 0 }}%)</strong></td>
                                        <td class="text-right">Rp {{ numberFormatIndo($satker->total_nilai_psp) }}<br><strong>({{ $totalNilaiPspPersen }}%)</strong></td>
                                        <td class="text-right">{{ numberFormatIndo($satker->total_unit_belum_psp) }}<br><strong>({{ $satker->total_unit != 0 ? round(($satker->total_unit_belum_psp / $satker->total_unit) * 100) : 0 }}%)</strong></td>
                                        <td class="text-right">Rp {{ numberFormatIndo($satker->total_nilai_belum_psp) }}<br><strong>({{ $satker->total_nilai != 0 ? round(($satker->total_nilai_belum_psp / $satker->total_nilai) * 100) : 0 }}%)</strong></td>
                                        <td class="text-center"><span class="m-badge m-badge--{{ $state }} m-badge--wide">{{ $stateName }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>

    <div class="modal fade" id="modalFilter" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Filter  </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> &times; </span>
                    </button>
                </div>
                <form class="m-form m-form--label-align-right" action="#" method="POST" id="form-filter-psp">
                    @if($viewAllAsset || $viewAllWilayahAsset || $viewAllLingkunganAsset)
                    <div class="modal-body" style="padding: 0 25px 10px;">
                        @if($viewAllAsset || $viewAllLingkunganAsset)
                            <div class="form-group m-form__group row">
                                <label class="col-md-3 col-form-label"> Wilayah </label>
                                <div class="col-md-4">
                                    <select name="filter[wilayah]" class="form-control select2" style="width: 100%;">
                                        <option value="">Semua</option>
                                        @foreach($wilayahs as $wilayah)
                                            <option {!! isset($filter['wilayah']) && $filter['wilayah'] == $wilayah->id ? 'selected="selected"' : '' !!} value="{{ $wilayah->id }}">{{ $wilayah->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        @if($viewAllAsset || $viewAllWilayahAsset)
                            <div class="form-group m-form__group row">
                                <label class="col-md-3 col-form-label"> Lingkungan </label>
                                <div class="col-md-4">
                                    <select name="filter[lingkungan]" class="form-control select2" style="width: 100%;">
                                        <option value="">Semua</option>
                                        @foreach($lingkungans as $k => $lingkungan)
                                            <option {!! isset($filter['lingkungan']) && $filter['lingkungan'] == $k ? 'selected="selected"' : '' !!} value="{{ $k }}">{{ $lingkungan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                    </div>
                    @endif
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
        var submit = false;
        $(document).ready(function () {
            $('.select2').select2();

            $('#btn-export').click(function () {
                window.location = $(this).attr('href') + "?" + $('#modalFilter form').serialize();
                return false;
            });

            $('#form-filter-psp').submit(function () {
                submit = true;
                $('#modalFilter').modal('hide');
                return false;
            });

            $('#modalFilter').on('hidden.bs.modal', function () {
                if(submit) {
                    let data = $('#form-filter-psp').serialize();
                    Flying.ajax('{{ route($config['route'] . '.index') }}?'+data, null, 'PSP');
                }
            });
        });
    </script>
@endpush