@extends('template.admin.content')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"> Daftar Backup Simak </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <button type="button" class="m-portlet__nav-link btn btn-success btn-sm m-btn m-btn--icon" data-toggle="modal" data-target="#modalFilter">
                                    <i class="la la-filter"></i> Filter
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="table-responsive" id="con-table-backup">
                        <table class="table table-striped table-bordered table-hover m-table m-table--border-metal m-table--head-bg-info">
                            <thead>
                            <tr>
                                <th rowspan="2" width="50px" class="text-center">No</th>
                                <th rowspan="2" class="text-center">Satker</th>
                                <th colspan="12" class="text-center">Tahun {{ $year }}</th>
                            </tr>
                            <tr>
                                @for($i = 1;$i <= 12;$i++)
                                    <th class="text-center" width="60px">{{ \Carbon\Carbon::createFromFormat('d-n', '1-'.$i)->format('M') }}</th>
                                @endfor
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $k => $r)
                                    <tr>
                                        <td class="text-center">{{ $k + 1 }}</td>
                                        <td>{!! $r['name'] . ' (<strong>'.$r['kode'].'</strong>)' !!}</td>
                                        @for($i = 1;$i <= 12;$i++)
                                            @php
                                                $file = '-';
                                                if(isset($r['data'][$year.'-'.(substr('0'.$i, -2)).'-01'])) {
                                                    $item = $r['data'][$year.'-'.(substr('0'.$i, -2)).'-01'];
                                                    $file = '<img class="tooltips data-download" data-id="'.$item['idFile'].'" title="Upload at '.\Carbon\Carbon::parse($item['updated_at'])->format('j F Y').'<br>
                                                    '.$item['userName'].' ('.$item['nip'].')" width="20px" src="'.asset('assets/app/media/img/icon/icon_download.png').'" />';
                                                }
                                            @endphp
                                            <th class="text-center con-upload-simak">{!! $file !!} </th>
                                        @endfor
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalFilter" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Tampilkan  </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> &times; </span>
                    </button>
                </div>
                <form class="m-form m-form--label-align-right" action="" method="GET" id="form-import">
                    <div class="modal-body">
                        <div class="m-form__section m-form__section--first">
                            <div class="form-group m-form__group row">
                                <label class="col-md-3 col-form-label"> Reset </label>
                                <div class="col-md-3">
                                    <a href="{{ route($config['route'] . '.index') }}" class="btn btn-danger btn-sm">
                                        <i class="la la-times"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label"> Tahun </label>
                                <div class="col-lg-3">
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-center m-input yearInput" name="year" value="{{ $year }}">
                                    </div>
                                </div>
                            </div>
                            @if($viewAllAsset)
                                <div class="form-group m-form__group row filter" data-id="lingkungan">
                                    <label class="col-md-3 col-form-label"> Lingkungan </label>
                                    <div class="col-md-6">
                                        <select name="filter[lingkungan]" class="form-control select2" style="width: 100%;">
                                            <option value="">Pilih</option>
                                            @foreach($lingkungans as $k => $lingkungan)
                                                <option {!! isset($request['filter']['lingkungan']) && $request['filter']['lingkungan'] == $k ? 'selected="selected"' : '' !!} value="{{ $k }}">{{ $lingkungan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row filter" data-id="wilayah">
                                    <label class="col-md-3 col-form-label"> Wilayah </label>
                                    <div class="col-md-6">
                                        <select name="filter[wilayah]" class="form-control select2" style="width: 100%;">
                                            <option value="">Pilih</option>
                                            @foreach($wilayahs as $wilayah)
                                                <option {!! isset($request['filter']['wilayah']) && $request['filter']['wilayah'] == $wilayah->id ? 'selected="selected"' : '' !!} value="{{ $wilayah->id }}">{{ $wilayah->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row filter" data-id="satker">
                                    <label class="col-md-3 col-form-label"> Satker </label>
                                    <div class="col-md-7">
                                        <select name="filter[satker]" class="form-control select2" style="width: 100%;">
                                            <option value="">Pilih</option>
                                            @foreach($satkers as $satker)
                                                <option {!! isset($request['filter']['satker']) && $request['filter']['satker'] == $satker->kode ? 'selected="selected"' : '' !!} value="{{ $satker->kode }}">{{ $satker->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @elseif($viewAllWilayahAsset && $viewAllLingkunganAsset)
                                <div class="form-group m-form__group row filter" data-id="satker">
                                    <label class="col-md-3 col-form-label"> Satker </label>
                                    <div class="col-md-7">
                                        <select name="filter[satker]" class="form-control select2" style="width: 100%;">
                                            <option value="">Pilih</option>
                                            @foreach($satkers as $satker)
                                                <option {!! isset($request['filter']['satker']) && $request['filter']['satker'] == $satker->kode ? 'selected="selected"' : '' !!} value="{{ $satker->kode }}">{{ $satker->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @elseif($viewAllWilayahAsset)
                                <div class="form-group m-form__group row filter" data-id="lingkungan">
                                    <label class="col-md-3 col-form-label"> Lingkungan </label>
                                    <div class="col-md-6">
                                        <select name="filter[lingkungan]" class="form-control select2" style="width: 100%;">
                                            <option value="">Pilih</option>
                                            @foreach($lingkungans as $k => $lingkungan)
                                                <option {!! isset($request['filter']['lingkungan']) && $request['filter']['lingkungan'] == $k ? 'selected="selected"' : '' !!} value="{{ $k }}">{{ $lingkungan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row filter" data-id="satker">
                                    <label class="col-md-3 col-form-label"> Satker </label>
                                    <div class="col-md-7">
                                        <select name="filter[satker]" class="form-control select2" style="width: 100%;">
                                            <option value="">Pilih</option>
                                            @foreach($satkers as $satker)
                                                <option {!! isset($request['filter']['satker']) && $request['filter']['satker'] == $satker->kode ? 'selected="selected"' : '' !!} value="{{ $satker->kode }}">{{ $satker->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @elseif($viewAllLingkunganAsset)
                                <div class="form-group m-form__group row filter" data-id="wilayah">
                                    <label class="col-md-3 col-form-label"> Wilayah </label>
                                    <div class="col-md-6">
                                        <select name="filter[wilayah]" class="form-control select2" style="width: 100%;">
                                            <option value="">Pilih</option>
                                            @foreach($wilayahs as $wilayah)
                                                <option {!! isset($request['filter']['wilayah']) && $request['filter']['wilayah'] == $wilayah->id ? 'selected="selected"' : '' !!} value="{{ $wilayah->id }}">{{ $wilayah->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row filter" data-id="satker">
                                    <label class="col-md-3 col-form-label"> Satker </label>
                                    <div class="col-md-7">
                                        <select name="filter[satker]" class="form-control select2" style="width: 100%;">
                                            <option value="">Pilih</option>
                                            @foreach($satkers as $satker)
                                                <option {!! isset($request['filter']['satker']) && $request['filter']['satker'] == $satker->kode ? 'selected="selected"' : '' !!} value="{{ $satker->kode }}">{{ $satker->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> Tutup </button>
                        <a href="{{ route($config['route'] . '.downloadBatchAll', $request['filter']) }}" class="btn btn-info m-btn m-btn--icon btn-batch-download">
                            <span>
                                <i class="la la-download"></i>
                                <span> Batch Download </span>
                            </span>
                        </a>
                        <button type="submit" class="btn btn-primary"> Simpan Filter  </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.tooltips').tooltip({html: true});

            $('.select2').select2();
            $('.yearInput').datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years"
            });

            $('#con-table-backup').on('click', '.data-download', function () {
                let id = $(this).data('id');

                window.location = '{{ route($config['route'].'.download') }}/'+id;
            });

            $('select[name="filter[wilayah]"]').change(function () {
                getSatker();
            });

            $('select[name="filter[lingkungan]"]').change(function () {
                getSatker();
            });

            $('.btn-batch-download').click(function () {
                let url = $(this).attr('href');
                let form = $(this).closest('form');

                window.location = url+'?'+form.serialize();

                return false;
            });

            function getSatker() {
                let wilayah = $('select[name="filter[wilayah]"]').val();
                let lingkungan = $('select[name="filter[lingkungan]"]').val();

                $.get('{{ route($config['route'] . '.getSatker') }}', {wilayah: wilayah, lingkungan: lingkungan}, function (res) {
                    var option = '<option value="">Pilih</option>';
                    $.each(res, function (index, value) {
                        option += '<option value="'+value.kode+'">'+value.name+'</option>';
                    });

                    $('select[name="filter[satker]"]').html(option);
                });
            }
        });
    </script>
    @endpush
