<div class="m-form-custom-5 row">
    <div class="col-lg-6">
        <div class="form-group m-form__group">
            <label for="inputHasilBongkaran"> Hasil Bongkaran  </label>
            <p class="form-control-static">{{ $data->hasil_bongkaran == 1 ? 'Terjual' : 'Tidak Terjual' }}</p>
        </div>
        @if($data->hasil_bongkaran == 1)
            <div class="form-group m-form__group">
                <label for="inputNomorRisalah"> Nomor Risalah Lelang  </label>
                <p class="form-control-static">{{ $data->nomor_risalah_lelang }}</p>
            </div>
            <div class="form-group m-form__group">
                <label for="inputTanggalPerjanjian"> Tanggal Risalah Lelang  </label>
                <p class="form-control-static">{{ \Carbon\Carbon::parse($data->tanggal_risalah_lelang)->format('j F Y') }}</p>
            </div>
            <div class="form-group m-form__group">
                <label for="inputPenandaTangan"> Penandatangan Risalah Lelang  </label>
                <p class="form-control-static">{{ $data->penandatangan_risalah_lelang }}</p>
            </div>
            <div class="form-group m-form__group">
                <label> Dokumen Risalah Lelang </label>
                <p class="form-control-static">
                    @include('components.form.fileButton', ['title' => 'Dokumen Risalah Lelang', 'type' => 'pdf', 'url' => \App\Model\Bongkaran\Bongkaran::docLocation($data->id, $data->dokumen_risalah_lelang, true)])
                </p>
            </div>
        @else
            <div class="form-group m-form__group">
                <label for="inputNomorIzinPemusnahan"> Nomor Izin Pemusnahan  </label>
                <p class="form-control-static">{{ $data->nomor_izin_pemusnahan }}</p>
            </div>
            <div class="form-group m-form__group">
                <label for="inputTanggalPemusnahan"> Tanggal Izin Pemusnahan  </label>
                <p class="form-control-static">{{ \Carbon\Carbon::parse($data->tanggal_izin_pemusnahan)->format('j F Y') }}</p>
            </div>
            <div class="form-group m-form__group">
                <label for="inputPerihalSurat"> Perihal Surat  </label>
                <p class="form-control-static">{!! nl2br($data->perihal_pemusnahan) !!}</p>
            </div>
        @endif
    </div>
    <div class="col-lg-6">
        @if($data->hasil_bongkaran == 1)
            <div class="form-group m-form__group">
                <label for="inputNomorBast"> Nomor Berita Acara  </label>
                <p class="form-control-static">{{ $data->nomor_berita_acara }}</p>
            </div>
            <div class="form-group m-form__group">
                <label for="inputTanggalBeritaAcara"> Tanggal Berita Acara  </label>
                <p class="form-control-static">{{ \Carbon\Carbon::parse($data->tanggal_berita_acara)->format('j F Y') }}</p>
            </div>
            <div class="form-group m-form__group">
                <label for="inputNilaiLimit"> Nilai Limit  </label>
                <p class="form-control-static">Rp {{ numberFormatIndo($data->nilai_limit) }}</p>
            </div>
            <div class="form-group m-form__group">
                <label for="inputNilaiTerjual"> Nilai yang Terjual  </label>
                <p class="form-control-static">Rp {{ numberFormatIndo($data->nilai_terjual) }}</p>
            </div>
            <div class="form-group m-form__group">
                <label> Dokumen Berita Acara </label>
                <p class="form-control-static">
                    @include('components.form.fileButton', ['title' => 'Dokumen Berita Acara', 'type' => 'pdf', 'url' => \App\Model\Bongkaran\Bongkaran::docLocation($data->id, $data->dokumen_berita_acara, true)])
                </p>
            </div>
        @else
            <div class="form-group m-form__group">
                <label for="inputNomorBeritaAcaraPemusnahan"> Nomor Berita Acara Pemusnahan  </label>
                <p class="form-control-static">{{ $data->nomor_berita_acara_pemusnahan }}</p>
            </div>
            <div class="form-group m-form__group">
                <label for="inputTanggalBeritaAcaraPemusnahan"> Tanggal Berita Acara Pemusnahan  </label>
                <p class="form-control-static">{{ \Carbon\Carbon::parse($data->tanggal_berita_acara_pemusnahan)->format('j F Y') }}</p>
            </div>
            <div class="form-group m-form__group">
                <label> Dokumen Surat Persetujuan Pemusnahan </label>
                <p class="form-control-static">
                    @include('components.form.fileButton', ['title' => 'Dokumen Surat Persetujuan Pemusnahan', 'type' => 'pdf', 'url' => \App\Model\Bongkaran\Bongkaran::docLocation($data->id, $data->dokumen_persetujuan_pemusnahan, true)])
                </p>
            </div>
            <div class="form-group m-form__group">
                <label> Dokumen Berita Acara Pemusnahan Pemusnahan </label>
                <p class="form-control-static">
                    @include('components.form.fileButton', ['title' => 'Dokumen Berita Acara Pemusnahan Pemusnahan', 'type' => 'pdf', 'url' => \App\Model\Bongkaran\Bongkaran::docLocation($data->id, $data->dokumen_berita_acara_pemusnahan, true)])
                </p>
            </div>

        @endif
    </div>
</div>