<div class="m-form-custom-5 row">
    <div class="col-lg-4">
        <div class="form-group m-form__group">
            <label> Draft SK Penghapusan </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Draft SK Penghapusan', 'type' => 'word', 'url' => route($config['route'] . '.draft', ['id' => $data->id, 'slug' => 'doc-pengelolaan-penghapusan-sk'])])
            </p>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group m-form__group">
            <label> Lampiran SK Penghapusan </label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Lampiran SK Penghapusan ', 'type' => 'excel', 'url' => route($config['route'] . '.lampiran', $data->id)])
            </p>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group m-form__group">
            <label> Draft Memorandum SK Penghapusan</label>
            <p class="form-control-static">
                @include('components.form.fileButton', ['title' => 'Draft Memorandum SK Penghapusan', 'type' => 'word', 'url' => route($config['route'] . '.draft', ['id' => $data->id, 'slug' => 'doc-pengelolaan-penghapusan-memorandum'])])
            </p>
        </div>
    </div>
</div>