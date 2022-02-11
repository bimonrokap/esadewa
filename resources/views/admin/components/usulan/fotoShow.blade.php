<div class="con-image gallery-con-image">
    @foreach($fotos as $foto)
        @php
            if(isset($param)){
                switch ($param['type']) {
                    case 'sewa':
                        $usulan = 'sewa';
                        $imgLocation = \App\Model\Sewa\SewaFoto::imageLocation($data->id, $foto->foto, true);
                        break;
                    case 'bongkaran':
                        $usulan = 'bongkaran';
                        $imgLocation = \App\Model\Bongkaran\BongkaranFoto::imageLocation($data->id, $foto->foto, true);
                        break;
                    case 'pengadaan-penawaran':
                        $usulan = 'pengadaan-penawaran';
                        $imgLocation = \App\Model\Pengadaan\Usulan\PengadaanPenawaranFoto::imageLocation($data, $foto->foto, true);
                        break;
                    case 'pengadaan-renovasi':
                        $usulan = 'pengadaan-renovasi';
                        $imgLocation = \App\Model\Pengadaan\Usulan\PengadaanRenovasiFoto::imageLocation($data->id, $foto->foto, true);
                        break;
                }
            } else {
                $usulan = 'penjualan';
                $imgLocation = \App\Model\Penjualan\PenjualanFoto::imageLocation($data->id, $foto->foto, true);
            }

        @endphp

        <div>
            <a class="image" href="{{ $imgLocation }}">
                <img src="{{ $imgLocation }}" />
            </a>

            @if(isset($edit))
                <a href="{{ route($config['route'] . '.imageDelete', ['id' => $foto->id, 'type' => 'edit', 'usulan' => $usulan]) }}" class="btn btn-danger btn-delete-foto btn-xs m-btn m-btn--icon m-btn--icon-only tooltips" title="Hapus Gambar" style="width: 100% !important;">
                    <i class="la la-trash"></i>
                </a>
            @endif
        </div>
    @endforeach
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            let galleryImage = $('.gallery-con-image');
            galleryImage.on('click', '.btn-view', function () {
                let index = $(this).closest('div.col-md-3').index();
                $(this).closest('.gallery-image').magnificPopup('open', index);

                return false;
            });

            galleryImage.magnificPopup({
                delegate: 'a.image',
                mainClass: 'mfp-fade',
                removalDelay: 300,
                type: 'image',
                gallery: {
                    enabled: true
                }
            });

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