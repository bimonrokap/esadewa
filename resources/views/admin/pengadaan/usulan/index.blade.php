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
                            <h3 class="m-portlet__head-text"> Table {{ $config['pageTitle'] }}</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            @component('admin.components.table.reload') @endcomponent
                            @if($user->type == 'satker' && \App\Repositories\Permission\Permission::can('create-' . $config['permission']))

                                <li class="m-portlet__nav-item">
                                    <div class="m-dropdown m-dropdown--inline m-dropdown--small m-dropdown--arrow m-dropdown--align-left" m-dropdown-toggle="hover">
                                        <a href="#" class="m-dropdown__toggle btn btn-primary  dropdown-toggle">
                                            <span> Tambah {{ $config['pageTitle'] }} </span>
                                        </a>
                                        <div class="m-dropdown__wrapper">
                                            <span class="m-dropdown__arrow m-dropdown__arrow--left"></span>
                                            <div class="m-dropdown__inner">
                                                <div class="m-dropdown__body">
                                                    <div class="m-dropdown__content">
                                                        <ul class="m-nav">
                                                            @foreach($types as $type)
                                                                @if($type->id == 1)
                                                                    <li class="m-nav__item">
                                                                        <a href="{{ route($config['route'] . '.create', ['type' => $type->id, 'tanah' => 1]) }}" class="m-nav__link ajaxify">
                                                                            <i class="m-nav__link-icon la la-angle-right "></i>
                                                                            <span class="m-nav__link-text"> {{ $type->name }} (Baru) </span>
                                                                        </a>
                                                                    </li>
                                                                    <li class="m-nav__item">
                                                                        <a href="{{ route($config['route'] . '.create', ['type' => $type->id, 'tanah' => 2]) }}" class="m-nav__link ajaxify">
                                                                            <i class="m-nav__link-icon la la-angle-right "></i>
                                                                            <span class="m-nav__link-text"> {{ $type->name }} (Perluasan) </span>
                                                                        </a>
                                                                    </li>
                                                                    @else
                                                                    <li class="m-nav__item">
                                                                        <a href="{{ route($config['route'] . '.create', $type->id) }}" class="m-nav__link ajaxify">
                                                                            <i class="m-nav__link-icon la la-angle-right "></i>
                                                                            <span class="m-nav__link-text"> {{ $type->name }} </span>
                                                                        </a>
                                                                    </li>
                                                                    @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                @elseif($header == "Tipe Pengadaan")
                                    <th><select class="form-control form-control-sm form-filter m-input" data-col-index="{{ $key + 1 }}">
                                        <option value="">Semua</option>
                                            @foreach($types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
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

                    { data: 'letter_number', name: 'pengadaans.letter_number' },
                    { data: 'satkerName', name: 's.name' },
                    { data: 'letter_date', sClass: 'text-center' },
                    { data: 'created_at', name: 'pengadaans.created_at', sClass: 'text-center' },
                    { data: 'pengadaanType', name: 'id_pengadaan_type' },
                    { data: 'pengadaanStatus', name: "ps.id" },

                    { data: 'action', sClass: "text-center", orderable: false, searchable: false, width: "100px" },
                ],
                fixedColumns: {
                    leftColumns: 2,
                    rightColumns: 1
                }
            };

            table = TableDatatablesAjax.init(options);
        });
    </script>
    @endpush
