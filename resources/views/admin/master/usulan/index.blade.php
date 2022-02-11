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
                            <h3 class="m-portlet__head-text"> Edit {{ $config['pageTitle'] }}</h3>
                        </div>
                    </div>
                </div>
                <form class="m-form m-form--label-align-right" action="{{ route($config['route'] . '.store') }}" method="POST" id="form">
                    {{ csrf_field() }}
                    <div class="m-portlet__body">
                        @component('admin.components.form.alert') @endcomponent
                        <div class="m-form__section m-form__section--first">
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label"> Tahun </label>
                                <div class="col-lg-2">
                                    <select class="form-control m-input m-input--solid required" name="year">
                                        @for($i = date("Y");$i > $start;$i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label"> PSP </label>
                                <div class="col-lg-2">
                                    <input value="{{ @$manual['psp']->value }}" type="text" class="form-control m-input m-input--solid required text-right" name="psp" placeholder="PSP" />
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label"> Penghapusan </label>
                                <div class="col-lg-2">
                                    <input value="{{ @$manual['penghapusan']->value }}" type="text" class="form-control m-input m-input--solid required text-right" name="penghapusan" placeholder="Penghapusan" />
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

            $('select[name="year"]').change(function () {
                $.get('{{ route($config['route'] . '.data') }}', { year: $(this).val() }, function (res) {
                    $('input[name="psp"]').val(res.data.psp.value);
                    $('input[name="penghapusan"]').val(res.data.penghapusan.value);
                })
            });
        });
    </script>
    @endpush