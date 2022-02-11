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
                            <h3 class="m-portlet__head-text"> Edit {{ $config['pageTitle'] }}</h3>
                        </div>
                    </div>
                </div>
                <form class="m-form m-form--label-align-right" action="{{ route($config['route'] . '.update', $data->id) }}" method="POST" id="form">
                    {{ csrf_field() }}
                    {{ method_field("patch") }}
                    <div class="m-portlet__body">
                        @component('admin.components.form.alert') @endcomponent
                        <div class="m-form__section m-form__section--first">
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label"> Lingkungan </label>
                                <div class="col-lg-4">
                                    <select name="lingkungan" class="form-control m-input m-input--solid select2" style="width: 100%;">
                                        <option value="">Pilih Lingkungan</option>
                                        <option {!! $data->lingkungan == 'PN' ? 'selected="selected"' : '' !!} value="PN">Peradilan Umum</option>
                                        <option {!! $data->lingkungan == 'PA' ? 'selected="selected"' : '' !!} value="PA">Peradilan Agama</option>
                                        <option {!! $data->lingkungan == 'PM' ? 'selected="selected"' : '' !!} value="PM">Peradilan Militer</option>
                                        <option {!! $data->lingkungan == 'PT' ? 'selected="selected"' : '' !!} value="PT">Peradilan Tata Usaha</option>
                                        <option {!! $data->lingkungan == 'PMT' ? 'selected="selected"' : '' !!} value="PMT">Peradilan Militer & Tata Usaha</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label"> Wilayah </label>
                                <div class="col-lg-4">
                                    <select name="id_wilayah" class="form-control m-input m-input--solid select2" style="width: 100%;">
                                        <option value="">Pilih Wilayah</option>
                                        @foreach($wilayah as $w)
                                            <option {!! $data->id_wilayah == $w->id ? 'selected="selected"' : '' !!} value="{{ $w->id }}">{{ $w->name . ' ( '.$w->code.' )' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label"> Satker </label>
                                <div class="col-lg-9">
                                    <select name="id_satker[]" class="form-control m-input m-input--solid select2 required" multiple="multiple">
                                        <option value="">Pilih Satker</option>
                                        @foreach($satkers as $satker)
                                            <option {{ in_array($satker->id, $dataSatker) ? 'selected="selected"' : '' }} value="{{ $satker->id }}">{{ $satker->name.'('.$satker->kode.')' }}</option>
                                        @endforeach
                                    </select>
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