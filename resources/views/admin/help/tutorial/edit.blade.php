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
                            <h3 class="m-portlet__head-text"> Edit {{ $config['pageTitle'] }} : {{ $data->filename }}</h3>
                        </div>
                    </div>
                </div>
                <form class="m-form m-form--label-align-right" action="{{ route($config['route'] . '.update', $id) }}" method="POST" id="form">
                    {{ csrf_field() }}
                    {{ method_field('patch') }}
                    <div class="m-portlet__body">
                        @component('admin.components.form.alert') @endcomponent
                        <div class="m-form__section m-form__section--first">
                            @if($data->type == 'folder')
                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label"> Folder </label>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control m-input m-input--solid required" name="filename" value="{{ $data->filename }}" placeholder="Nama Folder" />
                                    </div>
                                </div>
                            @else
                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label"> File </label>
                                    <div class="col-lg-4">
                                        <div class="custom-file">
                                            <input name="file" type="file" class="custom-file-input" id="customFile">
                                            <label class="custom-file-label" for="customFile">
                                                Pilih File
                                            </label>
                                        </div>
                                        <span class="m-form__help"><a href="{{ asset('file/tutorials/'.$data->file) }}" target="_blank"> {{ $data->filename }}</a></span>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label"> Order </label>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control m-input m-input--solid required" name="order" placeholder="Urutan" value="{{ $data->order }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route($config['route'] . '.data', ['id' => $data->id_parent]) }}" id="reload" class="ajaxify" style="display: none;"></a>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button type="submit" class="btn btn-success"> Simpan </button>
                                    <a href="{{ route($config['route'] . '.data', ['id' => $data->id_parent]) }}" class="ajaxify"> <button type="button" class="btn btn-secondary"> Kembali </button></a>
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