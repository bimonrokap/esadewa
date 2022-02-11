<div class="m-form-custom-5 row">
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label for="inputLetterNumber"> No Surat Persetujuan Permohonan Bongkaran </label>
            <p class="form-control-static">{{ $data->letter_number_persetujuan }}</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputLetterDate"> Tanggal Surat Persetujuan Permohonan Bongkaran </label>
            <p class="form-control-static">{{ \Carbon\Carbon::parse($data->letter_date_persetujuan)->format('j F Y') }}</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputLuasbangunan"> Luas Bangunan yang Dibongkar </label>
            <p class="form-control-static">{{ $data->luas_bangunan_verif }} m<sup>2</sup></p>
        </div>
        <div class="form-group m-form__group">
            <label> Surat Persetujuan Permohonan Bongkaran </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Surat Persetujuan Permohonan Bongkaran', 'type' => 'pdf', 'url' => \App\Model\Bongkaran\Bongkaran::docLocation($data->id, $data->surat_persetujuan, true)])
            </p>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label for="inputPerihalSurat"> Perihal Surat Persetujuan Permohonan Bongkaran </label>
            <p class="form-control-static">{!! nl2br($data->perihal_persetujuan) !!}</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputNilaiTaksiranBongkaran"> Nilai Taksiran Bongkaran </label>
            <p class="form-control-static">Rp {{ numberFormatIndo($data->nilai_taksiran_verif) }}</p>
        </div>
    </div>
</div>