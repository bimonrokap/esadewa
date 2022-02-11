<div class="modal fade" id="modalRkbmn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 1200px" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Pilih RKBMN </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"> &times; </span>
                </button>
            </div>
            <form class="m-form m-form--label-align-right" action="#" method="POST" id="form">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group m-form__group row">
                        <label class="col-lg-2 col-form-label"> Tahun RKBMN </label>
                        <div class="col-lg-2">
                            <div class="input-group">
                                <input type="text" class="form-control text-center m-input yearInput" name="year" value="{{ date('Y')+1 }}">
                                <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="la la-calendar"></i>
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <table class="table table-striped- table-bordered table-hover table-checkable nowrap" id="datatableRkbmnDetail" style="width: 1200px;">
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
                                    @if(in_array($header, ['ES1', 'DU', 'APIP', 'UAPB', 'DJKN']))
                                        <th class="text-center"><i class="empty-text">#</i> </th>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Tutup </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalRkbmnDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 1000px" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Detail RKBMN </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"> &times; </span>
                </button>
            </div>
            <form class="m-form m-form--label-align-right" action="#" method="POST" id="form">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="con-data"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-pilih"> Pilih </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Tutup </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        var year, table;
        var firstTime = true;
        $(document).ready(function () {
            year = $('.yearInput').val();
            $('.yearInput').datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                autoclose: true
            });
            $('.yearInput').change(function () {
                year = $(this).val();

                table.ajax.reload();
            });

            $('#inputRkbmn').click(function () {
                $('#modalRkbmn').modal('show');
            });
            $('#modalRkbmn').on('shown.bs.modal', function (e) {

                if(firstTime) {
                    firstTime = false;

                    var options = {
                        table: '#datatableRkbmnDetail',
                        url: "{{ route($config['route'] . '.tableRkbmn') }}",
                        order: [ 1, "desc" ],
                        columns: [
                            { data: 'no', sClass: "text-center", orderable: false, searchable: false, width: "10px" },

                            { data: 'eselon1', class: 'text-center', width: '50px', searchable: 'false' },
                            { data: 'draftuapb', class: 'text-center', width: '50px', searchable: 'false' },
                            { data: 'apip', class: 'text-center', width: '50px', searchable: 'false' },
                            { data: 'uapb', class: 'text-center', width: '50px', searchable: 'false' },
                            { data: 'djkn', class: 'text-center', width: '50px', searchable: 'false' },
                            { data: 'no_pengadaan', class: 'text-center' },
                            { data: 'kode_barang' },
                            { data: 'nama_barang' },
                            { data: 'kode_satker' },
                            { data: 'nama_satker' },

                            { data: 'action', sClass: "text-center", orderable: false, searchable: false, width: "100px" },
                        ],
                        data: {'year': function () {
                                return year;
                            }},
                        fixedColumns: {
                            leftColumns: 6,
                            rightColumns: 1
                        }
                    };

                    table = TableDatatablesAjax.init(options);
                }

                $('#datatableRkbmnDetail').on('click', '.btn-detail', function () {
                    let url = $(this).attr('href');
                    $.get(url, function (html) {
                        $('#modalRkbmnDetail .btn-pilih').show();
                        $('#modalRkbmnDetail .con-data').html(html);
                        $('#modalRkbmnDetail').modal('show');
                    });

                    return false;
                });
            })

            $('#modalRkbmnDetail .btn-pilih').click(function () {
                let noPengadaan = $('#modalRkbmnDetail #noPengadaan').text();
                let kodeBarang = $('#modalRkbmnDetail #kodeBarang').text();
                let kodeSatker = $('#modalRkbmnDetail #kodeSatker').text();
                let id = $('#modalRkbmnDetail input[name="idRkbmn"]').val();

                let val = noPengadaan+'/'+kodeBarang+'/'+kodeSatker;
                $('#inputRkbmn').val(val);
                $('#modalRkbmnDetail').modal('hide');
                $('#modalRkbmn').modal('hide');
                $('#btn-exist-detail').prop('disabled', false);
                $('input[name="id_rkbmn_uraian"]').val(id);
            });
            $('#btn-exist-detail').click(function () {
                let id = $('input[name="id_rkbmn_uraian"]').val();

                $.get('{{ route($config['route'] . '.detailRkbmn') }}/'+id, {type : 'detail'}, function (html) {
                    $('#modalRkbmnDetail .con-data').html(html);
                    $('#modalRkbmnDetail .btn-pilih').hide();
                    $('#modalRkbmnDetail').modal('show');
                });

                return false;
            });
        });
    </script>
    @endpush