@extends('template.admin.content')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-plus"></i>
                            </span>
                            <h3 class="m-portlet__head-text"> Usulan {{ $config['pageTitle'] }}</h3>
                        </div>
                    </div>
                </div>
                <form class="m-form m-form--label-align-right" action="{{ route($config['route'] . '.store') }}" method="POST" id="form">
                    {{ csrf_field() }}
                    <div class="m-portlet__body">
                        @component('admin.components.form.alert') @endcomponent
                        <input type="hidden" value="{{ $uuid }}" name="uuid">
                        <div class="m-form__section m-form__section--first">
                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label"> Kategori Aset <span class="required">*</span> </label>
                                <div class="col-lg-3">
                                    <select name="category_asset" class="form-control m-input select2 required" style="width: 100%">
                                        <option value=""> Pilih Aset </option>
                                        @foreach($categoryAsset as $row)
                                            <option value="{{ $row->id }}"> {{ $row->name }} </option>
                                            @endforeach
                                    </select>
                                </div>
                                <label class="col-lg-2 col-form-label"> Jenis Lapor <span class="required">*</span> </label>
                                <div class="col-lg-3">
                                    <select name="jenis" class="form-control m-input select2 required" style="width: 100%">
                                        <option value="1"> Permasalahan Umum </option>
                                        <option value="2"> Force Majeure </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label"> Uraian <span class="required">*</span> </label>
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
                                    <div class="m-dropzone dropzone m-dropzone--success" action="{{ route($config["route"] . '.imageUpload', ['id' => $uuid]) }}" id="m-dropzone-three">
                                        <div class="m-dropzone__msg dz-message needsclick">
                                            <h3 class="m-dropzone__msg-title"> Letakkan file disini atau klik untuk upload. </h3>
                                            <span class="m-dropzone__msg-desc"> Hanya file gambar yang diperbolehkan untuk diupload </span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route($config['route'] . '.index') }}" id="reload" class="ajaxify" style="display: none;"></a>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button type="submit" class="btn btn-success"> Simpan </button>
                                    <a href="{{ route($config['route'] . '.index') }}" class="ajaxify"> <button type="button" class="btn btn-secondary"> Kembali </button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection

@push('scripts')
    <script src="{{ asset('assets/app/js/datatable.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2').select2();

            var options = {
                'form' : '#form'
            };

            FormValidation.init(options);

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

                $.post("{{ route($config["route"] . '.imageDelete') }}/"+id, { _method: 'DELETE'}, function(res){
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