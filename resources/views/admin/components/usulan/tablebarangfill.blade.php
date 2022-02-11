<div class="row">
    <label class="col-lg-3 col-form-label font-weight-bold m--padding-top-25"> Jumlah Barang : <span id="jml-barang">{{ isset($barangs) ? $barangs->count() : 0 }}</span></label>
    <label class="col-lg-3 col-form-label font-weight-bold m--padding-top-25"> Total Nilai Barang : Rp <span id="nilai-barang">{{ isset($barangs) ? numberFormatIndo($barangs->sum('nilai_perolehan')) : 0 }}</span></label>
</div>

<table class="table table-striped table-bordered m-table m-table--head-bg-success" id="con-barang">
    <thead>
    <tr>
        <th width="10px"> No </th>
        <th width="10px"> NUP </th>
        <th width="150px"> Kode Barang </th>
        <th> Nama Barang </th>
        <th width="150px"> Nilai Perolehan </th>
        <th width="250px"> Kategori </th>
    </tr>
    </thead>
    <tbody>
        @if(isset($barangs))
            @foreach($barangs as $key => $row)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="text-center">{{ $row->nup }}</td>
                    <td>{{ $row->kode_barang }}</td>
                    <td>{{ $row->nama_barang }}</td>
                    <td class="text-right">{{ 'Rp '.numberFormatIndo($row->nilai_perolehan) }}</td>
                    <td>{{ $row->name }}</td>
                </tr>
                @if(isset($uraians))
                    <tr class="detail-con-barang">
                        <td></td>
                        <td colspan="6">
                            <div class="m-form-custom-5 row">
                                <div class="col-lg-6">
                                    <div class="form-group m-form__group">
                                        <label for="inputLuasbangunan"> Luas Bangunan yang Dibongkar </label>
                                        <p class="form-control-static">{{ numberFormatIndo($row->luas_bangunan) }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <table class="table table-bordered m-table m-table--head-bg-info" id="con-barang" style="margin-top: 10px;">
                                        <thead>
                                        <tr>
                                            <th width="10px">#</th>
                                            <th> Uraian </th>
                                            <th width="200px"> Jumlah / Satuan </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($uraians[$row->idBarang] as $k => $uraian)
                                            <tr>
                                                <th class="text-center">{{ $k+1 }}</th>
                                                <td> {{ $uraian->uraian }} </td>
                                                <td class="text-right"> {{ ($uraian->jumlah + 0).' '.$uraian->satuan }} </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endif
                @endforeach
            @endif
    </tbody>
</table>