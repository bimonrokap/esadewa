<div class="row filter-additional" style="padding-bottom: 10px;">
    @php
        $user = \Auth::user();
        if(Permission::can('view-all-asset')) {

        } else if (Permission::can('view-all-lingkungan-asset') || Permission::can('view-all-wilayah-asset') || Permission::can('view-all-satker-asset')) {
            if (Permission::can('view-all-lingkungan-asset') || Permission::can('view-all-satker-asset')) {
                unset($baseFilter['lingkungan']);
            }
            if (Permission::can('view-all-wilayah-asset') || Permission::can('view-all-satker-asset')) {
                unset($baseFilter['wilayah']);
            }
        }
    @endphp
    @foreach($baseFilter as $k => $b)
        @switch($b)
            @case('lingkungan')
                <div class="split-5 width-20">
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text"> <strong>Lingkungan</strong> </span>
                        </div>
                        <select class="form-control m-input select2 filter" name="{{ $k }}">
                            <option value="">Semua</option>
                            @foreach($filter['lingkungan'] as $k => $r)
                                <option value="{{ $k }}">{{ $r }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @break
            @case('wilayah')
                <div class="split-5 width-20">
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text"> <strong>Wilayah</strong> </span>
                        </div>
                        <select class="form-control m-input select2 filter" name="{{ $k }}">
                            <option value="">Semua</option>
                            @foreach($filter['wilayah'] as $r)
                                <option value="{{ $r->id }}">{{ $r->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @break
            @case('kondisi')
                <div class="split-5 width-15">
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text"> <strong>Kondisi</strong> </span>
                        </div>
                        <select class="form-control m-input select2 filter" name="{{ $k }}">
                            <option value="">Semua</option>
                            @foreach($filter['kondisi'] as $k => $r)
                                <option value="{{ $r }}">{{ $r }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @break
            @case('sertifikat')
                <div class="split-5 width-15">
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text"> <strong>Sertifikat</strong> </span>
                        </div>
                        <select class="form-control m-input select2 filter" name="{{ $k }}">
                            <option value="">Semua</option>
                            @foreach($filter['sertifikat'] as $k => $r)
                                <option value="{{ $r }}">{{ $r }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @break
            @case('kendaraan_type')
                <div class="split-5 width-15">
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text"> <strong>Type</strong> </span>
                        </div>
                        <select class="form-control m-input select2 filter" name="{{ $k }}">
                            <option value="">Semua</option>
                            @foreach($filter['kendaraan_type'] as $k => $r)
                                <option value="{{ $r }}">{{ $r }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @break
            @case('psp')
                <div class="split-5 width-15">
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text"> <strong>PSP</strong> </span>
                        </div>
                        <select class="form-control m-input select2 filter" name="{{ $k }}">
                            <option value="">Semua</option>
                            @foreach($filter['psp'] as $k => $r)
                                <option value="{{ $r }}">{{ $r }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @break
            @case('djkn')
                <div class="split-5 width-15">
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text"> <strong>DJKN</strong> </span>
                        </div>
                        <select class="form-control m-input select2 filter" name="{{ $k }}">
                            <option value="">Semua</option>
                            <option value="1">Setuju</option>
                            <option value="2">Tidak Setuju</option>
                        </select>
                    </div>
                </div>
                @break
            @case('anggaran')
                <div class="split-5 width-15">
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text"> <strong>Anggaran</strong> </span>
                        </div>
                        <select class="form-control m-input select2 filter" name="{{ $k }}">
                            <option value="">Semua</option>
                            <option value="1">Ya</option>
                            <option value="2">Tidak</option>
                        </select>
                    </div>
                </div>
                @break
            @endswitch
        @endforeach
</div>