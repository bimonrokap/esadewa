<div class="m-dropzone dropzone m-dropzone--success" action="{{ route($config["route"] . '.fileUpload', isset($param) ? array_merge($param, ['id' => $uuid]) : ['id' => $uuid] ) }}" id="m-dropzone-{{ $param['type'] }}">
    <div class="m-dropzone__msg dz-message needsclick">
        <h3 class="m-dropzone__msg-title"> Letakkan file disini atau klik untuk upload. </h3>
        <span class="m-dropzone__msg-desc"> Hanya file {{ $ext }} yang diperbolehkan untuk diupload </span>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        var id = {{ isset($id) ? (int)$id : 0  }};

        $(document).ready(function () {
            let dropzoneFoto = new Dropzone("div#m-dropzone-{{ $param['type'] }}", {
                paramName: "file",
                maxFilesize: {{ $maxFileSize }},
                addRemoveLinks: !0,
                acceptedFiles: "{{ $ext }}",
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

            dropzoneFoto.on('addedfile', function(file) {

                var ext = file.name.split('.').pop();
                console.log(ext);

                if (ext === "pdf") {
                    $(file.previewElement).find(".dz-image img").attr("src", baseUrl+"/assets/app/media/img/icon/pdf_125.png");
                }
            });

            dropzoneFoto.on("removedfile", function (file, response) {
                let id = $(file.previewElement).find(".dz-remove").attr("data-dz-remove");

                $.post("{{ route($config["route"] . '.fileDelete') }}/"+id, { _method: 'DELETE'}, function(res){
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