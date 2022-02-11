@extends('template.admin.content')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"> Detail {{ $config['pageTitle'] }} {{ ($data->type == 1 ? 'Pengadaan' : 'Pemeliharaan').' Tahun '.$data->year }}</h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    @include('components.asset.filter')

                    <!--begin: Datatable -->
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
                                @if(in_array($header, ['ES1', 'DU', 'APIP', 'UAPB', 'DJKN', 'Anggaran']))
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
        </div>
    </div>

    <div class="modal fade" id="modalPagu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 500px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Pagu Alokasi </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> &times; </span>
                    </button>
                </div>
                <form class="m-form m-form--label-align-right" action="#" method="POST" id="form-pagu">
                    <div class="modal-body">
                        @component('admin.components.form.alert') @endcomponent
                        <div class="m-form__section m-form__section--first">
                            <div class="form-group m-form__group row">
                                <label class="col-lg-4 col-form-label"> Ada Anggaran </label>
                                <div class="col-lg-8">
                                    <div class="m-checkbox-list">
                                        <label class="m-checkbox">
                                            <input type="checkbox" name="anggaran" value="1" id="anggaran"> Ya
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-4 col-form-label"> Jumlah Anggaran </label>
                                <div class="col-lg-6">
                                    <div class="input-group m-input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> Rp </span>
                                        </div>
                                        <input type="text" class="form-control m-input harga required" id="jumlah" name="jumlah" disabled="" placeholder="Jumlah Anggaran" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> Tutup </button>
                        <button type="submit" class="btn btn-primary"> Simpan  </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection

@push('scripts')
    <script type="text/javascript">
        var tableFilter = {};
        $(document).ready(function () {
            let formOptions = { 'form' : '#form-pagu' };
            FormValidation.init(formOptions, function(res, statusText, xhr, form) // Callback form success
            {
                let alertError = $('.alert-error', formOptions.form);
                let alertValidation = $('.alert-validation-backend', formOptions.form);
                if(res.status === 1){ // Jika respond status bernilai benar
                    $('#modalPagu').modal('hide');
                    let content = {};
                    content.message = res.message;
                    content.title = 'Success';
                    content.icon = 'icon la la-check';

                    $.notify(content, {
                        type: "success",
                        allow_dismiss: true,
                        timer: 1000,
                        delay: 3000,
                        animate: {
                            enter: 'animated bounceIn',
                            exit: 'animated bounceOut'
                        }
                    });

                    table.table().draw();
                    $('#modalImport').modal('hide');
                }else if(res.status === 0){ // Error Gagal
                    alertError.removeClass('m--hide').show();
                    $('.m-alert__text', alertError).html(res.message);
                    mApp.scrollTo(alertError, -200);
                }else if(res.status === 2) { // Error Validasi
                    alertValidation.removeClass('m--hide').show();
                    $('.m-alert__text', alertValidation).html(res.message);
                    mApp.scrollTo(alertValidation, -200);
                }

                mApp.unblock(formOptions.form);
            });

            $('.select2').select2();

            var options = {
                table: '#datatableRkbmnDetail',
                url: "{{ route($config['route'] . '.tableDetail', $data->id) }}",
                order: [ 1, "desc" ],
                columns: [
                    { data: 'no', sClass: "text-center", orderable: false, searchable: false, width: "10px" },

                    { data: 'eselon1', class: 'text-center', width: '50px', searchable: 'false' },
                    { data: 'draftuapb', class: 'text-center', width: '50px', searchable: 'false' },
                    { data: 'apip', class: 'text-center', width: '50px', searchable: 'false' },
                    { data: 'uapb', class: 'text-center', width: '50px', searchable: 'false' },
                    { data: 'djkn', class: 'text-center', width: '50px', searchable: 'false' },
                    { data: 'is_anggaran', class: 'text-center', width: '50px', searchable: 'false'},
                    { data: 'jumlah_anggaran', class: 'text-right', width: '100px'},
                    @if($data->type == 1)
                    { data: 'no_pengadaan', class: 'text-center' },
                    @endif
                    { data: 'kode_barang' },
                    { data: 'nama_barang' },
                    { data: 'kode_satker' },
                    { data: 'nama_satker' },
                    @if($data->type == 2)
                    { data: 'nup', class: 'text-center', width: '50px' },
                    @endif

                    { data: 'action', sClass: "text-center", orderable: false, searchable: false, width: "100px" },
                ],
                fixedColumns: {
                    leftColumns: 6,
                    rightColumns: 1
                },
                data: {'filter': function () {
                    return JSON.stringify(tableFilter);
                }},
                additionalFilter: false
            };

            table = TableDatatablesAjax.init(options);

            $('#datatableRkbmnDetail').on('click', '.btn-pagu', function () {
                $('#form-pagu').attr('action', $(this).attr('href'));
                let isAnggaran = $(this).data('anggaran') == '1';
                $('#form-pagu #anggaran').prop('checked', isAnggaran);
                $('#form-pagu #jumlah').val($(this).data('jumlah'));
                if(isAnggaran){
                    $('#form-pagu #jumlah').prop('disabled', false);
                } else {
                    $('#form-pagu #jumlah').prop('disabled', true);
                }

                $('#modalPagu').modal('show');

                return false;
            });

            $('#anggaran').click(function () {
                if($(this).is(':checked')) {
                    $('#jumlah').prop('disabled', false);
                } else {
                    $('#jumlah').prop('disabled', true);
                }
            });

            $('.harga').inputmask('numeric', {
                digits: 2,
                groupSeparator: '.',
                radixPoint: ",",
                removeMaskOnSubmit: false,
                autoGroup: true
            });

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
