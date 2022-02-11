<div class="m-form-custom-5 row">
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label for="inputTanggalPerjanjian"> Tanggal Pembayaran </label>
            <p class="form-control-static">{{ \Carbon\Carbon::parse($data->tanggal_pembayaran)->format('j F Y') }}</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputNomorNtb"> Nomor NTB </label>
            <p class="form-control-static">{{ $data->nomor_ntb }}</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputJumlahPembayaran"> Jumlah Pembayaran </label>
            <p class="form-control-static">Rp {{ numberFormatIndo($data->jumlah_pembayaran) }}</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputNomorPerjanjian"> Nomor Perjanjian </label>
            <p class="form-control-static">{{ $data->nomor_perjanjian }}</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputPeriodePerjanjian"> Periode Perjanjian </label>
            <p class="form-control-static">{{ $data->periode_perjanjian }} Bulan</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputNilaiPerjanjianSewa"> Nilai Perjanjuan Sewa </label>
            <p class="form-control-static">{{ $data->nilai_perjanjian_sewa }}</p>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label for="inputAkunPembayaran"> Akun Pembayaran </label>
            <p class="form-control-static">{{ $data->akun_pembayaran }}</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputNomorNtpn"> Nomor NTPN </label>
            <p class="form-control-static">{{ $data->nomor_ntpn }}</p>
        </div>
        <div class="form-group m-form__group">
            <label> Bukti Pembayaran</label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Bukti Pembayaran', 'type' => 'pdf', 'url' => \App\Model\Sewa\Sewa::docLocation($data->id, $data->bukti_pembayaran, true)])
            </p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputTanggalPerjanjian"> Tanggal Perjanjian </label>
            <p class="form-control-static">{{ \Carbon\Carbon::parse($data->tanggal_perjanjian)->format('j F Y') }}</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputJatuhTempo"> Tanggal Jatuh Tempo </label>
            <p class="form-control-static">{{ \Carbon\Carbon::parse($data->tanggal_jatuh_tempo)->format('j F Y') }}</p>
        </div>
        <div class="form-group m-form__group">
            <label> Surat Perjanjian Sewa</label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Surat Perjanjian Sewa', 'type' => 'pdf', 'url' => \App\Model\Sewa\Sewa::docLocation($data->id, $data->surat_perjanjian_sewa, true)])
            </p>
        </div>
    </div>
</div>