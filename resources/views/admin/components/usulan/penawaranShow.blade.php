<div class="m-form-custom-5 row">
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label> Harga Penawaran (Include Biaya Sertifikat) </label>
            <p class="form-control-static">Rp {{ numberFormatIndo($data->harga_penawaran) }}</p>
        </div>
        <div class="form-group m-form__group">
            <label> Luas Tanah </label>
            <p class="form-control-static">{{ numberFormatIndo($data->luas_tanah) }} m<sup>2</sup></p>
        </div>
        <div class="form-group m-form__group">
            <label> Sertipikat Tanah </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Sertipikat Tanah', 'type' => 'pdf', 'url' => \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($data->id, $data->sertifikat, true)])
            </p>
        </div>
        <div class="form-group m-form__group">
            <label> Surat Pernyataan Tidak Dalam Sengketa dari Pemilik tanah </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Surat Pernyataan Tidak Dalam Sengketa dari Pemilik tanah', 'type' => 'pdf', 'url' => \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($data->id, $data->pernyataan, true)])
            </p>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label> KTP Pemilik Tanah </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'KTP Pemilik Tanah', 'type' => 'pdf', 'url' => \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($data->id, $data->ktp, true)])
            </p>
        </div>
        <div class="form-group m-form__group">
            <label> Surat Setoran Pajak (PBB, NJOP, Tahun Anggaran) </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Surat Setoran Pajak (PBB, NJOP, Tahun Anggaran)', 'type' => 'pdf', 'url' => \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($data->id, $data->pajak, true)])
            </p>
        </div>
        <div class="form-group m-form__group">
            <label> Surat Keterangan Harga Pasaran Setempat dari Camat/Apprisal </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Surat Penawaran Harga dari Pemilik', 'type' => 'pdf', 'url' => \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($data->id, $data->surat_harga, true)])
            </p>
        </div>
        <div class="form-group m-form__group">
            <label> Surat Penawaran Harga dari Pemilik </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Surat Penawaran Harga dari Pemilik', 'type' => 'pdf', 'url' => \App\Model\Pengadaan\Usulan\Pengadaan::docLocation($data->id, $data->penawaran, true)])
            </p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <hr>
        <div style="margin-top: 10px;">
            @component('admin.components.usulan.fotoShow', ['config' => $config, 'fotos' => $data->foto, 'data' => $id, 'param' => ['type' => 'pengadaan-penawaran']]) @endcomponent
        </div>
    </div>
</div>