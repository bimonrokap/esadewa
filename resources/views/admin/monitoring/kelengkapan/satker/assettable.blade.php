<table class="m-datatable table-custom" width="100%">
    <thead>
    <tr role="row">
        <th> No </th>
        @foreach($table['header'] as $header)
            <th class="text-center">{{ $header }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($table['data'] as $k => $data)
        <tr class="row-{{ $data->filled_status }}">
            <td>{{ ++$k }}</td>
            @foreach($table['dataValue'] as $value)
                @if(in_array($value, ['tgl_perolehan', 'tgl_psp', 'tanggal_update']))
                    <td>
                        {{ !in_array($data->{$value}, [null, '-', '']) ? \Carbon\Carbon::parse($data->{$value})->format('j F Y') : null  }}
                    </td>
                @elseif(in_array($value, ['nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku']))
                    <td class="text-right">{{ !is_nan($data->{$value}) ? 'Rp ' . numberFormatIndo($data->{$value}) : '' }}</td>
                @else
                    <td>{{ $data->{$value} }}</td>
                @endif
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
<script type="text/javascript">
    $(document).ready(function () {
        datatable();
    });

    function datatable() {
        $('.m-datatable').mDatatable({
            search: {
                input: $('#generalSearch'),
            },
            columns: [
                {
                    field: "No",
                    sortable: false, // disable sort for this column
                    width: 40,
                    textAlign: 'center',
                },
                {
                    field: "NUP",
                    width: 40,
                    textAlign: 'center',
                },
                {
                    field: "Kode Satker",
                    width: 190
                },
                {
                    field: "Nama Satker",
                    width: 250
                },
                {
                    field: "KIB",
                    width: 40,
                    textAlign: 'center',
                },
                {
                    field: "Nama Barang",
                    width: 300
                },
                {
                    field: "Nilai Perolehan Pertama",
                    textAlign: 'right',
                },
                {
                    field: "Kuantitas(m2)",
                    textAlign: 'right',
                },
                {
                    field: "Kuantitas",
                    textAlign: 'right',
                },
                {
                    field: "Luas Tanah Seluruhnya",
                    textAlign: 'right',
                },
                {
                    field: "Luas Tanah Untuk Bangunan",
                    textAlign: 'right',
                },
                {
                    field: "Luas tanah Untuk Sarana Lingkungan",
                    textAlign: 'right',
                },
                {
                    field: "Luas Lahan Kosong",
                    textAlign: 'right',
                },
                {
                    field: "Optimalisasi",
                    textAlign: 'right',
                },
                {
                    field: "Nilai Mutasi",
                    textAlign: 'right',
                },
                {
                    field: "Nilai Perolehan",
                    textAlign: 'right',
                },
                {
                    field: "Nilai Penyusutan",
                    textAlign: 'right',
                },
                {
                    field: "Nilai Buku",
                    textAlign: 'right',
                },
                {
                    field: "Tgl Perolehan",
                    textAlign: 'right',
                },
                {
                    field: "Tgl PSP",
                    textAlign: 'center',
                },
                {
                    field: "Kepemilikan",
                    width: 500
                },
                {
                    field: "Status Penggunaan",
                    width: 250
                },
                {
                    field: "Status Pengelolaan",
                    width: 250
                },
                {
                    field: "Alamat",
                    width: 250
                },
                {
                    field: "Alamat Lainnya",
                    width: 250
                },
            ]
        });
    }
</script>