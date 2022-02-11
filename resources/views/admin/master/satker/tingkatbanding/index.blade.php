@extends('template.admin.content')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"> Table {{ $config['pageTitle'] }}</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            @permission('tingkatbanding-' . $config['permission'])
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
                    <table class="table table-striped- table-bordered table-hover table-checkable nowrap" id="datatableSatker">
                        <thead>
                        <tr role="row">
                            <th> No </th>
                            @foreach($table['header'] as $header)
                            <th> {{ $header }} </th>
                            @endforeach
                            <th width="80px"> Aksi </th>
                        </tr>
                        <tr class="filter">
                            <th><i class="empty-text">#</i></th>
                            @foreach($table['header'] as $key => $header)
                                @if($header == 'Lingkungan')
                                    <th>
                                        <select class="form-control form-control-sm form-filter m-input select2" style="width: 100%;" data-col-index="{{ $key + 1 }}">
                                            <option value="">Semua</option>
                                            @foreach($listLingkungan as $k => $v)
                                                <option value="{{ $k }}">{{ $v }}</option>
                                            @endforeach
                                        </select>
                                    </th>
                                @elseif($header == 'Wilayah')
                                    <th>
                                        <select class="form-control form-control-sm form-filter m-input select2" style="width: 100%;" data-col-index="{{ $key + 1 }}">
                                            <option value="">Semua</option>
                                            @foreach($wilayahs as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </th>
                                @elseif($header == 'Jumlah Satker')
                                    <th class="text-center">#</th>
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
            var options = {
                table: '#datatableSatker',
                url: "{{ route($config['route'] . '.table') }}",
                order: [ 1, "desc" ],
                columns: [
                    { data: 'no', sClass: "text-center", orderable: false, searchable: false, width: "10px" },

                    { data: 'lingkungan' },
                    { data: 'wilayahName', name: 'w.name' },
                    { data: 'jml', sClass: 'text-center', orderable: false, searchable: false, width: "100px" },

                    { data: 'action', sClass: "text-center", orderable: false, searchable: false, width: "100px" },
                ]
            };

            TableDatatablesAjax.init(options);
        });
    </script>
    @endpush
