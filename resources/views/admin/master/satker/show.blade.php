<a href="javascript:;" class="thumbnail" style="width: 500px;height: 250px;display: block;margin: auto;border: 1px solid #e0e0e0;padding: 5px;">
    <img src="{{ $preview }}" style='height: 100%; width: 100%; object-fit: contain;display: block; '>
</a>
<hr>
<form class="m-form m-form--label-align-right" action="#" method="POST">
    <div class="m-form__section m-form__section--first m-form-custom-5">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Satker </label>
                    <div class="col-lg-7">
                        <p class="m-form__control-static"> {{ $data->name }} </p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Kota </label>
                    <div class="col-lg-7">
                        <p class="m-form__control-static"> {{ $data->city }} </p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Type </label>
                    <div class="col-lg-7">
                        <p class="m-form__control-static"> {{ $listType[$data->type] }} </p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Ketua/Kepala pengadilan </label>
                    <div class="col-lg-7">
                        <p class="m-form__control-static"> {{ $profile->ketua_pengadilan or '' }} </p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Panitera </label>
                    <div class="col-lg-7">
                        <p class="m-form__control-static"> {{ $profile->panitera_pengadilan or '' }} </p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Jumlah Hakim </label>
                    <div class="col-lg-3">
                        <p class="m-form__control-static"> {{ $profile->jumlah_hakim or '' }} Orang </p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Jumlah Tenaga Kepaniteraan </label>
                    <div class="col-lg-3">
                        <p class="m-form__control-static"> {{ $profile->jumlah_tenaga_teknis or '' }} Orang </p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Klasifikasi/Type </label>
                    <div class="col-lg-5">
                        <p class="m-form__control-static"> {{ $profile->klasifikasi or '' }} </p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Alamat Kantor </label>
                    <div class="col-lg-7">
                        <p class="m-form__control-static"> {{ $profile->alamat_kantor or '' }} </p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Telp. Fax. </label>
                    <div class="col-lg-7">
                        <p class="m-form__control-static"> {{ $profile->telp or '' }} </p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Nama Admin SIMAK BMN (Contact Person) </label>
                    <div class="col-lg-7">
                        <p class="m-form__control-static"> {{ $profile->operator_simak or '' }} </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Kode Satker </label>
                    <div class="col-lg-7">
                        <p class="m-form__control-static"> {{ $data->kode }} </p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Lingkungan </label>
                    <div class="col-lg-7">
                        <p class="m-form__control-static"> {!! $listLingkungan[$data->satker_type] or '<i class="empty-text">Empty</i>' !!} </p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Wakil Ketua/Wakil Kepala Pengadilan </label>
                    <div class="col-lg-7">
                        <p class="m-form__control-static"> {{ $profile->wakil_ketua_pengadilan or '' }} </p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Sekretaris Pengadilan </label>
                    <div class="col-lg-7">
                        <p class="m-form__control-static"> {{ $profile->sekretaris_pengadilan or '' }} </p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Jumlah Tenaga Kesekretariatan </label>
                    <div class="col-lg-3">
                        <p class="m-form__control-static"> {{ $profile->jumlah_tenaga_kesekratariatan or '' }} Orang </p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Honorer/Pg.Kontrak </label>
                    <div class="col-lg-3">
                        <p class="m-form__control-static"> {{ $profile->jumlah_ptt or '' }} </p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Website </label>
                    <div class="col-lg-6">
                        <p class="m-form__control-static"> {{ $profile->website or '' }} </p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Email Kantor </label>
                    <div class="col-lg-6">
                        <p class="m-form__control-static"> {{ $profile->email_kantor or '' }} </p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Email Admin </label>
                    <div class="col-lg-6">
                        <p class="m-form__control-static"> {{ $profile->email_admin or '' }} </p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> No. HP Aktif </label>
                    <div class="col-lg-5">
                        <p class="m-form__control-static"> {{ $profile->no_hp or '' }} </p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Koordinat </label>
                    <div class="col-lg-7">
                        <p class="m-form__control-static">
                            @if( @$profile->koord != null)
                                <a target="_blank" href="https://www.google.com/maps/{{ '@'.@$profile->koord }},15z">Maps ({{ @$profile->koord }})</a>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <h5 class="text-center">Aset Negara</h5>
    <div class="m-form__section m-form__section--first m-form-custom-5">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Tanah Kantor </label>
                    <div class="col-lg-7">
                        <p class="m-form__control-static"> {{ $aset['tanah_kantor']['bidang'] }} Bidang </p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Tanah Rumah Negara </label>
                    <div class="col-lg-7">
                        <p class="m-form__control-static"> {{ $aset['tanah_rumah_negara']['bidang'] }} Bidang</p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Rumah Negara Golongan I </label>
                    <div class="col-lg-7">
                        <p class="m-form__control-static"> {{ $aset['rumah_negara']['I'] }} Unit </p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Rumah Negara Golongan II </label>
                    <div class="col-lg-7">
                        <p class="m-form__control-static"> {{ $aset['rumah_negara']['II'] }} Unit </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Luas </label>
                    <div class="col-lg-7">
                        <p class="m-form__control-static"> {{ numberFormatIndo($aset['tanah_kantor']['luas']) }} M<sup>2</sup> </p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Luas </label>
                    <div class="col-lg-7">
                        <p class="m-form__control-static"> {{ numberFormatIndo($aset['tanah_rumah_negara']['luas']) }} M<sup>2</sup> </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group m-form__group row">
                    <label class="col-lg-5 col-form-label"> Kendaraan Bermotor </label>
                    <label class="col-lg-3 col-form-label"> Roda 4</label>
                    <div class="col-lg-4">
                        <p class="m-form__control-static"> {{ $aset['kendaraan'][4] }} Unit </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group m-form__group row">
                    <label class="col-lg-3 col-form-label"> Roda 2</label>
                    <div class="col-lg-3">
                        <p class="m-form__control-static"> {{ $aset['kendaraan'][2] }} Unit </p>
                    </div>
                    <label class="col-lg-3 col-form-label"> Lainnya</label>
                    <div class="col-lg-3">
                        <p class="m-form__control-static"> {{ $aset['kendaraan']['lainnya'] }} Unit </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(document).ready(function () {
        $(".thumbnail").click(function() {
            $.fancybox.open({!! json_encode($images) !!}, {
                animationEffect: "zoom-in-out"
            });
        });
    });
</script>