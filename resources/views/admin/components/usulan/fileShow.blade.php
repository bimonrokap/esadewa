<div class="con-image">
    @foreach($files as $file)
        @php
            $imgLocation = asset('assets/app/media/img/icon/pdf_125.png');
            if(isset($param)){
                switch ($param['type']) {
                    case 'pengadaan-renovasi-eksisting':
                        $usulan = 'pengadaan-renovasi-eksisting';
                        $fileLocation = \App\Model\Pengadaan\Usulan\PengadaanRenovasiGambar::imageLocation($data->id, $file->file, true);
                        break;
                    case 'pengadaan-renovasi-rencana':
                        $usulan = 'pengadaan-renovasi-rencana';
                        $fileLocation = \App\Model\Pengadaan\Usulan\PengadaanRenovasiGambar::imageLocation($data->id, $file->file, true);
                        break;
                }
            } else {
                $usulan = 'pengadaan-pembangunan';
                $fileLocation = \App\Model\Pengadaan\Usulan\PengadaanPembangunanGambar::imageLocation($data->id, $file->file, true);
            }

        @endphp

        <div>
            <a class="image" target="_blank" href="{{ $fileLocation }}">
                <img src="{{ $imgLocation }}" />
            </a>
            <span style="display: block;padding: 3px;text-align: center;"><strong>{{ substr(substr($file->file, 11, -1), 0, 25) }}</strong></span>

            @if(isset($edit))
                <a href="{{ route($config['route'] . '.fileDelete', ['id' => $file->id, 'type' => 'edit', 'usulan' => $usulan]) }}" class="btn btn-danger btn-delete-foto btn-xs m-btn m-btn--icon m-btn--icon-only tooltips" title="Hapus Gambar" style="width: 100% !important;">
                    <i class="la la-trash"></i>
                </a>
            @endif
        </div>
    @endforeach
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            $('.con-image a.btn-delete-foto').click(function () {
                let url = $(this).attr('href');
                let ele = $(this);

                swal({
                    title: 'Apakah kamu yakin?',
                    text: "Data akan di hapus!",
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

                                ele.closest('div').remove();
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

                return false;
            });
        })
    </script>
    @endpush