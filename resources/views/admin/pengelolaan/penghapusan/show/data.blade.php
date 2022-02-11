<div class="m-form-custom-5 row">
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label> No Surat Pengajuan Satker </label>
            <p class="form-control-static">{{ $data->letter_number }}</p>
        </div>
        <div class="form-group m-form__group">
            <label> Penandatanganan Surat </label>
            <p class="form-control-static">{{ $data->penandatanganSurat->name }}</p>
        </div>
        <div class="form-group m-form__group">
            <label> Surat Pengajuan Satuan Kerja </label>
            @if($data->surat_pengajuan_satker != null)
                <p class="form-control-static">
                    @include('components.form.fileButton', ['title' => 'Surat Pengajuan Satuan Kerja', 'type' => 'pdf', 'url' => \App\Model\Penghapusan\Penghapusan::docLocation($data->id, $data->surat_pengajuan_satker, true)])
                </p>
            @endif
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label> Tanggal Surat </label>
            <p class="form-control-static">{{ \Carbon\Carbon::parse($data->letter_date)->format('j F Y') }}</p>
        </div>
        <div class="form-group m-form__group">
            <label> Perihal Surat </label>
            <p class="form-control-static">{!! nl2br($data->perihal) !!}</p>
        </div>
    </div>
</div>
<hr class="spar">

<div class="m-form-custom-5 row">
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label for="selectLetterNumberPenjualan"> No Surat Izin Penjualan </label>
            <p class="form-control-static">{{ $isMebelair ? $data->penjualan->letter_number : $data->letter_number_penjualan }}</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputPerihalSuratPenjualan"> Perihal Surat Izin Penjualan </label>
            <p class="form-control-static">{{ nl2br($isMebelair ? $data->penjualan->perihal : $data->perihal_penjualan) }}</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputTotalNilai"> Total Nilai Limit </label>
            <p class="form-control-static">Rp {{ numberFormatIndo($isMebelair ? $data->penjualan->total_limit : $data->total_limit) }}</p>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label for="inputLetterDatePenjualan"> Tanggal Surat Izin Penjualan </label>
            <p class="form-control-static">{{ \Carbon\Carbon::parse($isMebelair ? $data->penjualan->letter_date : $data->letter_date_penjualan)->format('j F Y') }}</p>
        </div>
        <div class="form-group m-form__group">
            <label> Surat Izin Penjualan </label>
            @if($isMebelair)
                <p class="form-control-static">
                    @include('components.form.fileButton', ['title' => 'Surat Izin Penjualan', 'type' => 'pdf', 'url' => \App\Model\Penjualan\Penjualan::docLocation($data->id_letter_number_penjualan, $data->penjualan->surat_persetujuan, true)])
                </p>
            @else
                @if($data->surat_izin_penjualan != null)
                    <p class="form-control-static">
                        @include('components.form.fileButton', ['title' => 'Surat Izin Penjualan', 'type' => 'pdf', 'url' => \App\Model\Penghapusan\Penghapusan::docLocation($data->id, $data->surat_izin_penjualan, true)])
                    </p>
                @endif
            @endif
        </div>
        <div class="form-group m-form__group">
            <label for="inputNilaiPerolehan"> Nilai Perolehan </label>
            <p class="form-control-static">Rp {{ numberFormatIndo($isMebelair ? $nilaiPerolehan : $data->nilai_perolehan) }}</p>
        </div>
    </div>
</div>
<hr class="spar">

<div class="m-form-custom-5 row">
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label for="inputRisalahLelang"> No Risalah Lelang</label>
            <p class="form-control-static">{{ $data->risalah_lelang_number }}</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputPenandatangananRisalahLelang"> Penandatanganan Risalah Lelang</label>
            <p class="form-control-static">{{ $data->penandatangan_risalah }}</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputTanggalBeritaAcara"> Tanggal Berita Acara Serah Terima</label>
            <p class="form-control-static">{{ \Carbon\Carbon::parse($data->tanggal_berita_acara)->format('j F Y') }}</p>
        </div>
        <div class="form-group m-form__group">
            <label> Risalah Lelang </label>
            @if($data->risalah_lelang != null)
                <p class="form-control-static">
                    @include('components.form.fileButton', ['title' => 'Risalah Lelang', 'type' => 'pdf', 'url' => \App\Model\Penghapusan\Penghapusan::docLocation($data->id, $data->risalah_lelang, true)])
                </p>
            @else
                <p class="form-control-static"><i>Empty</i></p>
            @endif
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label for="inputTotalNilaiTerjual"> Total Nilai Terjual </label>
            <p class="form-control-static">Rp {{ numberFormatIndo($data->total_terjual) }}</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputRisalahLelangDate"> Tanggal Risalah Lelang </label>
            <p class="form-control-static">{{ \Carbon\Carbon::parse($data->risalah_lelang_date)->format('j F Y') }}</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputNomorBast"> Nomor Berita Acara Serah Terima </label>
            <p class="form-control-static">{{ $data->nomor_berita_acara }}</p>
        </div>
        <div class="form-group m-form__group">
            <label> Surat Berta Acara </label>
            @if($data->surat_berita_acara != null)
                <p class="form-control-static">
                    @include('components.form.fileButton', ['title' => 'Surat Berta Acara', 'type' => 'pdf', 'url' => \App\Model\Penghapusan\Penghapusan::docLocation($data->id, $data->surat_berita_acara, true)])
                </p>
            @endif
        </div>
    </div>
</div>
<hr class="spar">

<div class="m-form-custom-5 row">
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label> Daftar Barang yang Diusulkan </label>
            @if($data->daftar_barang != null)
                <p class="form-control-static">
                    @include('components.form.fileButton', ['title' => 'Daftar Barang yang Diusulkan', 'type' => 'pdf', 'url' => \App\Model\Penghapusan\Penghapusan::docLocation($data->id, $data->daftar_barang, true)])
                </p>
            @else
                <p class="form-control-static"><i>Empty</i></p>
            @endif
        </div>
        <div class="form-group m-form__group">
            <label> Dokumen Lainnya </label>
            @if($data->dokumen_lainnya != null)
                <p class="form-control-static">
                    @include('components.form.fileButton', ['title' => 'Dokumen Lainnya', 'type' => 'pdf', 'url' => \App\Model\Penghapusan\Penghapusan::docLocation($data->id, $data->dokumen_lainnya, true)])
                </p>
            @else
                <p class="form-control-static"><i>Empty</i></p>
            @endif
        </div>
    </div>
    <div class="col-lg-6">
        @if($isMebelair)
            <div class="form-group m-form__group">
                <label> Surat Keterangan </label>
                @if($data->surat_keterangan != null)
                    <p class="form-control-static">
                        @include('components.form.fileButton', ['title' => 'Surat Keterangan', 'type' => 'pdf', 'url' => \App\Model\Penghapusan\Penghapusan::docLocation($data->id, $data->surat_keterangan, true)])
                    </p>
                @endif
            </div>
        @endif
        <div class="form-group m-form__group">
            <label> Daftar Barang Rusak Berat </label>
            @if($data->daftar_barang_rusak != null)
                <p class="form-control-static">
                    @include('components.form.fileButton', ['title' => 'Daftar Barang Rusak Berat', 'type' => 'pdf', 'url' => \App\Model\Penghapusan\Penghapusan::docLocation($data->id, $data->daftar_barang_rusak, true)])
                </p>
            @endif
        </div>
    </div>
</div>