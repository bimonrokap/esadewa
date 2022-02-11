@extends('template.admin.content')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"> List {{ $config['pageTitle'] }}</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            @permission('create-' . $config['permission'])
                            <li class="m-portlet__nav-item">
                                <a href="{{ route($config['route'] . '.create') }}" class="btn btn-primary m-btn m-btn--icon ajaxify">
                                    <span>
                                        <i class="la la-plus"></i>
                                        <span> Tambah {{ $config['pageTitle'] }} </span>
                                    </span>
                                </a>
                            </li>
                            @endpermission
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <!--begin: Datatable -->
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="datatablePersediaan" style="width: 1200px;">
                        <thead>
                        <tr role="row">
                            <th> No </th>
                            @foreach($table['header'] as $header)
                            <th> {{ $header }} </th>
                            @endforeach
                            <th width="60px"> Aksi </th>
                        </tr>
                        <tr class="filter">
                            <th><i class="empty-text">#</i></th>
                            @foreach($table['header'] as $key => $header)
                                @if($header == 'Kategori Aset')
                                    <th>
                                        <select class="form-control form-control-sm form-filter m-input" data-col-index="{{ $key + 1 }}">
                                            <option value="">Semua</option>
                                            @foreach($categoryAsset as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </th>
                                @elseif($header == 'Jenis Lapor')
                                    <th>
                                        <select class="form-control form-control-sm form-filter m-input" data-col-index="{{ $key + 1 }}">
                                            <option value="">Semua</option>
                                            <option value="1">Permasalahan Umum</option>
                                            <option value="2">Force Majeure</option>
                                        </select>
                                    </th>
                                @elseif($header == 'Status')
                                    <th>
                                        <select class="form-control form-control-sm form-filter m-input" data-col-index="{{ $key + 1 }}">
                                            <option value="">Semua</option>
                                            <option value="1">Proses</option>
                                            <option value="2">Terjawab</option>
                                        </select>
                                    </th>
                                @elseif($header == 'Tanggal Lapor')
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
        $(document).ready(function () {
            $('.select2').select2();

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
                table: '#datatablePersediaan',
                url: "{{ route($config['route'] . '.table') }}",
                order: [ 1, "desc" ],
                columns: [
                    { data: 'no', sClass: "text-center", orderable: false, searchable: false, width: "10px" },

                    @if(!$canCreate)
                    { data: 'satkerName', name: 's.name', width: "100px" },
                    @endif
                    { data: 'categoryAsset', name: 'ca.name', width: "80px" },
                    { data: 'jenis' },
                    { data: 'uraian' },
                    { data: 'created_at', name: 'lapor_bmns.created_at', class: 'text-center', width: 100 },
                    { data: 'status', class: 'text-center', width: "80px" },

                    { data: 'action', sClass: "text-center", orderable: false, searchable: false, width: "140px" },
                ]
            };

            TableDatatablesAjax.init(options);
        });
    </script>
    @endpush
