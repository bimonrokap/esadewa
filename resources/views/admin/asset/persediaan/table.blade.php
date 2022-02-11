<table class="table table-striped- table-bordered table-hover table-checkable nowrap" id="datatablePersediaan" style="width: 1200px;">
    <thead>
    <tr role="row">
        <th> No </th>
        <th width="80px"> Kode Barang </th>
        <th> Tahun </th>
        <th> Periode </th>
        <th> Kode Satker </th>
        <th> Nama Satker </th>
        <th> Nama Barang </th>
        <th width="50px"> Kuantitas </th>
        <th width="50px"> Nilai </th>
        <th width="80px"> Aksi </th>
    </tr>
    <tr class="filter">
        <th><i class="empty-text">#</i></th>
        <th><input type="text" class="form-control form-control-sm form-filter m-input" data-col-index="1" placeholder="Kode Barang" /></th>
        <th><input type="text" class="form-control form-control-sm form-filter m-input" data-col-index="2" placeholder="Tahun" /></th>
        <th><input type="text" class="form-control form-control-sm form-filter m-input" data-col-index="3" placeholder="Periode" /></th>
        <th><input type="text" class="form-control form-control-sm form-filter m-input" data-col-index="4" placeholder="Kode Satker" /></th>
        <th><input type="text" class="form-control form-control-sm form-filter m-input" data-col-index="5" placeholder="Nama Satker" /></th>
        <th><input type="text" class="form-control form-control-sm form-filter m-input" data-col-index="6" placeholder="Nama Barang" /></th>
        <th><input type="text" class="form-control form-control-sm form-filter m-input text-right" data-col-index="7" placeholder="Kuantitas" /></th>
        <th><input type="text" class="form-control form-control-sm form-filter m-input text-right" data-col-index="8" placeholder="Nilai" /></th>
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
                table: '#datatablePersediaan',
                url: "{!! $tableRoute !!}",
                order: [ 1, "desc" ],
                columns: [
                    { data: 'no', sClass: "text-center", orderable: false, searchable: false, width: "10px" },
                    { data: 'kode_barang', name: 'b.kode' },
                    { data: 'tahun' },
                    { data: 'periode' },
                    { data: 'kode_satker', name: 's.kode' },
                    { data: 'nama_satker', name: 's.name' },
                    { data: 'nama_barang', name: 'b.name' },
                    { data: 'kuantitas', sClass: 'text-right' },
                    { data: 'nilai', sClass: 'text-right' },
                    { data: 'action', sClass: "text-center", orderable: false, searchable: false, width: "100px" },
                ],
                fixedColumns: {
                    leftColumns: 2,
                    rightColumns: 1
                }
            };

            TableDatatablesAjax.init(options);
        });
    </script>
@endpush