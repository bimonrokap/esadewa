@extends('template.admin.content')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-plus"></i>
                            </span>
                            <h3 class="m-portlet__head-text"> Tambah {{ $config['pageTitle'] }}</h3>
                        </div>
                    </div>
                </div>
                <form class="m-form m-form--label-align-right" action="{{ route($config['route'] . '.store') }}" method="POST" id="form">
                    {{ csrf_field() }}
                    <div class="m-portlet__body">
                        @component('admin.components.form.alert') @endcomponent
                        <div class="m-form__section m-form__section--first">
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label"> Nama </label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control m-input m-input--solid required" name="name" placeholder="Nama" />
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label"> Username </label>
                                <div class="col-lg-3">
                                    <input type="email" class="form-control m-input m-input--solid required" name="username" placeholder="Username" />
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label"> Password </label>
                                <div class="col-lg-2">
                                    <input type="password" class="form-control m-input m-input--solid required" id="password" name="password" placeholder="Password" />
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label"> Ulangi Password </label>
                                <div class="col-lg-2">
                                    <input type="password" class="form-control m-input m-input--solid required" id="password_match" name="password_match" placeholder="Ulangi Password" />
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label"> Foto </label>
                                <div class="col-lg-4">
                                    <div class="custom-file">
                                        <input name="foto" type="file" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label" for="customFile">
                                            Pilih gambar
                                        </label>
                                    </div>
                                </div>
                            </div>

                            @if(!Auth::user()->isSatker())
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label"> Role </label>
                                <div class="col-lg-4">
                                    <select name="id_role" class="form-control m-input m-input--solid select2-role required" id="role">
                                        <option value="">Pilih Role</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{--<div class="form-group m-form__group row">--}}
                                {{--<label class="col-lg-3 col-form-label"> Pusat ? </label>--}}
                                {{--<div class="col-lg-2">--}}
                                    {{--<span class="m-switch m-switch--outline m-switch--icon m-switch--success">--}}
                                        {{--<label>--}}
                                            {{--<input type="checkbox" name="pusat" id="pusat" value="1">--}}
                                            {{--<span></span>--}}
                                        {{--</label>--}}
                                    {{--</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="form-group m-form__group row con-add" id="con-satker" style="display: none;">
                                <label class="col-lg-3 col-form-label"> Satker </label>
                                <div class="col-lg-4">
                                    <select name="id_satker" class="form-control m-input m-input--solid select2" style="width: 100%;">
                                        <option value="">Pilih Satker</option>
                                        @foreach($satkers as $satker)
                                            <option value="{{ $satker->id }}">{{ $satker->name . ' ( '.$satker->kode.' )' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group m-form__group row con-add" id="con-wilayah" style="display: none;">
                                <label class="col-lg-3 col-form-label"> Wilayah </label>
                                <div class="col-lg-4">
                                    <select name="id_wilayah" class="form-control m-input m-input--solid select2" style="width: 100%;">
                                        <option value="">Pilih Wilayah</option>
                                        @foreach($wilayah as $w)
                                            <option value="{{ $w->id }}">{{ $w->name . ' ( '.$w->code.' )' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group m-form__group row con-add" id="con-lingkungan" style="display: none;">
                                <label class="col-lg-3 col-form-label"> Lingkungan </label>
                                <div class="col-lg-4">
                                    <select name="lingkungan" class="form-control m-input m-input--solid select2" style="width: 100%;">
                                        <option value="">Pilih Lingkungan</option>
                                        @foreach($listLingkungan as $key => $row)
                                            <option value="{{ $key }}">{{ $row }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route($config['route'] . '.index') }}" id="reload" class="ajaxify" style="display: none;"></a>
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
            $('.select2').select2();
            $('.select2-role').select2({
                placeholder: 'Pilih Role'
            });

            var options = {
                'form' : '#form',
                'rules' : {
                    password: "required",
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

            $('#role').change(function () {
                var val = $(this).val();
                $('.con-add').hide();
                if(val == '{{ \App\Model\Role::ADMIN_SATKER }}' || val == '{{ \App\Model\Role::SATKER }}'){
                    $('#con-satker').show();
                } else if (val == '{{ \App\Model\Role::ADMIN_TINGKAT_BANDING }}' || val == '{{ \App\Model\Role::TINGKAT_BANDING }}') {
                    $('#con-wilayah').show();
                    $('#con-lingkungan').show();
                } else if (val == '{{ \App\Model\Role::KORWIL }}' || val == '{{ \App\Model\Role::ADMIN_KORWIL }}') {
                    $('#con-wilayah').show();
                } else if (val == '{{ \App\Model\Role::ESELON }}' || val == '{{ \App\Model\Role::ADMIN_ESELON }}') {
                    $('#con-lingkungan').show();
                }
            });
        });
    </script>
    @endpush