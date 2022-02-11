<div class="m-form-custom-5 row">
    <div class="col-lg-4">
        <div class="form-group m-form__group">
            <label for="inputLetterNumber"> Draft Surat Persetujuan Penjualan Bongkaran </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Draft SuratPersetujuan Penjualan Bongkaran', 'type' => 'word', 'url' => route($config['route'] . '.draft', ['id' => $data->id, 'slug' => 'doc-pengelolaan-bongkaran-persetujuan'])])
            </p>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group m-form__group">
            <label for="inputPenandatangananSurat"> Lampiran Persetujuan Penjualan Bongkaran </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Lampiran Persetujuan Penjualan Bongkaran ', 'type' => 'excel', 'url' => route($config['route'] . '.lampiran', $data->id)])
            </p>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group m-form__group">
            <label for="inputLetterDate"> Draft Memo Persetujuan Penjualan Bongkaran</label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Draft Memo Persetujuan Penjualan Bongkaran', 'type' => 'word', 'url' => route($config['route'] . '.draft', ['id' => $data->id, 'slug' => 'doc-pengelolaan-bongkaran-memorandum-persetujuan'])])
            </p>
        </div>
    </div>
</div>