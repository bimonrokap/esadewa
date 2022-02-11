<div class="m-form-custom-5 row">
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label for="inputLetterNumber"> No Surat Persetujuan Izin Sewa </label>
            <p class="form-control-static">{{ $data->letter_number_persetujuan }}</p>
        </div>
        <div class="form-group m-form__group">
            <label for="inputLetterDate"> Tanggal Surat Persetujuan Izin Sewa </label>
            <p class="form-control-static">{{ \Carbon\Carbon::parse($data->letter_date_persetujuan)->format('j F Y') }}</p>
        </div>
        <div class="form-group m-form__group">
            <label> Surat Persetujuan Izin Sewa </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Surat Persetujuan Izin Sewa', 'type' => 'pdf', 'url' => \App\Model\Sewa\Sewa::docLocation($data->id, $data->surat_persetujuan, true)])
            </p>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label for="inputPerihalSurat"> Perihal Surat Persetujuan Izin Sewa </label>
            <p class="form-control-static">{!! nl2br($data->perihal_persetujuan) !!}</p>
        </div>
    </div>
</div>