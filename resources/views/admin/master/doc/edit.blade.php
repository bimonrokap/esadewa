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
                            <h3 class="m-portlet__head-text"> Edit {{ $config['pageTitle'] . ' : ' . $data->name }}</h3>
                        </div>
                    </div>
                </div>
                <form class="m-form m-form--label-align-right" action="{{ route($config['route'] . '.update', $history->id) }}" method="POST" id="form">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <div class="m-portlet__body">
                        @component('admin.components.form.alert') @endcomponent
                        <div class="m-form__section m-form__section--first">
                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label"> Versi </label>
                                <div class="col-lg-4">
                                    <input type="text" value="{{ $history->version }}" class="form-control m-input m-input--solid required" name="version" placeholder="Versi" />
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label"> Dokumen </label>
                                <div class="col-lg-4">
                                    <div class="custom-file">
                                        <input name="file" type="file" class="custom-file-input required">
                                        <label class="custom-file-label"> Pilih File </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route($config['route'] . '.show', ['id' => $data->id]) }}" id="reload" class="ajaxify" style="display: none;"></a>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button type="submit" class="btn btn-success"> Simpan </button>
                                    <a href="{{ route($config['route'] . '.show', ['id' => $data->id]) }}" class="ajaxify"> <button type="button" class="btn btn-secondary"> Kembali </button></a>
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
    <script src="{{ asset('assets/vendors/custom/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            FormValidation.init({ 'form' : '#form'});
        });
    </script>
    @endpush