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
                            <h3 class="m-portlet__head-text"> Monitoring {{ $config['pageTitle'] }}</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            @permission('create-' . $config['permission'])
                            <li class="m-portlet__nav-item">
                                <a href="{{ route($config['route'] . '.data.index') }}" class="btn btn-primary m-btn m-btn--icon ajaxify">
                                    <span>
                                        <i class="la la-plus"></i>
                                        <span> Data {{ $config['pageTitle'] }} </span>
                                    </span>
                                </a>
                            </li>
                            @endpermission
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
                                                    @case('tahun')
                                                    {{ $f }}
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
                                    <th rowspan="2" width="50px" class="text-center align-middle"> No  </th>
                                    <th rowspan="2" class="text-center align-middle"> Satker </th>
                                    <th class="text-center bg-info" colspan="3">Dokumen Penghapusan</th>
                                    <th class="text-center bg-success" colspan="2">Transaksi Penghapusan</th>
                                    <th class="text-center bg-danger" colspan="2">Selisih</th>
                                    <th rowspan="2" class="text-center align-middle" width="60px">Aksi</th>
                                </tr>
                                <tr>
                                    <th class="text-center bg-dark" width="60px">SK</th>
                                    <th class="text-center bg-dark" width="60px">Unit</th>
                                    <th class="text-center bg-dark" width="150px">Nilai</th>
                                    <th class="text-center bg-dark" width="60px">Unit</th>
                                    <th class="text-center bg-dark" width="150px">Nilai</th>
                                    <th class="text-center bg-dark" width="60px">Unit</th>
                                    <th class="text-center bg-dark" width="150px">Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $nilai = [ 0 => [], 1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => [] ];
                                @endphp
                                @foreach($satkers as $k => $satker)
                                    @php
                                        if(isset($data[$satker->kode])){
                                            $nilai[0][] = $data[$satker->kode]->sk * -1;
                                            $nilai[1][] = $data[$satker->kode]->jumlah_barang * -1;
                                            $nilai[2][] = $data[$satker->kode]->nilai_perolehan * -1;
                                        } else {
                                            $nilai[0][] = $nilai[1][] = $nilai[2][] = null;
                                        }
                                        $nilai[3][] = $satker->kuantitas;
                                        $nilai[4][] = $satker->nilai;

                                        $nilai[5][] = $nilai[1][$k] == null && $satker->kuantitas == null ? null :
                                             ($nilai[1][$k] != null && $satker->kuantitas != null ? $satker->kuantitas - ($nilai[1][$k] * -1) :
                                             ($nilai[1][$k] == null ? $satker->kuantitas : $nilai[1][$k] * -1));
                                        $nilai[6][] = $nilai[2][$k] == null && $satker->nilai == null ? null :
                                             ($nilai[2][$k] != null && $satker->nilai != null ? $satker->nilai - ($nilai[2][$k] * -1) :
                                             ($nilai[2][$k] == null ? $satker->nilai : $nilai[2][$k] * -1));
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $k+1 }}</td>
                                        <td>{{ $satker->name }}<br><strong>({{ $satker->kode }})</strong></td>
                                        @for($i=0;$i<=6;$i++)
                                        <td class="text-right">{{ $nilai[$i][$k] == null ? '-' : (in_array($i, [2,4,6]) ? 'Rp ' : '').numberFormatIndo($nilai[$i][$k]) }}</td>
                                        @endfor
                                        <td class="text-center">
                                            <a class="btn btn-warning m-btn btn-sm m-btn--icon ajaxify" href="{{ route($config['route'] . '.show', ['id' => $satker->id, 'year' => $filter['tahun']]) }}"> <i class="la la-eye"></i> Detail </a>
                                        </td>
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
                <form class="m-form m-form--label-align-right" action="#" method="POST" id="form-filter-penghapusan">
                    <div class="modal-body" style="padding: 0 25px 10px;">
                        <div class="form-group m-form__group row">
                            <label class="col-md-3 col-form-label"> Tahun </label>
                            <div class="col-md-4">
                                <select name="filter[tahun]" class="form-control select2" style="width: 100%;">
                                    @for($i = date("Y");$i > (date('Y')-10);$i--)
                                        <option {!! isset($filter['tahun']) && $filter['tahun'] == $i ? 'selected="selected"' : '' !!} value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        @if($viewAllAsset || $viewAllWilayahAsset || $viewAllLingkunganAsset)
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
                            @endif
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
        var submit = false;
        $(document).ready(function () {
            $('.select2').select2();

            $('#btn-export').click(function () {
                window.location = $(this).attr('href') + "?" + $('#modalFilter form').serialize();
                return false;
            });

            $('#form-filter-penghapusan').submit(function () {
                submit = true;
                $('#modalFilter').modal('hide');
                return false;
            });

            $('#modalFilter').on('hidden.bs.modal', function () {
                if(submit) {
                    let data = $('#form-filter-penghapusan').serialize();
                    Flying.ajax('{{ route($config['route'] . '.index') }}?'+data, null, 'Penghapusan');
                }
            });
        });
    </script>
@endpush