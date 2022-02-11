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
                            <h3 class="m-portlet__head-text"> Tindak Lanjut {{ $config['pageTitle'] }}</h3>
                        </div>
                    </div>
                </div>
                <form class="m-form m-form--label-align-right" action="{{ route($config['route'] . '.update', $data->id) }}" method="POST" id="form">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <div class="m-portlet__body">
                        @component('admin.components.form.alert') @endcomponent
                        <div class="m-form__section m-form__section--first">
                            <div class="form-group m-form__group row">
                                <div class="col-lg-12" id="con-detail-aset">
                                    <table class="table table-bordered m-table m-table--head-bg-metal table-detail-aset">
                                        <thead>
                                        <tr><th colspan="4" class="text-center" style="font-size: 1.5rem;">Detail Asset</th></tr>
                                        </thead>
                                        <tbody>
                                        @php $i = 0 @endphp
                                        @foreach($detail as $k => $det)
                                            @if($i%2 == 0) <tr> @endif
                                                <th scope="row" width="200px"> {{ $k }} </th>
                                                <td>{!!  $det !!}</td>
                                                @if($i%2 == 1) </tr> @endif
                                            @php $i++ @endphp
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="m-form-custom-5 row">
                                <div class="col-lg-6">
                                    <div class="form-group m-form__group">
                                        <label for="inputLetterNumber"> No Surat  <span class="required">*</span> </label>
                                        <input type="text" class="form-control m-input required" id="inputLetterNumber"  name="letter_number" placeholder="No Surat" />
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label> Dokumen <span class="required">*</span> </label>
                                        <div class="custom-file">
                                            <input name="dokumen" type="file" accept="application/pdf" class="custom-file-input required">
                                            <label class="custom-file-label">
                                                Pilih File
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label for="inputCatatan"> Catatan Tindak Lanjut  <span class="required">*</span> </label>
                                        <textarea class="form-control m-input required" id="inputCatatan" name="catatan" placeholder="Catatan Tindak Lanjut" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group m-form__group">
                                        <label for="inputLetterDate"> Tanggal Surat  <span class="required">*</span> </label>
                                        <div class="input-group date">
                                            <input type="text" class="form-control m-input required m_datepicker required" id="inputLetterDate" readonly name="letter_date" placeholder="Tanggal Surat" />
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label for="inputPerihalSurat"> Perihal Surat  <span class="required">*</span> </label>
                                        <textarea class="form-control m-input required" id="inputPerihalSurat" name="perihal" placeholder="Perihal Surat" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route($config['route'] . '.index') }}" id="reload" class="ajaxify" style="display: none;"></a>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button type="submit" class="btn btn-success"> Tindak Lanjut </button>
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

            $('.m_datepicker').datepicker({
                autoclose: true,
                todayBtn: "linked",
                clearBtn: true,
                todayHighlight: true,
                format: 'd MM yyyy',
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            });

            var options = {
                'form' : '#form'
            };

            FormValidation.init(options);
        });
    </script>
    @endpush