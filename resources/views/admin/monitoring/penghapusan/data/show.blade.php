@extends('template.admin.content')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"> Detail {{ $config['pageTitle'] }} Tahun {{ $data->year }}</h3>
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
                    @include('components.asset.filter')

                    <!--begin: Datatable -->
                    <table class="table table-striped- table-bordered table-hover table-checkable nowrap" id="datatableDetailPenghapusan" style="width: 1200px;">
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
        var tableFilter = {};
        $(document).ready(function () {
            $('.select2').select2();

            var options = {
                table: '#datatableDetailPenghapusan',
                url: "{{ route($config['route'] . '.tableDetail', $data->id) }}",
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
                },
                data: {'filter': function () {
                    return JSON.stringify(tableFilter);
                }},
                additionalFilter: false
            };

            table = TableDatatablesAjax.init(options);

            $('select.filter').change(function () {
                if($(this).val() !== '') {
                    $(this).closest('.input-group').addClass('filtered');
                } else {
                    $(this).closest('.input-group').removeClass('filtered');
                }

                let $select = $('select.filter');
                tableFilter = $select.serializeArray();

                if(typeof table !== 'undefined'){
                    table.table().draw()
                }
            });
        });
    </script>
    @endpush
