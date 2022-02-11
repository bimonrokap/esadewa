<div class="m-form-custom-5 row">
    <div class="col-md-12">
        <table class="table table-advance table-rule table-bordered m-table m-table--head-bg-metal">
            <thead>
                <tr>
                    <th class="text-center">Eselon 1</th>
                    <th class="text-center">Draft UAPB</th>
                    <th class="text-center">APIP</th>
                    <th class="text-center">UAPB</th>
                    <th class="text-center">DJKN</th>
                </tr>
            </thead>
            <tbody>
                <td class="text-center"><i class="fa fa-{{ $data->eselon1 == 1 ? 'check' : ($data->eselon1 == 2 ? 'remove' : 'minus') }}" style="color: {{ $data->eselon1 == 1 ? '#2ecc71' : ($data->eselon1 == 2 ? '#e74c3c' : '#2c3e50') }};"></i></td>
                <td class="text-center"><i class="fa fa-{{ $data->draftuapb == 1 ? 'check' : ($data->draftuapb == 2 ? 'remove' : 'minus') }}" style="color: {{ $data->draftuapb == 1 ? '#2ecc71' : ($data->draftuapb == 2 ? '#e74c3c' : '#2c3e50') }};"></i></td>
                <td class="text-center"><i class="fa fa-{{ $data->apip == 1 ? 'check' : ($data->apip == 2 ? 'remove' : 'minus') }}" style="color: {{ $data->apip == 1 ? '#2ecc71' : ($data->apip == 2 ? '#e74c3c' : '#2c3e50') }};"></i></td>
                <td class="text-center"><i class="fa fa-{{ $data->uapb == 1 ? 'check' : ($data->uapb == 2 ? 'remove' : 'minus') }}" style="color: {{ $data->uapb == 1 ? '#2ecc71' : ($data->uapb == 2 ? '#e74c3c' : '#2c3e50') }};"></i></td>
                <td class="text-center"><i class="fa fa-{{ $data->djkn == 1 ? 'check' : ($data->djkn == 2 ? 'remove' : 'minus') }}" style="color: {{ $data->djkn == 1 ? '#2ecc71' : ($data->djkn == 2 ? '#e74c3c' : '#2c3e50') }};"></i></td>
            </tbody>
        </table>
    </div>

    <div class="col-lg-3">
        <div class="form-group m-form__group">
            <label>No Pengadaan</label>
            <input type="hidden" name="idRkbmn" value="{{ $data->id }}" />
            <p class="form-control-static" id="noPengadaan">{{ $data->no_pengadaan }}</p>
        </div>
        <div class="form-group m-form__group">
            <label>Kategori</label>
            <p class="form-control-static">{{ $data->kategori }}</p>
        </div>
        <div class="form-group m-form__group">
            <label>SBSK Eksisting</label>
            <p class="form-control-static">{{ $data->sbsk_eksisting }}</p>
        </div>
        <div class="form-group m-form__group">
            <label>Kpb Luas</label>
            <p class="form-control-static">{{ $data->kpb_luas }}</p>
        </div>
        <div class="form-group m-form__group">
            <label>Pengguna Luas</label>
            <p class="form-control-static">{{ $data->pengguna_luas }}</p>
        </div>
        <div class="form-group m-form__group">
            <label>Final Luas</label>
            <p class="form-control-static">{{ $data->final_luas }}</p>
        </div>
        <div class="form-group m-form__group">
            <label>Tahun Anggaran</label>
            <p class="form-control-static">{{ $data->tahun_anggaran }}</p>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group m-form__group">
            <label>No Output</label>
            <p class="form-control-static">{{ $data->no_output }}</p>
        </div>
        <div class="form-group m-form__group">
            <label>SBSK Usulan</label>
            <p class="form-control-static">{{ $data->sbsk_usulan }}</p>
        </div>
        <div class="form-group m-form__group">
            <label>Optimalisasi</label>
            <p class="form-control-static">{{ $data->optimalisasi }}</p>
        </div>
        <div class="form-group m-form__group">
            <label>Eselon Unit</label>
            <p class="form-control-static">{{ $data->eselon_unit }}</p>
        </div>
        <div class="form-group m-form__group">
            <label>APIP Unit</label>
            <p class="form-control-static">{{ $data->apip_unit }}</p>
        </div>
        <div class="form-group m-form__group">
            <label>Koreksi</label>
            <p class="form-control-static">{{ $data->koreksi }}</p>
        </div>
        <div class="form-group m-form__group">
            <label>Kode Tiket</label>
            <p class="form-control-static">{{ $data->kode_tiket }}</p>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group m-form__group">
            <label>Kode Barang</label>
            <p class="form-control-static" id="kodeBarang">{{ $data->kode_barang }}</p>
        </div>
        <div class="form-group m-form__group">
            <label>Jumlah Eksisting</label>
            <p class="form-control-static">{{ $data->jml_eksisting }}</p>
        </div>
        <div class="form-group m-form__group">
            <label>Kebutuhan Ril</label>
            <p class="form-control-static">{{ $data->kebutuhan_ril }}</p>
        </div>
        <div class="form-group m-form__group">
            <label>Eselon Luas</label>
            <p class="form-control-static">{{ $data->eselon_luas }}</p>
        </div>
        <div class="form-group m-form__group">
            <label>Apip Luas</label>
            <p class="form-control-static">{{ $data->apip_luas }}</p>
        </div>
        <div class="form-group m-form__group">
            <label>Persetujuan Unit</label>
            <p class="form-control-static">{{ $data->persetujuan_unit }}</p>
        </div>
        <div class="form-group m-form__group">
            <label>Kode Satker</label>
            <p class="form-control-static" id="kodeSatker">{{ $data->kode_satker }}</p>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group m-form__group">
            <label>Nama Barang</label>
            <p class="form-control-static">{{ $data->nama_barang }}</p>
        </div>
        <div class="form-group m-form__group">
            <label>Luas Eksisting</label>
            <p class="form-control-static">{{ $data->luas_eksisting }}</p>
        </div>
        <div class="form-group m-form__group">
            <label>KPB Unit</label>
            <p class="form-control-static">{{ $data->kpb_unit }}</p>
        </div>
        <div class="form-group m-form__group">
            <label>Pengguna Unit</label>
            <p class="form-control-static">{{ $data->pengguna_unit }}</p>
        </div>
        <div class="form-group m-form__group">
            <label>Final Unit</label>
            <p class="form-control-static">{{ $data->final_unit }}</p>
        </div>
        <div class="form-group m-form__group">
            <label>Persetujuan Luas</label>
            <p class="form-control-static">{{ $data->persetujuan_luas }}</p>
        </div>
        <div class="form-group m-form__group">
            <label>Nama Satker</label>
            <p class="form-control-static">{{ $data->nama_satker }}</p>
        </div>
    </div>
</div>