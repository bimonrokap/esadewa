<div class="modal fade" id="modalLaporBmn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 1000px" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Lapor BMN </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"> &times; </span>
                </button>
            </div>
            <form enctype="multipart/form-data" class="m-form m-form--label-align-right" action="{{ route('admin.lapor.store') }}" method="POST" id="form-lapor-bmn">
                <input type="hidden" name="id" />
                <input type="hidden" name="category_asset" />
                <div class="modal-body">
                    @component('admin.components.form.alert') @endcomponent
                    <input type="hidden" value="{{ $uuid }}" name="uuid">
                    <div class="m-form__section m-form__section--first">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-12" id="con-detail-aset">
                                <table class="table table-bordered m-table m-table--head-bg-metal table-detail-aset">
                                    <thead>
                                        <tr><th colspan="4" class="text-center" style="font-size: 1.5rem;">Detail Asset</th></tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-2 col-form-label"> Jenis Lapor </label>
                            <div class="col-lg-3">
                                <select name="jenis" class="form-control m-input required" style="width: 100%">
                                    <option value="1"> Permasalahan Umum </option>
                                    <option value="2"> Force Majeure </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-2 col-form-label"> Uraian </label>
                            <div class="col-lg-8">
                                <textarea name="uraian" class="form-control m-input required" rows="6" placeholder="Uraian"></textarea>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-2 col-form-label"> File </label>
                            <div class="col-lg-8">
                                <div class="custom-file">
                                    <input name="file" type="file" accept="application/pdf" class="custom-file-input">
                                    <label class="custom-file-label"> Pilih File </label>
                                </div>
                                <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-2 col-form-label"> Foto </label>
                            <label class="col-lg-8">
                                <div class="m-dropzone dropzone m-dropzone--success" action="{{ route('admin.lapor.imageUpload', ['id' => $uuid]) }}" id="m-dropzone-three">
                                    <div class="m-dropzone__msg dz-message needsclick">
                                        <h3 class="m-dropzone__msg-title"> Letakkan file disini atau klik untuk upload. </h3>
                                        <span class="m-dropzone__msg-desc"> Hanya file gambar yang diperbolehkan untuk diupload </span>
                                    </div>
                                </div>
                            </label>
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

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var options = {
                'form' : '#form-lapor-bmn'
            };

            FormValidation.init(options, function(res, statusText, xhr, form) // Callback form success
            {
                let alertError = $('.alert-error', options.form);
                let alertValidation = $('.alert-validation-backend', options.form);
                if(res.status === 1){ // Jika respond status bernilai benar

                    $('#modalLaporBmn').modal('hide');

                    swal({
                        title: 'Berhasil!',
                        text: res.message,
                        type: 'success',
                        timer: 2000
                    });

                }else if(res.status === 0){ // Error Gagal
                    alertError.removeClass('m--hide').show();
                    $('.m-alert__text', alertError).html(res.message);
                    mApp.scrollTo(alertError, -200);
                }else if(res.status === 2) { // Error Validasi
                    alertValidation.removeClass('m--hide').show();
                    $('.m-alert__text', alertValidation).html(res.message);
                    mApp.scrollTo(alertValidation, -200);
                }

                mApp.unblock(options.form);
            });

            let dropzoneFoto = new Dropzone("div#m-dropzone-three", {
                paramName: "file",
                maxFilesize: 3,
                addRemoveLinks: !0,
                acceptedFiles: ".png,.jpeg,.jpg",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            });

            dropzoneFoto.on("success", function (file, response) {
                $(file.previewElement).find(".dz-remove").attr("data-dz-remove", response.id);
            });

            dropzoneFoto.on("removedfile", function (file, response) {
                let id = $(file.previewElement).find(".dz-remove").attr("data-dz-remove");

                $.post("{{ route('admin.lapor.imageDelete') }}/"+id, { _method: 'DELETE'}, function(res){
                    if(res.status){
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
            });

            dropzoneFoto.on("error", function (file, response) {
                if(file.accepted === true) {
                    $(file.previewElement).fadeOut(1000, function() { $(this).remove(); });

                    $.notify(response.message, {
                        type: "danger",
                        allow_dismiss: true,
                        timer: 1000,
                        delay: 3000,
                        z_index: 1051,
                        animate: {
                            enter: 'animated bounceIn',
                            exit: 'animated bounceOut'
                        }
                    });
                } else {
                    $(file.previewElement).fadeOut(1000, function() { $(this).remove(); });

                    $.notify("File yang diupload melebihi batas maximal.", {
                        type: "danger",
                        allow_dismiss: true,
                        timer: 1000,
                        delay: 3000,
                        z_index: 1051,
                        animate: {
                            enter: 'animated bounceIn',
                            exit: 'animated bounceOut'
                        }
                    });
                }
            });
        });
    </script>
    @endpush