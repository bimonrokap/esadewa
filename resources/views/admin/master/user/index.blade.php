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
                            @permission('create-' . $config['permission'])
                            @if($jmlUser < $limitUser)
                            <li class="m-portlet__nav-item">
                                <a href="{{ route($config['route'] . '.create') }}" class="btn btn-primary m-btn m-btn--icon ajaxify">
                                    <span>
                                        <i class="la la-plus"></i>
                                        <span> Tambah {{ $config['pageTitle'] }} </span>
                                    </span>
                                </a>
                            </li>
                            @endif
                            @endpermission
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <!--begin: Datatable -->
                    <table class="table table-striped- table-bordered table-hover table-checkable nowrap" id="datatablePengguna">
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
                                @if($key == 3)
                                    <th>
                                        <select class="form-control form-control-sm form-filter m-input select2" style="width: 100%;" data-col-index="{{ $key + 1 }}">
                                            <option value="">Semua</option>
                                            @foreach($satkers as $satker)
                                                <option value="{{ $satker->id }}">{{ $satker->name }}</option>
                                                @endforeach
                                        </select>
                                    </th>
                                @elseif($key == 4)
                                    <th>
                                        <select class="form-control form-control-sm form-filter m-input select2" style="width: 100%;" data-col-index="{{ $key + 1 }}">
                                            <option value="">Semua</option>
                                            @foreach($listLingkungan as $k => $v)
                                                <option value="{{ $k }}">{{ $v }}</option>
                                                @endforeach
                                        </select>
                                    </th>
                                @elseif($key == 5)
                                    <th>
                                        <select class="form-control form-control-sm form-filter m-input select2" style="width: 100%;" data-col-index="{{ $key + 1 }}">
                                            <option value="">Semua</option>
                                            @foreach($wilayahs as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endforeach
                                        </select>
                                    </th>
                                @elseif($key == 2)
                                    <th>
                                        <select class="form-control form-control-sm form-filter m-input select2" style="width: 100%;" data-col-index="{{ $key + 1 }}">
                                            <option value="">Semua</option>
                                            @foreach($roles as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
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
    @endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2').select2();
            var options = {
                table: '#datatablePengguna',
                url: "{{ route($config['route'] . '.table') }}",
                order: [ 1, "desc" ],
                columns: [
                    { data: 'no', sClass: "text-center", orderable: false, searchable: false, width: "10px" },

                    { data: 'name', name: 'users.name' },
                    { data: 'username', name: 'users.username' },
                    { data: 'roleName', name: 'r.name' },
                    { data: 'satker', name: 's.name' },
                    { data: 'lingkungan' },
                    { data: 'wilayahName', name: 'w.name' },

                    { data: 'action', sClass: "text-center", orderable: false, searchable: false, width: "100px" },
                ],
                fixedColumns: {
                    leftColumns: 2,
                    rightColumns: 1
                },
            };

            TableDatatablesAjax.init(options);
        });
    </script>
    @endpush
