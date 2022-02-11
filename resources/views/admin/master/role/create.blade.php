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
                                <label class="col-lg-3 col-form-label"> Nama Role </label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control m-input m-input--solid required" name="name" placeholder="Nama Role" />
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label"> Role Induk </label>
                                <div class="col-lg-3">
                                    <select name="id_parent" class="form-control m-input m-input--solid select2 required">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label"> Level </label>
                                <div class="col-lg-2">
                                    <input type="text" class="form-control m-input m-input--solid required text-right" name="level" placeholder="Level" />
                                    <p class="help-block">Level Sekarang {{ $yourRole->level }}</p>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label"> Deskripsi </label>
                                <div class="col-lg-4">
                                    <textarea class="form-control m-input m-input--solid" name="description" placeholder="Deskripsi" rows="5"></textarea>
                                </div>
                            </div>
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

            var options = {
                'form' : '#form'
            };

            FormValidation.init(options);
        });
    </script>
    @endpush