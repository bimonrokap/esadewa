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
                @include('components.form.fileButton', ['title' => 'Surat Pengajuan Satuan Kerja', 'type' => 'pdf', 'url' => \App\Model\Bongkaran\Bongkaran::docLocation($data->id, $data->surat_pengajuan_satker, true)])
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
            <label for="inputSumberDanaRenovasi"> Sumber Dana Renovasi </label>
            <p class="form-control-static">{{ $data->sumberDana->name }}</p>
        </div>
        <div class="form-group m-form__group">
            <label> Penetapan Status Penggunaan </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Penetapan Status Penggunaan', 'type' => 'pdf', 'url' => \App\Model\Bongkaran\Bongkaran::docLocation($data->id, $data->penetapan_status_penggunaan, true)])
            </p>
        </div>
        <div class="form-group m-form__group">
            <label> SK Panitia Bongkaran</label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'SK Panitia Bongkaran', 'type' => 'pdf', 'url' => \App\Model\Bongkaran\Bongkaran::docLocation($data->id, $data->sk_panitia_bongkaran, true)])
            </p>
        </div>
        <div class="form-group m-form__group">
            <label> Surat Penetapan Nilai Taksiran Bongkaran</label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Surat Penetapan Nilai Taksiran Bongkaran', 'type' => 'pdf', 'url' => \App\Model\Bongkaran\Bongkaran::docLocation($data->id, $data->penetapan_nilai_taksiran, true)])
            </p>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label for="inputNilaiTaksiranBongkaran"> Nilai Taksiran Bongkaran </label>
            <p class="form-control-static">Rp {{ numberFormatIndo($data->nilai_taksiran) }}</p>
        </div>
        <div class="form-group m-form__group">
            <label> KIB Bangunan </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'KIB Bangunan', 'type' => 'pdf', 'url' => \App\Model\Bongkaran\Bongkaran::docLocation($data->id, $data->kib_bangunan, true)])
            </p>
        </div>
        <div class="form-group m-form__group">
            <label> Dokumen Penganggaran </label>
            @if($data->dokumen_penganggaran != null)
                <p class="form-control-static">
                    @include('components.form.fileButton', ['title' => 'Dokumen Penganggaran', 'type' => 'pdf', 'url' => \App\Model\Bongkaran\Bongkaran::docLocation($data->id, $data->dokumen_penganggaran, true)])
                </p>
            @else
                <p class="form-control-static"><i>Empty</i></p>
            @endif
        </div>
    </div>
</div>