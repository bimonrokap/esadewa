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
                            <h3 class="m-portlet__head-text"> Balas {{ $config['pageTitle'] }}</h3>
                        </div>
                    </div>
                </div>
                <form class="m-form m-form--label-align-right" action="{{ route($config['route'] . '.update', $data->id) }}" method="POST" id="form">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <div class="m-portlet__body">
                        @component('admin.components.form.alert') @endcomponent
                        <div class="m-form__section m-form__section--first">
                            @if($data->id_asset == null)
                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label"> Kategori Aset </label>
                                <div class="col-lg-3">
                                    <span class="form-control-static">{{ $categoryAsset[$data->id_category_asset] }}</span>
                                </div>
                                <label class="col-lg-2 col-form-label"> Jenis Lapor </label>
                                <div class="col-lg-3">
                                    <span class="form-control-static">{{ $data->jenis == 1 ? 'Permasalahan Umum' : 'Force Majeure' }}</span>
                                </div>
                            </div>
                            @else
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
                                                <td>{{ $det }}</td>
                                                @if($i%2 == 1) </tr> @endif
                                            @php $i++ @endphp
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label"> Uraian </label>
                                <div class="col-lg-8">
                                    <p class="form-control-static">{!! nl2br($data->uraian) !!}</p>
                                </div>
                            </div>
                            @if($data->file != null)
                                <div class="form-group m-form__group row">
                                    <label class="col-lg-2 col-form-label"> File </label>
                                    <div class="col-lg-8">
                                        <p class="form-control-static">
                                            @include('components.form.fileButton', ['title' => 'File', 'type' => 'pdf', 'url' => \App\Model\LaporBmn\LaporBmn::docLocation($data->id, $data->file, true)])
                                        </p>
                                    </div>
                                </div>
                            @endif
                            @if($data->foto->count() > 0)
                                <div class="form-group m-form__group row">
                                    <label class="col-lg-2 col-form-label"> Foto </label>
                                    <label class="col-lg-10">
                                        <div class="con-image gallery-con-image" style="text-align: left;">
                                            @foreach($data->foto as $foto)
                                                <div>
                                                    <a class="image" href="{{ \App\Model\LaporBmn\LaporBmnFoto::imageLocation($data->id, $foto->foto, true) }}">
                                                        <img src="{{ \App\Model\LaporBmn\LaporBmnFoto::imageLocation($data->id, $foto->foto, true) }}" />
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </label>
                                </div>
                            @endif
                                @if($data->reply->isNotEmpty())
                                    @foreach($data->reply as $row)
                                        <hr>
                                        <div class="form-group m-form__group row">
                                            <label class="col-lg-2 col-form-label"> Jawaban </label>
                                            <div class="col-lg-8">
                                                <p class="form-control-static">{!! nl2br($row->jawaban) !!}</p>
                                            </div>
                                        </div>
                                        @if($row->file != null)
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-2 col-form-label"> File </label>
                                                <div class="col-lg-8">
                                                    <p class="form-control-static">
                                                        @include('components.form.fileButton', ['title' => 'File', 'type' => 'pdf', 'url' => \App\Model\LaporBmn\LaporBmn::balasLocation($data->id, $row->file, true)])
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="form-group m-form__group row">
                                            <label class="col-lg-2 col-form-label"> Oleh </label>
                                            <div class="col-lg-8">
                                                <p class="form-control-static">{{ $row->user->name }}
                                                    @if($data->created_by == $row->created_by)
                                                        <span class="m-badge m-badge--info m-badge--wide">Pelapor</span>
                                                    @else
                                                        <span class="m-badge m-badge--warning m-badge--wide">Admin</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-lg-2 col-form-label"> Tanggal </label>
                                            <div class="col-lg-8">
                                                <p class="form-control-static">{{ \Carbon\Carbon::parse($row->created_at)->format('j F Y, H:i') }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <hr>
                                <div class="form-group m-form__group row">
                                    <label class="col-lg-2 col-form-label"> Jawaban <span class="required">*</span> </label>
                                    <div class="col-lg-8">
                                        <textarea name="jawaban" class="form-control m-input" rows="6" placeholder="Jawaban"></textarea>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-lg-2 col-form-label"> File </label>
                                    <div class="col-lg-8">
                                        <div class="custom-file">
                                            <input name="balas_file" type="file" accept="application/pdf" class="custom-file-input">
                                            <label class="custom-file-label"> Pilih File </label>
                                        </div>
                                        <span class="m-form__help">File ekstensi PDF, maximal 5Mb</span>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <a href="{{ route($config['route'] . '.index') }}" id="reload" class="ajaxify" style="display: none;"></a>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    @permission('selesai-lapor', $data)
                                    <button type="submit" name="submit" class="btn btn-warning" value="2"> Selesai </button>
                                    @endpermission
                                    <button type="submit" name="submit" class="btn btn-success" value="1"> Simpan </button>
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