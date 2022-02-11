<table class="table table-striped- table-bordered table-hover table-checkable nowrap" id="datatableKonstruksi" style="width: 1200px;">
    <thead>
    <tr role="row">
        <th> No </th>
        @foreach($table['header'] as $header)
            <th>{{ $header }}</th>
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

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var options = {
                table: '#datatableKonstruksi',
                url: "{!! $tableRoute !!}",
                order: [ 1, "desc" ],
                columns: [
                    { data: 'no', sClass: "text-center", orderable: false, searchable: false, width: "10px" },

                    { data: 'kode_barang' },
                    { data: 'nup', sClass: "text-center" },
                    { data: 'kode_satker' },
                    { data: 'nama_satker' },
                    { data: 'kib', sClass: "text-center" },
                    { data: 'nama_barang' },
                    { data: 'kondisi' },
                    { data: 'merk' },
                    { data: 'tgl_perolehan' },
                    { data: 'nilai_perolehan_pertama', sClass: "text-right" },
                    { data: 'nilai_mutasi', sClass: "text-right" },
                    { data: 'nilai_perolehan', sClass: "text-right" },
                    { data: 'nilai_penyusutan', sClass: "text-right" },
                    { data: 'nilai_buku', sClass: "text-right" },
                    { data: 'kuantitas', sClass: "text-right" },
                    { data: 'jml_foto', sClass: "text-center" },
                    { data: 'status_penggunaan' },
                    { data: 'status_pengelolaan' },
                    { data: 'no_psp' },
                    { data: 'tgl_psp' },
                    { data: 'tanggal_update', sClass: "text-right" },

                    { data: 'action', sClass: "text-center", orderable: false, searchable: false, width: "100px" },
                ],
                fixedColumns: {
                    leftColumns: 3,
                    rightColumns: 1
                },
                data: {'filter': function () {
                    return JSON.stringify(tableFilter);
                }}
            };

            table = TableDatatablesAjax.init(options);
        });
    </script>
@endpush