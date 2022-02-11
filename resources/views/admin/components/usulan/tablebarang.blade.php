<div class="row">
    <label class="col-lg-3 col-form-label font-weight-bold m--padding-top-25"> Jumlah Barang : <span id="jml-barang">{{ isset($barangs) ? $barangs->count() : 0 }}</span></label>
    <label class="col-lg-3 col-form-label font-weight-bold m--padding-top-25"> Total Nilai Barang : Rp <span id="nilai-barang">{{ isset($barangs) ? numberFormatIndo($barangs->sum('nilai_perolehan')) : 0 }}</span></label>
    <label class="col-lg-6 col-form-label text-right">
        <button class="btn btn-success btn-add" type="button">
            <i class="la la-plus"></i> Tambah Barang
        </button>
    </label>
</div>

<table class="table table-striped table-bordered m-table m-table--head-bg-success" id="con-barang">
    <thead>
    <tr>
        <th width="10px"> No </th>
        <th width="10px"> NUP </th>
        <th width="200px"> Kode Barang </th>
        <th> Nama Barang </th>
        <th width="150px"> Nilai Perolehan </th>
        <th width="250px"> Kategori </th>
        <th width="80px"> Aksi </th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th id="empty-row" colspan="7" class="text-center" {!! (isset($barangs) && $barangs->count() > 0 ? 'style="display: none;"' : '') !!}> Data Kosong! </th>
    </tr>
    @if(isset($barangs))
        @foreach($barangs as $key => $row)
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td class="text-center">{{ $row->nup }}</td>
                <td>{{ $row->kode_barang }}</td>
                <td>{{ $row->nama_barang }}</td>
                <td class="text-right">{{ 'Rp '.numberFormatIndo($row->nilai_perolehan) }}</td>
                <td>{{ $row->name }}</td>
                <td class="text-center">
                    <button type="button" data-category="{{ $row->id_category_asset }}" data-id="{{ $row->id }}" title="Hapus Barang" class="btn btn-danger btn-xs m-btn m-btn--icon m-btn--icon-only btn-hapus">
                        <i class="la la-trash"></i>
                    </button>
                </td>
            </tr>
            @if(isset($uraians))
                <tr class="detail-con-barang" data-idindex="{{ $key }}">
                    <td></td>
                    <td colspan="6">
                        <div class="m-form-custom-5 row">
                            <div class="col-lg-6">
                                <div class="form-group m-form__group">
                                    <label for="inputLuasbangunan"> Luas Bangunan yang Dibongkar  <span class="required">*</span> </label>
                                    <div class="input-group m-input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> Rp </span>
                                        </div>
                                        <input type="text" class="form-control m-input harga required" id="inputLuasbangunan" value="{{ $row->luas_bangunan }}" name="luas_bangunan[]" placeholder="Luas Bangunan yang Dibongkar" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <table class="table table-bordered m-table m-table--head-bg-info" id="con-barang" style="margin-top: 10px;">
                                    <thead>
                                        <tr>
                                            <th width="10px">
                                                <button type="button" class="btn btn-success btn-xs m-btn m-btn--icon m-btn--icon-only btn-add-uraian tooltips" title="Tambah Uraian"><i class="la la-plus"></i></button>
                                            </th>
                                            <th> Uraian </th>
                                            <th width="200px"> Jumlah </th>
                                            <th width="100px"> Satuan </th>
                                            <th width="80px"> Aksi </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($uraians[$row->idBarang] as $k => $uraian)
                                            <tr>
                                                <th class="text-center">{{ $k+1 }}</th>
                                                <td> <input type="text" class="form-control m-input required" value="{{ $uraian->uraian }}" name="uraian[{{ $key }}][]" placeholder="Uraian" /> </td>
                                                <td> <input type="text" class="form-control m-input harga required" value="{{ $uraian->jumlah + 0 }}" name="jumlah[{{ $key }}][]" placeholder="Jumlah" /> </td>
                                                <td> <input type="text" class="form-control m-input" value="{{ $uraian->satuan }}" name="satuan[{{ $key }}][]" placeholder="Satuan" /> </td>
                                                <td class="text-center">
                                                    @if($k != 0)
                                                    <button type="button" class="btn btn-danger btn-xs m-btn m-btn--icon m-btn--icon-only btn-delete-uraian tooltips" title="Hapus Uraian"><i class="la la-trash"></i></button>
                                                    @else # @endif
                                                </td>
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

@push("scripts")
    <script src="{{ asset('assets/app/js/datatable.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        var barang = {};
        $(document).ready(function () {
            var tmpBarang;
            @isset($barangs)
                tmpBarang = {!! $barangs->toJson() !!}
            @endisset

            $.each(tmpBarang, function (index, value) {
                if(typeof barang[value.id_category_asset] === 'undefined') {
                    barang[value.id_category_asset] = {};
                }

                if(typeof barang[value.id_category_asset][value.id] === 'undefined') {
                    barang[value.id_category_asset][value.id] = value;
                }
            })
        })
    </script>
@endpush