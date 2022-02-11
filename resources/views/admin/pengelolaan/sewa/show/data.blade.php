<div class="m-form-custom-5 row">
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label for="inputLetterNumber"> No Surat Pengajuan Satker </label>
            <p class="form-control-static">{{ $data->letter_number }}</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputPenandatangananSurat"> Penandatanganan Surat </label>
            <p class="form-control-static">{{ $data->penandatanganSurat->name }}</p>
        </div>
        <div class="form-group m-form__group">
            <label> Surat Pengajuan Satuan Kerja  </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Surat Pengajuan Satuan Kerja', 'type' => 'pdf', 'url' => \App\Model\Sewa\Sewa::docLocation($data->id, $data->surat_pengajuan_satker, true)])
            </p>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label for="inputLetterDate"> Tanggal Surat </label>
            <p class="form-control-static">{{ \Carbon\Carbon::parse($data->letter_date)->format('j F Y') }}</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputPerihalSurat"> Perihal Surat </label>
            <p class="form-control-static">{!! nl2br($data->perihal) !!}</p>
        </div>
    </div>
</div>
<hr class="spar">
<div class="m-form-custom-5 row">
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label for="inputLetterNumberPersetujuan"> No Surat Persetujuan Sewa Pengelola Barang  </label>
            <p class="form-control-static">{{ $data->no_surat_persetujuan }}</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputPerihalSuratPersetujuan"> Perihal Surat Persetujuan Sewa Pengelola Barang  </label>
            <p class="form-control-static">{!! nl2br($data->perihal_surat_persetujuan) !!}</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputPenandatangananSuratPersetujuan"> Penandatanganan Persetujuan Sewa Pengelola Barang  </label>
            <p class="form-control-static">{{ $data->penandatangan_persetujuan }}</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputNilaiSewa"> Nilai Sewa  </label>
            <p class="form-control-static">Rp {{ numberFormatIndo($data->nilai_sewa) }}</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputJenisBmn"> Jenis BMN yang disewa  </label>
            <p class="form-control-static">{{ $data->category->pluck('name')->implode(', ') }}</p>
        </div>
        <div class="form-group m-form__group">
            <label> Surat Rekomendasi Persetujuan Sewa dari Pengelola Barang  </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Surat Rekomendasi Persetujuan Sewa dari Pengelola Barang', 'type' => 'pdf', 'url' => \App\Model\Sewa\Sewa::docLocation($data->id, $data->surat_rekomendasi, true)])
            </p>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label for="inputLokasi"> Lokasi  </label>
            <p class="form-control-static">{!! nl2br($data->lokasi) !!}</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputLetterDatePersetujuan"> Tanggal Persetujuan Sewa Pengelola Barang  </label>
            <p class="form-control-static">{{ \Carbon\Carbon::parse($data->tanggal_surat_persetujuan)->format('j F Y') }}</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputPeriodeSewa"> Periode Sewa  </label>
            <p class="form-control-static">{{ $data->periode }} Bulan</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputLuasAsset"> Luas / Unit Aset yang disewa  </label>
            <p class="form-control-static">{{ numberFormatIndo($data->luas_asset, 3) }} m<sup>2</sup></p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputIdentitasPenyewa"> Identitas Penyewa  </label>
            <p class="form-control-static">{{ $data->identitas_penyewa }} </p>
        </div>
    </div>
</div>