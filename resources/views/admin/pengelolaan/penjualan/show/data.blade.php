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
            <label for="inputTotalNilai"> Total Nilai Limit </label>
            <p class="form-control-static">Rp. {{ numberFormatIndo($data->total_limit) }}</p>
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
        <div class="form-group m-form__group">
            <label> Surat Pengajuan Satuan Kerja </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Surat Pengajuan Satuan Kerja', 'type' => 'pdf', 'url' => \App\Model\Penjualan\Penjualan::docLocation($data->id, $data->surat_pengajuan_satker, true)])
            </p>
        </div>
    </div>
</div>
<hr class="spar">
<div class="m-form-custom-5 row">
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label>BA Hasil Penelitian dan Pemeriksaan </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'BA Hasil Penelitian dan Pemeriksaan', 'type' => 'pdf', 'url' => \App\Model\Penjualan\Penjualan::docLocation($data->id, $data->ba_hasil, true)])
            </p>
        </div>
        <div class="form-group m-form__group">
            <label>Surat Pernyataan Tanggung Jawab Atas Harga Taksiran </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Surat Pernyataan Tanggung Jawab Atas Harga Taksiran', 'type' => 'pdf', 'url' => \App\Model\Penjualan\Penjualan::docLocation($data->id, $data->surat_pernyataan_tanggung, true)])
            </p>
        </div>
        <div class="form-group m-form__group">
            <label>Simak BMN </label>
            @if($backupSimak === null)
                <p class="form-control-static">
                    @include('components.form.fileButton', ['title' => 'Simak BMN', 'type' => 'file', 'url' => \App\Model\Penjualan\Penjualan::docLocation($data->id, $data->backup_simak, true)])
                </p>
            @else
                <p class="form-control-static">
                    @include('components.form.fileButton', ['title' => 'Simak BMN', 'type' => 'file', 'url' => route("admin.monitoring.simak.download", $backupSimak->id)])
                </p>
            @endif
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label> SK Panitia Penghapusan </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'SK Panitia Penghapusan', 'type' => 'pdf', 'url' => \App\Model\Penjualan\Penjualan::docLocation($data->id, $data->sk_panitia_penghapusan, true)])
            </p>
        </div>
        <div class="form-group m-form__group">
            <label>Daftar Penghentian Penggunaan </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Daftar Penghentian Penggunaan', 'type' => 'pdf', 'url' => \App\Model\Penjualan\Penjualan::docLocation($data->id, $data->daftar_penghentian, true)])
            </p>
        </div>
        <div class="form-group m-form__group">
            <label>SK Penetapan Status Penggunaan atas barang yang akan diusulkan Penghapusan </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'SK Penetapan Status Penggunaan atas barang yang akan diusulkan Penghapusan', 'type' => 'pdf', 'url' => \App\Model\Penjualan\Penjualan::docLocation($data->id, $data->sk_penetapan_status, true)])
            </p>
        </div>
    </div>
</div>