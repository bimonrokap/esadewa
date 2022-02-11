@switch($type)
    @case(1)
        <li class="nav-item">
            <a class="nav-link active" id="baseIcon-tab1" data-toggle="tab" aria-controls="tabData" href="#tabData" aria-expanded="true"><i class="la la-file"></i> Data </a>
        </li>
        @for($i = 1; $i <= ($data->tanah->tanah_type == 2 ? 1 : 3); $i++)
        <li class="nav-item">
            <a class="nav-link" id="baseIcon-tab{{ $i+5 }}" data-toggle="tab" aria-controls="tabPenawaran{{ $i }}" href="#tabPenawaran{{ $i }}" aria-expanded="false"><i class="la la-square-o "></i> Penawaran
                {{ $i }} </a>
        </li>
        @endfor
    @break
    @case(2)
        <li class="nav-item">
            <a class="nav-link active" id="baseIcon-tab1" data-toggle="tab" aria-controls="tabData" href="#tabData" aria-expanded="true"><i class="la la-file"></i> Data </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="baseIcon-tab2" data-toggle="tab" aria-controls="tabBarang" href="#tabBarang" aria-expanded="false"><i class="la la-square-o "></i> Barang </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="baseIcon-tab3" data-toggle="tab" aria-controls="tabFoto" href="#tabFoto" aria-expanded="false"><i class="la la-image"></i> Gambar Rencana Usulan </a>
        </li>
    @break
    @case(3)
        <li class="nav-item">
            <a class="nav-link active" id="baseIcon-tab1" data-toggle="tab" aria-controls="tabData" href="#tabData" aria-expanded="true"><i class="la la-file"></i> Data </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="baseIcon-tab3" data-toggle="tab" aria-controls="tabFoto" href="#tabFoto" aria-expanded="false"><i class="la la-image"></i> Foto Bangunan </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="baseIcon-tab7" data-toggle="tab" aria-controls="tabGambarDenah" href="#tabGambarDenah" aria-expanded="false"><i class="la la-map"></i> Gambar Denah Eksisting </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="baseIcon-tab8" data-toggle="tab" aria-controls="tabGambarRencana" href="#tabGambarRencana" aria-expanded="false"><i class="la la-map-marker"></i> Gambar Rencana Usulan </a>
        </li>
    @break
@endswitch