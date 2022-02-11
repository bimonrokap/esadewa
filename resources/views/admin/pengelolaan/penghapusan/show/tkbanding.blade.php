<div class="m-form-custom-5 row">
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label for="inputLetterNumber"> No Surat Pengajuan Banding </label>
            <p class="form-control-static">{{ $data->letter_number_banding }}</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputPenandatangananSurat"> Penandatanganan Surat </label>
            <p class="form-control-static">{{ $data->penandatanganSuratBanding->name }}</p>
        </div>
        <div class="form-group m-form__group">
            <label> Surat Pengantar Tingkat Banding </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Surat Pengantar Tingkat Banding', 'type' => 'pdf', 'url' => \App\Model\Penghapusan\Penghapusan::docLocation($data->id, $data->surat_penghantar_banding, true)])
            </p>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label for="inputLetterDate"> Tanggal Surat </label>
            <p class="form-control-static">{{ \Carbon\Carbon::parse($data->letter_date_banding)->format('j F Y') }}</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputPerihalSurat"> Perihal Surat </label>
            <p class="form-control-static">{!! nl2br($data->perihal_banding) !!}</p>
        </div>
    </div>
</div>