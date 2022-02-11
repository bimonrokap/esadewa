<div class="m-form-custom-5 row">
    <div class="col-lg-4">
        <div class="form-group m-form__group">
            <label for="inputLetterNumber"> Draft SK Sewa </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Draft SK Sewa', 'type' => 'word', 'url' => route($config['route'] . '.draft', ['id' => $data->id, 'slug' => 'doc-pengelolaan-sewa-sk'])])
            </p>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group m-form__group">
            <label for="inputPenandatangananSurat"> Lampiran Persetujuan Sewa </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Lampiran Persetujuan Sewa ', 'type' => 'excel', 'url' => route($config['route'] . '.lampiran', $data->id)])
            </p>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group m-form__group">
            <label for="inputLetterDate"> Draft Memorandum SK sewa</label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Draft Memorandum SK sewa', 'type' => 'word', 'url' => route($config['route'] . '.draft', ['id' => $data->id, 'slug' => 'doc-pengelolaan-sewa-memorandum'])])
            </p>
        </div>
    </div>
</div>