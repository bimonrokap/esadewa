@extends('template.admin.content')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-eye"></i>
                            </span>
                            <h3 class="m-portlet__head-text"> Detail {{ $config['pageTitle'] }}</h3>
                        </div>
                    </div>
                </div>
                <form class="m-form m-form--label-align-right" action="{{ route($config['route'] . '.selesai', $data->id) }}" method="POST" id="form">
                    {{ csrf_field() }}
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
                        </div>
                    </div>
                    <a href="{{ route($config['route'] . '.index') }}" id="reload" class="ajaxify" style="display: none;"></a>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    @if(Permission::can('create-' . $config['permission']) && $data->status == 1)
                                    <button type="submit" class="btn btn-success"> Selesai </button>
                                    @endif
                                    <a href="{{ route($config['route'] . '.index') }}" class="ajaxify"> <button type="button" class="btn btn-secondary"> Kembali </button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            @foreach($details as $k => $list)
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text"> Detail Tindak Lanjut Ke-{{ $k+1 }}</h3>
                            </div>
                        </div>
                    </div>
                    <form class="m-form m-form--label-align-right" action="#" method="POST" id="form">
                        <div class="m-portlet__body">
                            <div class="m-form-custom-5 row">
                                <div class="col-lg-6">
                                    <div class="form-group m-form__group">
                                        <label for="inputLetterNumber"> No Surat </label>
                                        <p class="form-control-static">{{ $list->letter_number }}</p>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label> Dokumen </label>
                                        <p class="form-control-static">
                                            @include('components.form.fileButton', ['title' => 'Surat Pengantar Tingkat Banding', 'type' => 'pdf', 'url' => \App\Model\Sertipikasi\SertipikasiTanahDetail::docLocation($data->id, $list->dokumen, true)])
                                        </p>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label for="inputPerihalSurat"> Catatam </label>
                                        <p class="form-control-static">{!! nl2br($list->catatan) !!}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group m-form__group">
                                        <label for="inputLetterDate"> Tanggal Surat </label>
                                        <p class="form-control-static">{{ \Carbon\Carbon::parse($list->letter_date)->format('j F Y') }}</p>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label for="inputPerihalSurat"> Perihal Surat </label>
                                        <p class="form-control-static">{!! nl2br($list->perihal) !!}</p>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label for="inputPerihalSurat"> Oleh </label>
                                        <p class="form-control-static">{{ $list->name. ($list->nip != null ? ' ('.$list->nip.')' : '') }}</p>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label for="inputPerihalSurat"> Tanggal Tindak Lanjut </label>
                                        <p class="form-control-static">{{ \Carbon\Carbon::parse($list->created_at)->format('j F Y, H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @endforeach
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