@extends('template.admin.content')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"> Detail {{ $config['pageTitle'] }} Tahun {{ $year }}</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="{{ route($config['route'] . '.index') }}" class="btn btn-metal m-btn m-btn--icon ajaxify">
                                    <span>
                                        <i class="la la-arrow-left"></i>
                                        <span> Kembali </span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <div class="col-lg-12" id="con-detail-aset">
                            <table class="table table-bordered m-table m-table--head-bg-success table-detail-aset">
                                <thead>
                                <tr><th colspan="2" class="text-center" style="font-size: 1.5rem;">Detail Penghapusan</th></tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row"> Satker </th>
                                        <td>{!! $satker->name.' <strong>( '.$satker->kode.' )</strong>' !!}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row"> Tahun </th>
                                        <td>{!! $year !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-4">
                                    <table class="table table-bordered m-table m-table--head-bg-success table-detail-aset">
                                        <tbody>
                                        <tr>
                                            <th colspan="6" class="text-center m--bg-metal" style="font-size: 1.2rem;color: white;">Dokumen Penghapusan</th>
                                        </tr>
                                        <tr>
                                            <th scope="row" width="10%"> Jumlah SK </th>
                                            <td width="23%">{{ $penghapusan == null ? '-' : $penghapusan->sk }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" width="10%"> Unit </th>
                                            <td width="23%">{{ $penghapusan == null ? '-' : numberFormatIndo($penghapusan->jumlah_barang * -1) }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" width="10%"> Nilai </th>
                                            <td width="23%">{{ $penghapusan == null ? '-' : 'Rp '.numberFormatIndo($penghapusan->nilai_perolehan * -1) }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-4">
                                    <table class="table table-bordered m-table m-table--head-bg-success table-detail-aset">
                                        <tbody>
                                        <tr>
                                            <th colspan="6" class="text-center m--bg-metal" style="font-size: 1.2rem;color: white;">Transaksi Penghapusan</th>
                                        </tr>
                                        <tr>
                                            <th scope="row" width="10%"> Unit </th>
                                            <td width="23%">{{ $satker->kuantitas == null ? '-' : numberFormatIndo($satker->kuantitas) }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" width="10%"> Nilai </th>
                                            <td width="23%">{{ $satker->nilai == null ? '-' : 'Rp '.numberFormatIndo($satker->nilai) }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-4">
                                    <table class="table table-bordered m-table m-table--head-bg-success table-detail-aset">
                                        <tbody>
                                        <tr>
                                            <th colspan="6" class="text-center m--bg-metal" style="font-size: 1.2rem;color: white;">Selisih</th>
                                        </tr>
                                        <tr>
                                            <th scope="row" width="10%"> Unit </th>
                                            <td width="23%">{{ $penghapusan == null && $satker->kuantitas == null ? '-' :
                                             ($penghapusan != null && $satker->kuantitas != null ? numberFormatIndo($satker->kuantitas - ($penghapusan->jumlah_barang * -1)) :
                                             ($penghapusan == null ? numberFormatIndo($satker->kuantitas) : numberFormatIndo($penghapusan->jumlah_barang * -1)))
                                             }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" width="10%"> Nilai </th>
                                            <td width="23%">{{ $penghapusan == null && $satker->nilai == null ? '-' :
                                             ($penghapusan != null && $satker->nilai != null ? 'Rp '.numberFormatIndo($satker->nilai - ($penghapusan->nilai_perolehan * -1)) :
                                             ($penghapusan == null ? 'Rp '.numberFormatIndo($satker->nilai) : 'Rp '.numberFormatIndo($penghapusan->nilai_perolehan * -1)))
                                             }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-table"></i>
                            </span>
                            <h3 class="m-portlet__head-text"> Table Dokumen Penghapusan</h3>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <!--begin: Datatable -->
                    <table class="table table-striped- table-bordered table-hover table-checkable nowrap" id="datatablePenghapusan" style="width: 1200px;">
                        <thead>
                        <tr role="row">
                            <th> No </th>
                            @foreach($table['headerDokumen'] as $header)
                                <th> {{ $header }} </th>
                            @endforeach
                            <th width="150px"> Aksi </th>
                        </tr>
                        <tr class="filter">
                            <th><i class="empty-text">#</i></th>
                            @foreach($table['headerDokumen'] as $key => $header)
                                @if(in_array($header, ["Tanggal Surat", "Tanggal Pengajuan"]))
                                    <th><input type="text" class="form-control form-control-sm form-filter m-input m_datepicker" data-col-index="{{ $key + 1 }}" placeholder="{{ $header }}" /></th>
                                @elseif($header == "Tipe Penghapusan")
                                    <th><select class="form-control form-control-sm form-filter m-input" data-col-index="{{ $key + 1 }}">
                                            <option value="">Semua</option>
                                            <option value="1">Mebelair</option>
                                            <option value="2">Non Mebelair</option>
                                        </select>
                                    </th>
                                @elseif($header == 'File SK')
                                    <th></th>
                                @else
                                    <th><input type="text" class="form-control form-control-sm form-filter m-input" data-col-index="{{ $key + 1 }}" placeholder="{{ $header }}" /></th>
                                @endif
                            @endforeach
                            <th class="text-center">
                                <button class="btn btn-brand m-btn btn-sm m-btn--icon btn-submit">
                                    <i class="la la-search"></i>
                                </button>
                                <button class="btn btn-secondary m-btn btn-sm m-btn--icon btn-reset">
                                    <i class="la la-close"></i>
                                </button>
                            </th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-table"></i>
                            </span>
                            <h3 class="m-portlet__head-text"> Detail Transaksi Penghapusan</h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <table class="table table-striped- table-bordered table-hover table-checkable nowrap" id="datatableDetailPenghapusan" style="width: 1200px;">
                        <thead>
                        <tr role="row">
                            <th> No </th>
                            @foreach($table['headerTransaksi'] as $header)
                                <th> {{ $header }} </th>
                            @endforeach
                            <th width="80px"> Aksi </th>
                        </tr>
                        <tr class="filter">
                            <th><i class="empty-text">#</i></th>
                            @foreach($table['headerTransaksi'] as $key => $header)
                                <th><input type="text" class="form-control form-control-sm form-filter m-input" data-col-index="{{ $key + 1 }}" placeholder="{{ $header }}" /></th>
                            @endforeach
                            <th class="text-center">
                                <button class="btn btn-brand m-btn btn-sm m-btn--icon btn-submit">
                                    <i class="la la-search"></i>
                                </button>
                                <button class="btn btn-secondary m-btn btn-sm m-btn--icon btn-reset">
                                    <i class="la la-close"></i>
                                </button>
                            </th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
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

            TableDatatablesAjax.init({
                table: '#datatableDetailPenghapusan',
                url: "{{ route($config['route'] . '.tableTransaksi', ['id' => $satker->id, 'year' => $year]) }}",
                order: [ 1, "desc" ],
                columns: [
                    { data: 'no', sClass: "text-center", orderable: false, searchable: false, width: "10px" },

                    { data: 'kode_satker', class: 'text-center', width: '50px'},
                    { data: 'nama_satker'},
                    { data: 'akun' },
                    { data: 'uraian_akun' },
                    { data: 'kode_bidang' },
                    { data: 'uraian_bidang' },
                    { data: 'kode_transaksi' },
                    { data: 'uraian_transaksi' },
                    { data: 'kuantitas', sClass: 'text-right' },
                    { data: 'nilai', sClass: 'text-right' },

                    { data: 'action', sClass: "text-center", orderable: false, searchable: false, width: "100px" },
                ],
                fixedColumns: {
                    leftColumns: 2,
                    rightColumns: 3
                }
            });

            TableDatatablesAjax.init({
                table: '#datatablePenghapusan',
                url: "{{ route($config['route'] . '.tableDokumen', ['id' => $satker->id, 'year' => $year]) }}",
                order: [ 5, "desc" ],
                columns: [
                    { data: 'no', sClass: "text-center", orderable: false, searchable: false, width: "10px" },

                    { data: 'letter_number', name: 'penghapusans.letter_number' },
                    { data: 'letter_number_persetujuan' },
                    { data: 'surat_persetujuan', searchable: false, orderable: false },
                    { data: 'jumlah_barang', sClass: 'text-center', width: "30px" },
                    { data: 'nilai_perolehan', sClass: 'text-right' },
                    { data: 'letter_date', sClass: 'text-center' },
                    { data: 'created_at', name: 'penghapusans.created_at', sClass: 'text-center' },
                    { data: 'penghapusanType', name: 'penghapusan_type', sClass: 'text-center' },

                    { data: 'action', sClass: "text-center", orderable: false, searchable: false, width: "100px" },
                ],
                fixedColumns: {
                    leftColumns: 2,
                    rightColumns: 1
                }
            });
        });
    </script>
    @endpush
