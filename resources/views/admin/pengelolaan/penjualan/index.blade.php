@extends('template.admin.content')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-table"></i>
                            </span>
                            <h3 class="m-portlet__head-text"> Table Usulan {{ $config['pageTitle'] }}</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            @component('admin.components.table.reload') @endcomponent
                            @if($user->type == 'satker' && \App\Repositories\Permission\Permission::can('create-' . $config['permission']))
                                <li class="m-portlet__nav-item">
                                    <a href="{{ route($config['route'] . '.create') }}" class="btn btn-primary m-btn m-btn--icon ajaxify">
                                        <span>
                                            <i class="la la-plus"></i>
                                            <span> Tambah {{ $config['pageTitle'] }} </span>
                                        </span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <!--begin: Datatable -->
                    <table class="table table-striped- table-bordered table-hover table-checkable nowrap" id="datatablePenjualan" style="width: 1200px;">
                        <thead>
                        <tr role="row">
                            <th> No </th>
                            @foreach($table['header'] as $header)
                            <th> {{ $header }} </th>
                            @endforeach
                            <th width="150px"> Aksi </th>
                        </tr>
                        <tr class="filter">
                            <th><i class="empty-text">#</i></th>
                            @foreach($table['header'] as $key => $header)
                                @if($header == "Status")
                                    <th><select class="form-control form-control-sm form-filter m-input" data-col-index="{{ $key + 1 }}">
                                        <option value="">Semua</option>
                                            @foreach($statuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                            @endforeach
                                        </select>
                                    </th>
                                @elseif(in_array($header, ["Tanggal Surat", "Tanggal Pengajuan"]))
                                    <th><input type="text" class="form-control form-control-sm form-filter m-input m_datepicker" data-col-index="{{ $key + 1 }}" placeholder="{{ $header }}" /></th>
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
    @endsection

@push('scripts')
    <script type="text/javascript">
        var table = '';
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

            var options = {
                table: '#datatablePenjualan',
                url: "{{ route($config['route'] . '.table') }}",
                order: [ 5, "desc" ],
                columns: [
                    { data: 'no', sClass: "text-center", orderable: false, searchable: false, width: "10px" },

                    { data: 'letter_number', name: 'penjualans.letter_number' },
                    { data: 'satkerName', name: 's.name' },
                    // { data: 'jumlah_barang', sClass: 'text-right' },
                    // { data: 'total_nilai_barang', sClass: 'text-right' },
                    { data: 'letter_date', sClass: 'text-center' },
                    { data: 'created_at', name: 'penjualans.created_at', sClass: 'text-center' },
                    { data: 'penjualanStatus', name: "ps.id", sClass: 'text-center' },

                    { data: 'action', sClass: "text-center", orderable: false, searchable: false, width: "100px" },
                ],
                // fixedColumns: {
                //     leftColumns: 2,
                //     rightColumns: 1
                // }
            };

            table = TableDatatablesAjax.init(options);
        });
    </script>
    @endpush
