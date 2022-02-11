@extends('template.admin.content')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <div class="page-title">
                                @foreach($config['pageTitle'] as $k => $title)
                                    <a class="ajaxify title @if($loop->last) active @endif" href="{{ $k }}">
                                        @if(!$loop->first) <i class="fa fa-chevron-right"></i> @endif {{ $title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            @permission('create-' . $config['permission'])
                            <li class="m-portlet__nav-item">
                                <a href="{{ route($config['route'] . '.create', ['type' => 'folder', 'id' => $id]) }}" class="btn btn-primary m-btn m-btn--icon ajaxify">
                                    <span>
                                        <i class="la la-plus"></i>
                                        <span> Tambah Folder </span>
                                    </span>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="{{ route($config['route'] . '.create', ['type' => 'file', 'id' => $id]) }}" class="btn btn-brand m-btn m-btn--icon ajaxify">
                                    <span>
                                        <i class="la la-plus"></i>
                                        <span> Tambah File </span>
                                    </span>
                                </a>
                            </li>
                            @endpermission
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <!--begin: Datatable -->
                    <table class="table table-striped- table-bordered table-hover table-checkable nowrap" id="datatablePersediaan" style="width: 1200px;">
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
        $(document).ready(function () {
            var options = {
                table: '#datatablePersediaan',
                url: "{{ route($config['route'] . '.table', $id) }}",
                order: [ 1, "desc" ],
                columns: [
                    { data: 'no', sClass: "text-center", orderable: false, searchable: false, width: "10px" },

                    { data: 'filename' },
                    { data: 'type' },
                    { data: 'order' },

                    { data: 'action', sClass: "text-center", orderable: false, searchable: false, width: "100px" },
                ]
            };

            TableDatatablesAjax.init(options);
        });
    </script>
    @endpush
