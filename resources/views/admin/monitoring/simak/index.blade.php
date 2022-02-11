@extends('template.admin.content')

@php
    $tmpS = \Carbon\Carbon::createFromFormat('Y/n', $limit['start'].'/'.$limit['startMonth']);
    $tmpE = \Carbon\Carbon::createFromFormat('Y/n', $limit['end'].'/'.$limit['endMonth']);
@endphp

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"> Table {{ $config['pageTitle'] }} {{ $titleSatker or '' }} : {{ $tmpS->format('F Y').' s/d '.$tmpE->format('F Y') }}</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            {{--<li class="m-portlet__nav-item">--}}
                                {{--<a href="{{ route($config['route'] . '.downloadBatch', $limit) }}" class="btn btn-info m-btn m-btn--icon">--}}
                                    {{--<span>--}}
                                        {{--<i class="la la-download"></i>--}}
                                        {{--<span> Batch Download </span>--}}
                                    {{--</span>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            <li class="m-portlet__nav-item">
                                <button class="btn btn-primary m-btn m-btn--icon" data-toggle="modal" data-target="#modalFilter">
                                <span>
                                    <i class="la la-search"></i>
                                    <span> Filter Data </span>
                                </span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="table-responsive" id="con-table-backup">
                        @if($idSatker == '')
                            <h3 class="text-center" style="margin: 200px 0;">Silahkan pilih SATKER terlebih dahulu.</h3>
                        @else
                            @include('admin.monitoring.simak.table')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 500px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Upload Backup Simak <span id="date"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> &times; </span>
                    </button>
                </div>
                <form enctype="multipart/form-data" class="m-form m-form--label-align-right" action="{{ route($config['route'].'.upload') }}" method="POST" id="form-upload">
                    <div class="modal-body">
                        @component('admin.components.form.alert') @endcomponent
                        <div class="m-form__section m-form__section--first">
                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label"> File </label>
                                <div class="col-lg-10">
                                    <div class="custom-file">
                                        <input name="file" type="file" class="custom-file-input" accept=".bac" id="file">
                                        <label class="custom-file-label" for="file"> Pilih File </label>
                                    </div>
                                </div>
                            </div>
                            <div class="m-alert m-alert--outline m-alert--square alert alert-warning" role="alert">
                                <ol style="padding-left: 15px;">
                                    <li>File yang di upload adalah file .BAC</li>
                                    <li>Maksimal file size 10Mb</li>
                                </ol>
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

    <div class="modal fade" id="modalFilter" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 500px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Upload Backup Simak <span id="date"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> &times; </span>
                    </button>
                </div>
                <form enctype="multipart/form-data" class="m-form m-form--label-align-right" action="" method="GET">
                    <div class="modal-body">
                        @component('admin.components.form.alert') @endcomponent
                        <div class="m-form__section m-form__section--first">
                            @if(!$isBindBySatker)
                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label"> Satker </label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <select name="satker" class="form-control select2" style="width: 100%;">
                                            <option value="">Pilih Satker</option>
                                            @foreach($satker as $s)
                                            <option value="{{ $s->id }}" {!! $idSatker == $s->id ? 'selected="selected"' : '' !!}>{{ $s->name.' ('.$s->kode.')' }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label"> Tahun </label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input type="text" class="form-control text-center m-input yearInput" name="start" value="{{ $limit['startMonth'].'/'.$limit['start'] }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-center yearInput" name="end" value="{{ $limit['endMonth'].'/'.$limit['end'] }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> Tutup </button>
                        <a href="{{ route($config['route'] . '.downloadBatch') }}" class="btn btn-info m-btn m-btn--icon btn-batch-download">
                            <span>
                                <i class="la la-download"></i>
                                <span> Batch Download </span>
                            </span>
                        </a>
                        <button type="submit" class="btn btn-primary"> Filter  </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var date;

            $('#con-table-backup').on('click', '.data-download', function () {
                let id = $(this).data('id');

                window.location = '{{ route($config['route'].'.download') }}/'+id;
            });

            $('#con-table-backup').on('click', '.data-upload', function () {
                date = $(this).data('date');
                let dateFormat = moment(date, "M-YYYY");

                $('#modalUpload #date').html(dateFormat.format('MMMM YYYY'));
                $('#modalUpload').modal('show');
            });

            $('.btn-batch-download').click(function () {
                let url = $(this).attr('href');
                let form = $(this).closest('form');

                window.location = url+'?'+form.serialize();

                return false;
            });

            $('#con-table-backup').on('click', '.data-delete', function () {
                let id = $(this).data('id');
                let url = '{{ route($config['route'] . '.delete') }}/'+id;

                date = $(this).data('date');
                let dateFormat = moment(date, "M-YYYY");

                swal({
                    title: 'Apakah kamu yakin?',
                    text: "Data backup pada bulan "+dateFormat.format('MMMM YYYY')+" akan di hapus!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }).then(function(result) {
                    if (result.value) {
                        swal({
                            title : 'Loading',
                            html : '<img src="'+baseUrl+'/assets/app/media/img/load.gif" width="46px" />',
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });

                        $.post(url, { _method: 'DELETE'}, function(res){
                            if(res.status){
                                swal({
                                    title: 'Berhasil!',
                                    text: 'Data berhasil dihapus.',
                                    type: 'success',
                                    timer: 2000
                                });
                                let con = $('img[data-date="'+date+'"]').closest('td');
                                con.html('<img class="tooltips data-upload" data-date="'+date+'" title="Klik untuk Unggah Berkas .BAC" width="20px" src="{{ asset('assets/app/media/img/icon/icon_upload.png') }}" />');

                                $('.tooltips', con).tooltip({html: true});
                            }else{
                                swal(
                                    'Gagal',
                                    'Something went wrong.',
                                    'error'
                                );
                            }
                        }, 'json').fail(function() {
                            swal(
                                'Gagal!',
                                'Something went wrong.',
                                'error'
                            );
                        });
                    }
                });
            });

            var customCallback = function(res, statusText, xhr, form) // Callback form success
            {
                var alertError = $('.alert-error', options.form);
                var alertValidation = $('.alert-validation-backend', options.form);

                if(res.status == 1){ // Jika respond status bernilai benar
                    $('#modalUpload').modal('hide');

                    let con = $('img[data-date="'+date+'"]').closest('td');
                    con.html('<img class="tooltips data-download" data-id="'+res.id+'" data-date="'+date+'" title="Upload at '+res.date+'<br> '+res.user.name+' ('+res.user.nip+')" width="20px" src="{{ asset('assets/app/media/img/icon/icon_download.png') }}" />' +
                        ' <img class="tooltips data-upload" data-date="'+date+'" title="Klik untuk Unggah Berkas .BAC" width="20px" src="{{ asset('assets/app/media/img/icon/icon_reupload.png') }}" />' +
                        ' <img class="tooltips data-delete" data-id="'+res.id+'" data-date="'+date+'" title="Klik untuk hapus data" width="20px" src="{{ asset('assets/app/media/img/icon/icon_trash.png') }}" />');

                    $('.tooltips', con).tooltip({html: true});

                    var content = {};
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
                }else if(res.status == 0){ // Error Gagal
                    alertError.removeClass('m--hide').show();
                    $('.m-alert__text', alertError).html(res.message);
                    mApp.scrollTo(alertError, -200);
                }else if(res.status == 2) { // Error Validasi
                    alertValidation.removeClass('m--hide').show();
                    $('.m-alert__text', alertValidation).html(res.message);
                    mApp.scrollTo(alertValidation, -200);
                }

                mApp.unblock(options.form);
            };

            var options = {
                form: '#form-upload',
                data: {
                    'date': function () {
                        return date;
                    }
                }
            };

            var alertError = $('.alert-error', options.form);
            var optionsAjax = {
                data:           options.data,
                dataType:       options.dataType,
                success:        customCallback, // Callback jika form success
                error:          function (xhr, statusText, thrown) {
                    alertError.removeClass('m--hide').show();
                    mApp.unblock(options.form);
                }
            };
            $(options.form).ajaxForm(optionsAjax);

            $('.tooltips').tooltip({html: true});
            $('.yearInput').datepicker({
                format: "m/yyyy",
                viewMode: "months",
                minViewMode: "months"
            });
            $('.select2').select2();
        });
    </script>
    @endpush
