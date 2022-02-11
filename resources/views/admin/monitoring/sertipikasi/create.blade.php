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
                            <h3 class="m-portlet__head-text"> Usulan {{ $config['pageTitle'] }}</h3>
                        </div>
                    </div>
                </div>
                <form class="m-form m-form--label-align-right" action="{{ route($config['route'] . '.store') }}" method="POST" id="form">
                    {{ csrf_field() }}
                    <div class="m-portlet__body">
                        @component('admin.components.form.alert') @endcomponent
                        <div class="m-form__section m-form__section--first">
                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label"> Satker <span class="required">*</span> </label>
                                <div class="col-lg-4">
                                    <select name="satker" class="form-control m-input select2 required" id="input-satker" style="width: 100%">
                                        <option value=""> Pilih Satker </option>
                                        @foreach($satkers as $row)
                                            <option value="{{ $row->kode }}"> {{ $row->name }} </option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label"> Jumlah Anggaran <span class="required">*</span> </label>
                                <div class="col-lg-3">
                                    <div class="input-group m-input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> Rp </span>
                                        </div>
                                        <input type="text" class="form-control m-input harga required" name="jumlah_anggaran" placeholder="Jumlah Anggaran" />
                                    </div>
                                </div>
                            </div>

                            @component('admin.components.usulan.tablebarang', ['config' => $config]) @endcomponent
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

    @component('admin.components.usulan.modalbarang', ['kategoriBarang' => $kategoriBarang]) @endcomponent
    @endsection

@push('scripts')
    <script src="{{ asset('assets/app/js/datatable.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        var jmlBarang = 0;
        $(document).ready(function () {
            Barang.init({
                url: "{{ route($config['route'] . '.gettable') }}",
                addons: { doc : 'sertipikasi' },
                maxBarang: 1,
                param: { 'kode_satker': function () {
                    return $('#input-satker').val();
                }},
                reloadOnOpen: true
            });

            $('.select2').select2();
            $('.harga').inputmask('numeric', {
                digits: 0,
                groupSeparator: '.',
                radixPoint: ",",
                removeMaskOnSubmit: false,
                autoGroup: true
            });

            var options = {
                'form' : '#form',
                'data': {
                    'data' : function () {
                        var id = [];
                        var category = [];
                        $('.btn-hapus', '#con-barang').each(function (index, value) {
                            id.push($(this).data('id'));
                            category.push($(this).data('category'));
                        });

                        return JSON.stringify({'category': category, 'id': id});
                    }
                }
            };

            FormValidation.init(options);
        });
    </script>
    @endpush