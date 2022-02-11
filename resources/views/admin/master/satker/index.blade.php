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
                                <a href="{{ route($config['route'] . '.tingkatbanding.index') }}" class="btn btn-primary m-btn m-btn--icon ajaxify">
                                <span>
                                    <i class="la la-users"></i>
                                    <span> Tingkat Banding </span>
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
                                @elseif($header == 'Type')
                                    <th>
                                        <select class="form-control form-control-sm form-filter m-input select2" style="width: 100%;" data-col-index="{{ $key + 1 }}">
                                            <option value="">Semua</option>
                                            @foreach($listType as $k => $v)
                                                <option value="{{ $k }}">{{ $v }}</option>
                                            @endforeach
                                        </select>
                                    </th>
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

    <div class="modal fade" id="modalShow" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Profil Satker </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> &times; </span>
                    </button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Tutup </button>
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

                    { data: 'kode', name: 'satkers.kode' },
                    { data: 'name', name: 'satkers.name' },
                    { data: 'wilayah', name: 'wilayahs.name' },
                    { data: 'city' },
                    { data: 'satker_type' },
                    { data: 'type' },

                    { data: 'action', sClass: "text-center", orderable: false, searchable: false, width: "100px" },
                ]
            };

            TableDatatablesAjax.init(options);
        });

        $('#datatableSatker').on('click', '.btn-show', function () {
            let url = $(this).attr('href');
            $.get(url, function (html) {
                $('#modalShow .modal-body').html(html);

                $('#modalShow').modal('show');
            });

            return false;
        });
    </script>
    @endpush
