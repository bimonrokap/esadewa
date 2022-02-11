<div class="m-form-custom-5 row">
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label> Harga Penawaran (Include Biaya Sertifikat)  <span class="required">*</span> </label>
            <div class="input-group m-input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> Rp </span>
                </div>
                <input type="text" class="form-control m-input harga required" value="{{ $data->harga_penawaran }}" name="harga_penawaran[{{ $data->id }}]" placeholder="Harga Penawaran" />
            </div>
        </div>
        <div class="form-group m-form__group">
            <label> Luas Tanah <span class="required">*</span> </label>
            <div class="input-group m-input-group">
                <input type="text" class="form-control m-input harga required" value="{{ $data->luas_tanah }}" name="luas_tanah[{{ $data->id }}]" placeholder="Luas Tanah" />
                <div class="input-group-append">
                    <span class="input-group-text"> m<sup>2</sup> </span>
                </div>
            </div>
        </div>
        <div class="form-group m-form__group">
            <label> Sertipikat Tanah </label>
            <div class="custom-file">
                <input name="sertifikat[{{ $data->id }}]" type="file" accept="application/pdf" class="custom-file-input">
                <label class="custom-file-label"> Pilih File </label>
            </div>
            <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
            <p class="form-control-static"><a target="_blank" href="{{ \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($id, $data->sertifikat, true) }}">Sertipikat Tanah</a></p>
        </div>
        <div class="form-group m-form__group">
            <label> Surat Pernyataan Tidak Dalam Sengketa dari Pemilik tanah </label>
            <div class="custom-file">
                <input name="pernyataan[{{ $data->id }}]" type="file" accept="application/pdf" class="custom-file-input">
                <label class="custom-file-label"> Pilih File </label>
            </div>
            <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
            <p class="form-control-static"><a target="_blank" href="{{ \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($id, $data->pernyataan, true) }}">Surat Pernyataan Tidak Dalam Sengketa dari Pemilik tanah</a></p>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label> KTP Pemilik Tanah </label>
            <div class="custom-file">
                <input name="ktp[{{ $data->id }}]" type="file" accept="application/pdf" class="custom-file-input">
                <label class="custom-file-label"> Pilih File </label>
            </div>
            <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
            <p class="form-control-static"><a target="_blank" href="{{ \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($id, $data->ktp, true) }}">KTP Pemilik Tanah</a></p>
        </div>
        <div class="form-group m-form__group">
            <label> Surat Setoran Pajak (PBB, NJOP, Tahun Anggaran) </label>
            <div class="custom-file">
                <input name="pajak[{{ $data->id }}]" type="file" accept="application/pdf" class="custom-file-input">
                <label class="custom-file-label"> Pilih File </label>
            </div>
            <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
            <p class="form-control-static"><a target="_blank" href="{{ \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($id, $data->pajak, true) }}">Surat Setoran Pajak (PBB, NJOP, Tahun Anggaran)</a></p>
        </div>
        <div class="form-group m-form__group">
            <label> Surat Keterangan Harga Pasaran Setempat dari Camat/Apprisal </label>
            <div class="custom-file">
                <input name="surat_harga[{{ $data->id }}]" type="file" accept="application/pdf" class="custom-file-input">
                <label class="custom-file-label"> Pilih File </label>
            </div>
            <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
            <p class="form-control-static"><a target="_blank" href="{{ \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($id, $data->surat_harga, true) }}">Surat Keterangan Harga Pasaran Setempat dari Camat/Apprisal</a></p>
        </div>
        <div class="form-group m-form__group">
            <label> Surat Penawaran Harga dari Pemilik </label>
            <div class="custom-file">
                <input name="penawaran[{{ $data->id }}]" type="file" accept="application/pdf" class="custom-file-input">
                <label class="custom-file-label"> Pilih File </label>
            </div>
            <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
            <p class="form-control-static"><a target="_blank" href="{{ \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($id, $data->penawaran, true) }}">Surat Penawaran Harga dari Pemilik</a></p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <hr>
        <div class="m-dropzone dropzone m-dropzone--success" action="{{ route($config["route"] . '.imageUpload', isset($param) ? array_merge($param, ['id' => $uuid]) : ['id' => $uuid] ) }}" id="m-dropzone-{{ $class }}">
            <div class="m-dropzone__msg dz-message needsclick">
                <h3 class="m-dropzone__msg-title"> Letakkan file disini atau klik untuk upload. </h3>
                <span class="m-dropzone__msg-desc"> Hanya file gambar yang diperbolehkan untuk diupload </span>
            </div>
        </div>

        <div style="margin-top: 10px;">
            @component('admin.components.usulan.fotoShow', ['config' => $config, 'fotos' => $data->foto, 'data' => $id, 'param' => ['type' => 'pengadaan-penawaran'] , 'edit' => true]) @endcomponent
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        var id = {{ isset($id) ? (int)$id : 0  }};

        $(document).ready(function () {
            let dropzoneFoto = new Dropzone("div#m-dropzone-{{ $class }}", {
                paramName: "file",
                maxFilesize: 3,
                addRemoveLinks: !0,
                acceptedFiles: ".png,.jpeg,.jpg",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                params: function () {
                    return { 'aset': jmlBarang, 'id': id }
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
        })
    </script>
    @endpush