<div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Import Data </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"> &times; </span>
                </button>
            </div>
            <form enctype="multipart/form-data" class="m-form m-form--label-align-right" action="{{ route('admin.asset.import', $importSlug) }}" method="POST" id="form-import">
                <div class="modal-body">
                    @component('admin.components.form.alert') @endcomponent
                    <div class="m-form__section m-form__section--first">
                        <div class="form-group m-form__group row">
                            <label class="col-lg-2 col-form-label"> File </label>
                            <div class="col-lg-10">
                                <div class="custom-file">
                                    <input name="file" type="file" class="custom-file-input required" id="file">
                                    <label class="custom-file-label" for="file"> Pilih File </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-10">
                                <div class="m-alert m-alert--outline m-alert--square alert alert-warning" role="alert">
                                    <ol style="padding-left: 15px;">
                                        <li>Sample file Import <a href="">File</a> </li>
                                        <li>File yang di import harus berekstensi xlsx</li>
                                        <li>Harap mencocokkan format sample seperti jumlah header, posisi header dan posisi header terlebih dahulu.</li>
                                        <li>Kesalahan pada import file akan mengakibatkan rusaknya data asset.</li>
                                        <li>Jika terdapat kerusakaan pada data asset, user dapat mengembalikan data asset dengan memilih data asset yang sebelumnya pernah di upload.</li>
                                        <li>Jika data asset terlalu besar maka data akan di proses di esok hari jam 00.01.</li>
                                    </ol>
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

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var options = {
                'form' : '#form-import'
            };

            FormValidation.init(options, function(res, statusText, xhr, form) // Callback form success
            {
                let alertError = $('.alert-error', options.form);
                let alertValidation = $('.alert-validation-backend', options.form);
                if(res.status === 1){ // Jika respond status bernilai benar
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

                mApp.unblock(options.form);
            });
        });
    </script>
    @endpush