@extends('template.admin.content')

@section('content')

    <!--Begin::Section-->
    <div class="row">
        <div class="col-xl-3 col-lg-4">
            <div class="m-portlet m-portlet--full-height  ">
                <div class="m-portlet__body">
                    <div class="m-card-profile">
                        <div class="m-card-profile__title m--hide">
                            Your Profile
                        </div>
                        <div class="m-card-profile__pic">
                            <div class="m-card-profile__pic-wrapper">
                                <img src="{{ asset($user->image == null || !file_exists(public_path('user_image/' . $user->image)) ? 'assets/app/media/img/siper_default.png' : 'user_image/' . $user->image) }}"  alt=""/>
                            </div>
                        </div>
                        <div class="m-card-profile__details">
                            <span class="m-card-profile__name">
                                {{ $user->name }}
                            </span>
                        </div>
                    </div>
                    <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
                        <li class="m-nav__separator m-nav__separator--fit"></li>
                        <li class="m-nav__item">
                            <a class="m-nav__link">
                                <i class="m-nav__link-icon flaticon-profile-1"></i>
                                <span class="m-nav__link-text">
                                    {{ $user->nip }}
                                </span>
                            </a>
                        </li>
                        <li class="m-nav__item">
                            <a  class="m-nav__link">
                                <i class="m-nav__link-icon flaticon-technology-1"></i>
                                <span class="m-nav__link-text">
                                    {{ $user->jabatan }}
                                </span>
                            </a>
                        </li>
                        <li class="m-nav__item">
                            <a  class="m-nav__link">
                                <i class="m-nav__link-icon flaticon-support"></i>
                                <span class="m-nav__link-text">
                                    {{ $user->telp }}
                                </span>
                            </a>
                        </li>
                        <li class="m-nav__item">
                            <a  class="m-nav__link">
                                <i class="m-nav__link-icon flaticon-mail"></i>
                                <span class="m-nav__link-text">
                                    {{ $user->username }}
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-8">
            <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_user_profile_tab_1" role="tab">
                                    <i class="flaticon-share m--hide"></i>
                                    Update Profile
                                </a>
                            </li>
                            @if($isSatker)
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_user_profile_tab_2" role="tab">
                                    <i class="flaticon-share m--hide"></i>
                                    Profile Satker
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#foto_satker" role="tab">
                                    <i class="flaticon-share m--hide"></i>
                                    Foto Satker
                                </a>
                            </li>
                                @endif
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="m_user_profile_tab_1">
                        <form id="form-profile" class="m-form m-form--fit m-form--label-align-right" method="POST" action="{{ route($config['route'] . '.updateprofile') }}">
                            @csrf
                            @component('admin.components.form.alert') @endcomponent
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group row">
                                    <div class="col-10 ml-auto">
                                        <h3 class="m-form__section">
                                            Personal Details
                                        </h3>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">
                                        Email
                                    </label>
                                    <div class="col-7">
                                        <input class="form-control m-input" type="email" disabled value="{{ $user->username }}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">
                                        Nama
                                    </label>
                                    <div class="col-7">
                                        <input class="form-control m-input" name="name" type="text" value="{{ $user->name }}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">
                                        NIP
                                    </label>
                                    <div class="col-7">
                                        <input class="form-control m-input" name="nip" type="text" value="{{ $user->nip }}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">
                                        Jabatan
                                    </label>
                                    <div class="col-7">
                                        <input class="form-control m-input" name="jabatan" type="text" value="{{ $user->jabatan }}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">
                                        No Telepon
                                    </label>
                                    <div class="col-7">
                                        <input class="form-control m-input" name="telp" type="text" value="{{ $user->telp }}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-lg-2 col-form-label"> Update Foto </label>
                                    <div class="col-lg-7">
                                        <div class="custom-file">
                                            <input name="foto" type="file" class="custom-file-input" id="customFile">
                                            <label class="custom-file-label" for="customFile">
                                                Pilih gambar
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-lg-2 col-form-label"> Password </label>
                                    <div class="col-lg-7">
                                        <input type="password" class="form-control m-input m-input--solid" id="password" name="password" placeholder="Password" />
                                        <span class="help-block">Kosongkan Password jika tidak ada perubahan</span>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-lg-2 col-form-label"> Ulangi Password </label>
                                    <div class="col-lg-7">
                                        <input type="password" class="form-control m-input m-input--solid" id="password_match" name="password_match" placeholder="Ulangi Password" />
                                        <span class="help-block">Kosongkan Password jika tidak ada perubahan</span>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route($config['route'] . '.profile') }}" id="reload" class="ajaxify" style="display: none;"></a>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions">
                                    <div class="row">
                                        <div class="col-2"></div>
                                        <div class="col-7">
                                            <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">
                                                Save changes
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if($isSatker)
                    <div class="tab-pane" id="m_user_profile_tab_2">
                        <form id="form-satker" class="m-form m-form--fit m-form--label-align-right" method="POST" action="{{ route($config['route'] . '.updatesatker') }}">
                            @if(\Auth::user()->isAdminSatker())
                                @csrf
                                @component('admin.components.form.alert') @endcomponent
                                <div class="m-portlet__body">
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
                                                    <div class="col-lg-7">
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
                                                    <div class="col-lg-7">
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
                                                    <div class="col-lg-7">
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
                                                        <input value="{{ $profile->telp or '' }}" type="text" class="form-control m-input m-input--solid" name="satker_telp" placeholder="Telp. Fax." />
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
                                                    <div class="col-lg-7">
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
                                                    <div class="col-lg-7">
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
                                                    <div class="col-lg-7">
                                                        <input value="{{ $profile->website or '' }}" type="text" class="form-control m-input m-input--solid" name="website" placeholder="Website" />
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-lg-5 col-form-label"> Email Kantor </label>
                                                    <div class="col-lg-7">
                                                        <input value="{{ $profile->email_kantor or '' }}" type="text" class="form-control m-input m-input--solid" name="email_kantor" placeholder="Email Kantor" />
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-lg-5 col-form-label"> Email Admin </label>
                                                    <div class="col-lg-7">
                                                        <input value="{{ $profile->email_admin or '' }}" type="text" class="form-control m-input m-input--solid" name="email_admin" placeholder="Email Admin" />
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-lg-5 col-form-label"> No. HP Aktif </label>
                                                    <div class="col-lg-7">
                                                        <input value="{{ $profile->no_hp or '' }}" type="text" class="form-control m-input m-input--solid" name="no_hp" placeholder="No. HP Aktif" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route($config['route'] . '.profile') }}" id="reload" class="ajaxify" style="display: none;"></a>
                                <div class="m-portlet__foot m-portlet__foot--fit">
                                    <div class="m-form__actions">
                                        <div class="row">
                                            <div class="col-2"></div>
                                            <div class="col-7">
                                                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">
                                                    Save changes
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif(\Auth::user()->isSatker())
                                <div class="m-portlet__body">
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
                                                    <div class="col-lg-7">
                                                        <p class="m-form__control-static"> {{ $profile->jumlah_hakim or '' }}</p>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-lg-5 col-form-label"> Jumlah Tenaga Kepaniteraan </label>
                                                    <div class="col-lg-7">
                                                        <<p class="m-form__control-static"> {{ $profile->jumlah_tenaga_teknis or '' }} </p>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-lg-5 col-form-label"> Klasifikasi/Type </label>
                                                    <div class="col-lg-7">
                                                        <p class="m-form__control-static"> {{ $profile->klasifikasi or '' }}" </p>
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
                                                        <p class="m-form__control-static"> {{ $profile->telp or '' }}" </p>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-lg-5 col-form-label"> Koordinat </label>
                                                    <div class="col-lg-7">
                                                        <p class="m-form__control-static"> {{ $profile->koord or '' }}" </p>
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
                                                    <div class="col-lg-7">
                                                        <p class="m-form__control-static"> {{ $profile->jumlah_tenaga_kesekratariatan or '' }}" </p>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-lg-5 col-form-label"> Honorer/Pg.Kontrak </label>
                                                    <div class="col-lg-7">
                                                        <p class="m-form__control-static"> {{ $profile->jumlah_ptt or '' }} </p>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-lg-5 col-form-label"> Website </label>
                                                    <div class="col-lg-7">
                                                        <p class="m-form__control-static"> {{ $profile->website or '' }} </p>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-lg-5 col-form-label"> Email Kantor </label>
                                                    <div class="col-lg-7">
                                                        <p class="m-form__control-static"> {{ $profile->email_kantor or '' }} </p>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-lg-5 col-form-label"> Email Admin </label>
                                                    <div class="col-lg-7">
                                                        <p class="m-form__control-static"> {{ $profile->email_admin or '' }} </p>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-lg-5 col-form-label"> No. HP Aktif </label>
                                                    <div class="col-lg-7">
                                                        <p class="m-form__control-static"> {{ $profile->no_hp or '' }} </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                        </form>
                    </div>
                    <div class="tab-pane" id="foto_satker">
                        <a href="javascript:;" class="thumbnail" style="width: 500px;height: 250px;display: block;margin: auto;border: 1px solid #e0e0e0;padding: 5px;">
                            <img src="{{ $preview }}" style='height: 100%; width: 100%; object-fit: contain;display: block; '>
                        </a>
                        @if(\Auth::user()->isAdminSatker())
                        <hr>
                        <form id="form-foto-satker" class="m-form m-form--fit m-form--label-align-right" method="POST" action="{{ route($config['route'] . '.photosatker') }}">
                            @csrf
                            @component('admin.components.form.alert') @endcomponent
                            <div class="m-portlet__body">
                                <div class="m-form__section m-form__section--first m-form-custom-5">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @for($i = 1;$i <= 3;$i++)
                                                <div class="form-group m-form__group row">
                                                    <label class="col-lg-2 col-form-label"> @if($i == 1) Foto @endif </label>
                                                    <div class="col-lg-4">
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
                            <a href="{{ route($config['route'] . '.profile') }}" id="reload" class="ajaxify" style="display: none;"></a>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions">
                                    <div class="row">
                                        <div class="col-2"></div>
                                        <div class="col-7">
                                            <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">
                                                Save changes
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                            @endif
                    </div>
                        @endif
                </div>
            </div>
        </div>
    </div>
    <!--End::Section-->

    @endsection

@push('scripts')
    <script src="{{ asset('assets/app/js/dashboard.js') }}" type="text/javascript"></script>
@endpush
@push('js')
    <script src="{{ asset('assets/vendors/custom/fullcalendar/fullcalendar.bundle.js') }}" type="text/javascript"></script>
@endpush
@push('css')
    <link href="{{ asset('assets/vendors/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('scripts')
    <script src="{{ asset('assets/app/js/datatable.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var options = {
                'form' : '#form-profile',
                'rules' : {
                    password_match: {
                        equalTo: "#password"
                    }
                },
                'message' : {
                    password_match: {
                        equalTo: "Password not match!"
                    }
                }
            };

            FormValidation.init(options);

            var options = {
                'form' : '#form-satker'
            };

            FormValidation.init(options);

            var options = {
                'form' : '#form-foto-satker'
            };

            FormValidation.init(options);

            @if($isSatker)
            $(".thumbnail").click(function() {
                $.fancybox.open({!! json_encode($dataImages) !!}, {
                    animationEffect: "zoom-in-out"
                });
            });
            @endif
        });
    </script>
@endpush