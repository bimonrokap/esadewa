@extends('template.admin.content')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--mobile m-portlet--tabs">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-pencil"></i>
                            </span>
                            <h3 class="m-portlet__head-text"> Edit Aset {{ $config['pageTitle'] }}</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs-line m-tabs-line--brand m-tabs-line--2x m-tabs-line--right" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_6_1" role="tab">
                                    <i class="fa fa-user" aria-hidden="true"></i> Profil
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2" role="tab">
                                    <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <form class="m-form m-form--label-align-right" action="{{ route($config['route'] . '.update', $data->id) }}" method="POST" id="form">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <div class="m-portlet__body">
                        @component('admin.components.form.alert') @endcomponent
                        <div class="tab-content">
                            <div class="tab-pane m-form-custom active" id="m_tabs_6_1" role="tabpanel">
                                <div class="m-form__section m-form__section--first">
                                    <div class="form-group m-form__group row">
                                        <div class="col-md-12">
                                            <a href="javascript:;" class="thumbnail" style="width: 500px;height: 250px;display: block;margin: auto;border: 1px solid #e0e0e0;padding: 5px;">
                                                <img src="{{ $preview }}" style='height: 100%; width: 100%; object-fit: contain;display: block; '>
                                            </a>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group m-form__group row">
                                        <label class="col-md-2 col-form-label"> Kode Satker : </label>
                                        <div class="col-md-4">
                                            <p class="m-form__control-static">{{ $data->kode_satker }}</p>
                                        </div>
                                        <label class="col-md-2 col-form-label"> Nama Satker : </label>
                                        <div class="col-md-4">
                                            <p class="m-form__control-static">{{ $data->nama_satker }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label class="col-md-2 col-form-label"> Nama Asset : </label>
                                        <div class="col-md-4">
                                            <p class="m-form__control-static">{{ $data->nama_barang }}</p>
                                        </div>
                                        <label class="col-md-2 col-form-label"> Kode Barang : </label>
                                        <div class="col-md-4">
                                            <p class="m-form__control-static">{{ $data->kode_barang }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label class="col-md-2 col-form-label"> Nomor Aset/NUP : </label>
                                        <div class="col-md-4">
                                            <p class="m-form__control-static">{{ $data->nup }}</p>
                                        </div>
                                        <label class="col-md-2 col-form-label"> Merk/Type : </label>
                                        <div class="col-md-4">
                                            <p class="m-form__control-static">{{ $data->merk }} </p>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label class="col-md-2 col-form-label"> No Polisi : </label>
                                        <div class="col-md-4">
                                            <p class="m-form__control-static">{{ $data->no_polisi }}</p>
                                        </div>
                                        <label class="col-md-2 col-form-label"> Pemakai : </label>
                                        <div class="col-md-4">
                                            <p class="m-form__control-static"> {{ @$variables['pemakai']->value }}  </p>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label class="col-md-2 col-form-label"> Tanggal Perolehan : </label>
                                        <div class="col-md-4">
                                            <p class="m-form__control-static">{{ $data->tgl_perolehan == null ? '' : \Carbon\Carbon::parse($data->tgl_perolehan)->format('j F Y') }}</p>
                                        </div>
                                        <label class="col-md-2 col-form-label"> Nilai : </label>
                                        <div class="col-md-4">
                                            <p class="m-form__control-static">{{ 'Rp '.numberFormatIndo($data->nilai_perolehan) }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label class="col-md-2 col-form-label"> Kondisi : </label>
                                        <div class="col-md-4">
                                            <p class="m-form__control-static">{{ $data->kondisi }}</p>
                                        </div>
                                        <label class="col-md-2 col-form-label"> Bukti Kepemilikan : </label>
                                        <div class="col-md-4">
                                            <p class="m-form__control-static">{{ $data->no_bpkb }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-md-2 col-form-label"> Nama Kepemilikan Kendaraan : </label>
                                    <div class="col-md-4">
                                        <p class="m-form__control-static">{{ $data->nama_satker }}</p>
                                    </div>
                                    <label class="col-md-2 col-form-label"> Status Penggunaan : </label>
                                    <div class="col-md-4">
                                        <p class="m-form__control-static"> {{ $data->status_penggunaan }} </p>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-md-2 col-form-label"> Tanggal dan Nomor PSP : </label>
                                    <div class="col-md-4">
                                        <p class="m-form__control-static">{{ in_array($data->tgl_psp, [null, 'null']) ? '' : \Carbon\Carbon::parse($data->tgl_psp)->format('j F Y') . ', ' . $data->no_psp }}</p>
                                    </div>
                                    <label class="col-md-2 col-form-label"> Tanggal Terakhir Upload Data : </label>
                                    <div class="col-md-4">
                                        <p class="m-form__control-static"> {{ $data->tanggal_update }} </p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label"> Pemakai </label>
                                    <div class="col-lg-2">
                                        <input type="text" class="form-control m-input m-input--solid" name="pemakai" placeholder="Pemakai" value="{{ @$variables['pemakai']->value }}" />
                                    </div>
                                </div>
                                @for($i = 1;$i <= 3;$i++)
                                    <div class="form-group m-form__group row no-padding">
                                        <label class="col-lg-3 col-form-label"> @if($i == 1) Foto @endif </label>
                                        <div class="col-lg-3">
                                            <div class="custom-file">
                                                <input name="foto[{{ $i }}]" type="file" class="custom-file-input">
                                                <label class="custom-file-label"> Pilih Gambar </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <input type="text" class="form-control m-input m-input--solid" name="caption[{{ $i }}]" placeholder="Caption Gambar" value="{{ @$dataImages[$i-1]['opts']['caption'] }}" />
                                        </div>
                                        <div class="col-lg-3">
                                            @if(isset($dataImages[$i-1]))
                                                <a style="display: block;" target="_blank" href="{{ $dataImages[$i-1]['src'] }}">Foto</a>
                                                <input name="hapus[{{ $i }}]" type="checkbox" value="{{ $i }}" /> Hapus
                                            @endif
                                        </div>
                                    </div>
                                @endfor
                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label"> Video </label>
                                    <div class="col-lg-3">
                                        <div class="custom-file">
                                            <input name="video" type="file" class="custom-file-input">
                                            <label class="custom-file-label"> Pilih Video </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control m-input m-input--solid" name="captionVideo" placeholder="Caption Video" value="{{ @$video->caption }}" />
                                    </div>
                                    <div class="col-lg-3">
                                        @if($video != null)
                                            <a style="display: block;" target="_blank" href="{{ asset($video->file) }}">Video</a>
                                            <input name="hapusVideo" type="checkbox" value="1" /> Hapus
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route($config['route'] . '.edit', $data->id) }}" id="reload" class="ajaxify" style="display: none;"></a>
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
            var options = {
                'form' : '#form'
            };

            $(".thumbnail").click(function() {
                $.fancybox.open({!! json_encode($images) !!}, {
                    animationEffect: "zoom-in-out"
                });
            });

            FormValidation.init(options);
        });
    </script>
    @endpush