<a href="javascript:;" class="thumbnail" style="width: 500px;height: 250px;display: block;margin: auto;border: 1px solid #e0e0e0;padding: 5px;">
    <img src="{{ $preview }}" style='height: 100%; width: 100%; object-fit: contain;display: block; '>
</a>
<hr>
<form class="m-form m-form--fit m-form--label-align-right" style="margin-top: 30px;">
    <div class="form-group m-form__group row">
        <label class="col-md-2 col-form-label"> Kode Satker : </label>
        <div class="col-md-4">
            <p class="m-form__control-static">{{ $data->kode_satker }}</p>
        </div>
        <label class="col-md-2 col-form-label"> Nama Satker : </label>
        <div class="col-md-4">
            <p class="m-form__control-static">{{ $data->nama_satker }}</p>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label class="col-md-2 col-form-label"> Klasifikasi Pengadilan : </label>
        <div class="col-md-4">
            <p class="m-form__control-static">
                @switch($satker->satker_type)
                    @case('PUSAT') Pusat @break
                    @case('PA') Peradilan Agama @break
                    @case('PT') Peradilan Tata Usaha @break
                    @case('PN') Peradilan Umum @break
                    @case('PM') Peradilan Militer @break
                    @case('Lainnya') Lainnya @break
                @endswitch
            </p>
        </div>
        <label class="col-md-2 col-form-label"> Nama Asset : </label>
        <div class="col-md-4">
            <p class="m-form__control-static">{{ $data->nama_barang }}</p>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label class="col-md-2 col-form-label"> Kode Barang : </label>
        <div class="col-md-4">
            <p class="m-form__control-static">{{ $data->kode_barang }}</p>
        </div>
        <label class="col-md-2 col-form-label"> Nomor Aset/NUP : </label>
        <div class="col-md-4">
            <p class="m-form__control-static">{{ $data->nup }}</p>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label class="col-md-2 col-form-label"> Luas Bangunan : </label>
        <div class="col-md-4">
            <p class="m-form__control-static">{{ $data->luas_bangunan }} m<sup>2</sup></p>
        </div>
        <label class="col-md-2 col-form-label"> Jumlah Lantai : </label>
        <div class="col-md-4">
            <p class="m-form__control-static">{{ $data->jumlah_lantai }}</p>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label class="col-md-2 col-form-label"> Lokasi : </label>
        <div class="col-md-4">
            <p class="m-form__control-static">{{ $data->alamat . ', ' . $data->kabupaten }}</p>
        </div>
        <label class="col-md-2 col-form-label"> Nilai : </label>
        <div class="col-md-4">
            <p class="m-form__control-static">{{ 'Rp '.numberFormatIndo($data->nilai_perolehan) }}</p>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label class="col-md-2 col-form-label"> Kondisi : </label>
        <div class="col-md-4">
            <p class="m-form__control-static">{{ $data->kondisi }}</p>
        </div>
        <label class="col-md-2 col-form-label"> Tanggal dan Nomor PSP : </label>
        <div class="col-md-4">
            <p class="m-form__control-static">{{ in_array($data->tgl_psp, [null, 'null']) ? '' : \Carbon\Carbon::parse($data->tgl_psp)->format('j F Y') . ', ' . $data->no_psp }}</p>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label class="col-md-2 col-form-label"> Bukti Kepemilikan : </label>
        <div class="col-md-4">
            <p class="m-form__control-static">
                @if( @$variables['bukti_kepemilikan']->value != null)
                    <a target="_blank" href="{{ route('admin.asset.file', ['slug' => 'bukti_kepemilikan', 'id' => $idAsset]) }}">Bukti Kepemilikan</a>
                @endif
            </p>
        </div>
        <label class="col-md-2 col-form-label"> Status Penggunaan : </label>
        <div class="col-md-4">
            <p class="m-form__control-static"> {{ $data->status_penggunaan }} </p>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label class="col-md-2 col-form-label"> Status Pengelolaan : </label>
        <div class="col-md-4">
            <p class="m-form__control-static"> {{ $data->status_pengelolaan }} </p>
        </div>
        <label class="col-md-2 col-form-label"> Status Hukum : </label>
        <div class="col-md-4">
            <p class="m-form__control-static"> {{ @$variables['status_hukum']->value }}  </p>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label class="col-md-2 col-form-label"> Tanggal Terakhir Upload Data : </label>
        <div class="col-md-4">
            <p class="m-form__control-static"> {{ $data->tanggal_update == null ? '' : \Carbon\Carbon::parse($data->tanggal_update)->format('j F Y') }} </p>
        </div>
        <label class="col-md-2 col-form-label"> GPS : </label>
        <div class="col-md-4">
            <p class="m-form__control-static">
                @if( @$variables['koordinat']->value != null)
                    <a target="_blank" href="https://www.google.com/maps/{{ '@'.@$variables['koordinat']->value }},15z">{{ @$variables['koordinat']->value }}</a>
                @endif
            </p>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(document).ready(function () {
        $(".thumbnail").click(function() {
            $.fancybox.open({!! json_encode($images) !!}, {
                animationEffect: "zoom-in-out"
            });
        });
    });
</script>