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
                            <h3 class="m-portlet__head-text">Monitoring PSP Detail : {{ $satker->name.' ('.$satker->kode.')' }} </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="{{ url()->previous() }}" class="m-portlet__nav-link btn btn-info m-btn m-btn--icon ajaxify">
                                    <i class="la la-arrow-left"></i> Kembali
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="{{ route($config['route'] . '.exportSatker', $satker->kode) }}" class="m-portlet__nav-link btn btn-success m-btn m-btn--icon" id="btn-export">
                                    <i class="la la-download"></i> Export
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="table-responsive">
                        <table class="table m-table m-table--head-bg-metal table-hover table-bordered" id="table-monitoring-psp">
                            <thead>
                                <tr>
                                    <th rowspan="3" width="50px" class="text-center align-middle"> No  </th>
                                    <th rowspan="3" class="text-center align-middle"> Asset </th>
                                    <th class="text-center bg-danger" colspan="6">Total Keselurunah</th>
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
                            @foreach($data as $k => $category)
                                @php
                                    $totalNilaiPspPersen = $category->total_nilai != 0 ? round(($category->total_nilai_psp / $category->total_nilai) * 100) : 0;
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $k+1 }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td class="text-right">{{ numberFormatIndo($category->total_unit) }}</td>
                                    <td class="text-right">Rp {{ numberFormatIndo($category->total_nilai) }}</td>
                                    <td class="text-right">{{ numberFormatIndo($category->total_unit_psp) }}<br><strong>({{ $category->total_unit != 0 ? round(($category->total_unit_psp / $category->total_unit) * 100) : 0 }}%)</strong></td>
                                    <td class="text-right">Rp {{ numberFormatIndo($category->total_nilai_psp) }}<br><strong>({{ $totalNilaiPspPersen }}%)</strong></td>
                                    <td class="text-right">{{ numberFormatIndo($category->total_unit_belum_psp) }}<br><strong>({{ $category->total_unit != 0 ? round(($category->total_unit_belum_psp / $category->total_unit) * 100) : 0 }}%)</strong></td>
                                    <td class="text-right">Rp {{ numberFormatIndo($category->total_nilai_belum_psp) }}<br><strong>({{ $category->total_nilai != 0 ? round(($category->total_nilai_belum_psp / $category->total_nilai) * 100) : 0 }}%)</strong></td>
                                </tr>
                                @endforeach
                            <tr class="tr-total">
                                <td class="text-right" colspan="2"><strong>Total</strong></td>
                                <td class="text-right">{{ numberFormatIndo($dataSum->total_unit) }}</td>
                                <td class="text-right">Rp {{ numberFormatIndo($dataSum->total_nilai) }}</td>
                                <td class="text-right">{{ numberFormatIndo($dataSum->total_unit_psp) }}<br><strong>({{ $dataSum->total_unit != 0 ? round(($dataSum->total_unit_psp / $dataSum->total_unit) * 100) : 0 }}%)</strong></td>
                                <td class="text-right">Rp {{ numberFormatIndo($dataSum->total_nilai_psp) }}<br><strong>({{ $dataSum->total_nilai != 0 ? round(($dataSum->total_nilai_psp / $dataSum->total_nilai) * 100) : 0 }}%)</strong></td>
                                <td class="text-right">{{ numberFormatIndo($dataSum->total_unit_belum_psp) }}<br><strong>({{ $dataSum->total_unit != 0 ? round(($dataSum->total_unit_belum_psp / $dataSum->total_unit) * 100) : 0 }}%)</strong></td>
                                <td class="text-right">Rp {{ numberFormatIndo($dataSum->total_nilai_belum_psp) }}<br><strong>({{ $dataSum->total_nilai != 0 ? round(($dataSum->total_nilai_belum_psp / $dataSum->total_nilai) * 100) : 0 }}%)</strong></td>
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

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
        });
    </script>
@endpush