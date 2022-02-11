<div class="m-form-custom-5 row">
    <div class="col-lg-4">
        <div class="form-group m-form__group">
            <label for="inputLetterNumber"> Draft Persetujuan Penjualan </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Draft Persetujuan Penjualan', 'type' => 'word', 'url' => route($config['route'] . '.draft', ['id' => $data->id, 'slug' => 'doc-pengelolaan-penjualan-persetujuan'])])
            </p>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group m-form__group">
            <label for="inputPenandatangananSurat"> Lampiran Persetujuan Penjualan </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Lampiran Persetujuan Penjualan ', 'type' => 'excel', 'url' => route($config['route'] . '.lampiran', $data->id)])
            </p>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group m-form__group">
            <label for="inputLetterDate"> Draft Memorandum Persetujuan penjualan</label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Draft Memorandum Persetujuan penjualan', 'type' => 'word', 'url' => route($config['route'] . '.draft', ['id' => $data->id, 'slug' => 'doc-pengelolaan-penjualan-memorandum'])])
            </p>
        </div>
    </div>
</div>