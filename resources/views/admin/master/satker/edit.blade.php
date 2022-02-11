@extends('template.admin.content')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-pencil"></i>
                            </span>
                            <h3 class="m-portlet__head-text"> Edit Profile {{ $config['pageTitle'] . ' : ' . $data->name }}</h3>
                        </div>
                    </div>
                </div>
                <form class="m-form m-form--label-align-right" action="{{ route($config['route'] . '.update', $data->id) }}" method="POST" id="form">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <div class="m-portlet__body">
                        @component('admin.components.form.alert') @endcomponent
                        <ul class="nav nav-tabs  m-tabs-line m-tabs-line--success" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#tabProfile" role="tab">
                                    Profile
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#tabFoto" role="tab">
                                    Foto
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabProfile" role="tabpanel">
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
                                                    <input value="{{ $data->city or '' }}" type="text" class="form-control m-input m-input--solid" name="city" placeholder="Kota" />
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-5 col-form-label"> Type </label>
                                                <div class="col-lg-7">
                                                    <select class="form-control m-input m-input--solid select2" name="type">
                                                        <option value="">Pilih</option>
                                                        @foreach($listType as $k => $v)
                                                            <option {!! $data->type == $k ? 'selected="selected"' : '' !!} value="{{ $k }}">{{ $v }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-5 col-form-label"> KPKNL </label>
                                                <div class="col-lg-7">
                                                    <input value="{{ $data->kpknl or '' }}" type="text" class="form-control m-input m-input--solid" name="kpknl" placeholder="KPKNL" />
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-5 col-form-label"> Ketua/Kepala pengadilan </label>
                                                <div class="col-lg-7">
                                                    <input value="{{ $profile->ketua_pengadilan or '' }}" type="text" class="form-control m-input m-input--solid" name="ketua_pengadilan" placeholder="Ketua/Kelapa Pengadilan" />
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-5 col-form-label"> Panitera </label>
                                                <div class="col-lg-7">
                                                    <input value="{{ $profile->panitera_pengadilan or '' }}" type="text" class="form-control m-input m-input--solid" name="panitera_pengadilan" placeholder="Panitera Pengadilan" />
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-5 col-form-label"> Jumlah Hakim </label>
                                                <div class="col-lg-3">
                                                    <div class="input-group">
                                                        <input value="{{ $profile->jumlah_hakim or '' }}" type="text" class="form-control m-input" name="jumlah_hakim" placeholder="Jumlah Hakim" />
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"> Orang </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-5 col-form-label"> Jumlah Tenaga Kepaniteraan </label>
                                                <div class="col-lg-3">
                                                    <div class="input-group">
                                                        <input value="{{ $profile->jumlah_tenaga_teknis or '' }}" type="text" class="form-control m-input" name="jumlah_tenaga_teknis" placeholder="Jumlah Tenaga Kepaniteraan/Teknis" />
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"> Orang </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-5 col-form-label"> Klasifikasi/Type </label>
                                                <div class="col-lg-5">
                                                    <input value="{{ $profile->klasifikasi or '' }}" type="text" class="form-control m-input m-input--solid" name="klasifikasi" placeholder="Klasifikasi/Type Kantor Pengadilan" />
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-5 col-form-label"> Alamat Kantor </label>
                                                <div class="col-lg-7">
                                                    <textarea class="form-control m-input m-input--solid" name="alamat_kantor" rows="2  " placeholder="Alamat Kantor">{{ $profile->alamat_kantor or '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-5 col-form-label"> Telp. Fax. </label>
                                                <div class="col-lg-7">
                                                    <input value="{{ $profile->telp or '' }}" type="text" class="form-control m-input m-input--solid" name="telp" placeholder="Telp. Fax." />
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-5 col-form-label"> Koordinat </label>
                                                <div class="col-lg-7">
                                                    <input value="{{ $profile->koord or '' }}" type="text" class="form-control m-input m-input--solid" name="koord" placeholder="Koordinat" />
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-5 col-form-label"> Nama Admin SIMAK BMN (Contact Person) </label>
                                                <div class="col-lg-7">
                                                    <input value="{{ $profile->operator_simak or '' }}" type="text" class="form-control m-input m-input--solid" name="operator_simak" placeholder="Operator SIMAK-BMN (Contact Person)" />
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
                                                    <select class="form-control m-input m-input--solid select2" name="satker_type">
                                                        <option value="">Pilih</option>
                                                        @foreach($listLingkungan as $k => $v)
                                                            <option {!! $data->satker_type == $k ? 'selected="selected"' : '' !!} value="{{ $k }}">{{ $v }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-5 col-form-label"> DIRJEN </label>
                                                <div class="col-lg-7">
                                                    <input value="{{ $data->dirjen or '' }}" type="text" class="form-control m-input m-input--solid" name="dirjen" placeholder="DIRJEN" />
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-5 col-form-label"> Kanwil </label>
                                                <div class="col-lg-7">
                                                    <input value="{{ $data->kanwil or '' }}" type="text" class="form-control m-input m-input--solid" name="kanwil" placeholder="Kanwil" />
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-5 col-form-label"> Wakil Ketua/Wakil Kepala Pengadilan </label>
                                                <div class="col-lg-7">
                                                    <input value="{{ $profile->wakil_ketua_pengadilan or '' }}" type="text" class="form-control m-input m-input--solid" name="wakil_ketua_pengadilan" placeholder="Wakil Ketua/Kepala Pengadilan" />
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-5 col-form-label"> Sekretaris Pengadilan </label>
                                                <div class="col-lg-7">
                                                    <input value="{{ $profile->sekretaris_pengadilan or '' }}" type="text" class="form-control m-input m-input--solid" name="sekretaris_pengadilan" placeholder="Sekretaris Pengadilan" />
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-5 col-form-label"> Jumlah Tenaga Kesekretariatan </label>
                                                <div class="col-lg-3">
                                                    <div class="input-group">
                                                        <input value="{{ $profile->jumlah_tenaga_kesekratariatan or '' }}" type="text" class="form-control m-input" name="jumlah_tenaga_kesekratariatan" placeholder="Jumlah Tenaga" />
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"> Orang </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-5 col-form-label"> Honorer/Pg.Kontrak </label>
                                                <div class="col-lg-3">
                                                    <div class="input-group">
                                                        <input value="{{ $profile->jumlah_ptt or '' }}" type="text" class="form-control m-input" name="jumlah_ptt" placeholder="Honorer/Pg.Kontrak" />
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"> Orang </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-5 col-form-label"> Website </label>
                                                <div class="col-lg-6">
                                                    <input value="{{ $profile->website or '' }}" type="text" class="form-control m-input m-input--solid" name="website" placeholder="Website" />
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-5 col-form-label"> Email Kantor </label>
                                                <div class="col-lg-6">
                                                    <input value="{{ $profile->email_kantor or '' }}" type="text" class="form-control m-input m-input--solid" name="email_kantor" placeholder="Email Kantor" />
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-5 col-form-label"> Email Admin </label>
                                                <div class="col-lg-6">
                                                    <input value="{{ $profile->email_admin or '' }}" type="text" class="form-control m-input m-input--solid" name="email_admin" placeholder="Email Admin" />
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-5 col-form-label"> No. HP Aktif </label>
                                                <div class="col-lg-5">
                                                    <input value="{{ $profile->no_hp or '' }}" type="text" class="form-control m-input m-input--solid" name="no_hp" placeholder="No. HP Aktif" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabFoto" role="tabpanel">
                                <div class="m-form__section m-form__section--first m-form-custom-5">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @for($i = 1;$i <= 3;$i++)
                                                <div class="form-group m-form__group row">
                                                    <label class="col-lg-3 col-form-label"> @if($i == 1) Foto @endif </label>
                                                    <div class="col-lg-3">
                                                        <div class="custom-file">
                                                            <input name="foto[{{ $i }}]" type="file" class="custom-file-input">
                                                            <label class="custom-file-label"> Pilih gambar </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <input type="text" class="form-control m-input m-input--solid" name="caption[{{ $i }}]" placeholder="Caption" value="{{ @$dataImages[$i-1]['opts']['caption'] }}" />
                                                    </div>
                                                    <div class="col-lg-3">
                                                        @if(isset($dataImages[$i-1]))
                                                            <a style="display: block;" target="_blank" href="{{ $dataImages[$i-1]['src'] }}">Foto</a>
                                                            <input name="hapus[{{ $i }}]" type="checkbox" value="{{ $i }}" /> Hapus
                                                        @endif
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route($config['route'] . '.edit', $data->id) }}" id="reload" class="ajaxify" style="display: none;"></a>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button type="submit" class="btn btn-success"> Simpan </button>
                                    <a href="{{ route($config['route'] . '.index') }}" class="ajaxify"> <button type="button" class="btn btn-secondary"> Kembali </button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection

@push('scripts')
    <script src="{{ asset('assets/app/js/datatable.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            var options = {
                'form' : '#form'
            };

            FormValidation.init(options);
        });
    </script>
    @endpush