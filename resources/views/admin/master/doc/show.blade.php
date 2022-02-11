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
                            <h3 class="m-portlet__head-text"> Detail {{ $config['pageTitle'] }} : {{ $data->name }}</h3>
                        </div>
                    </div>
                </div>
                <form class="m-form m-form--label-align-right" action="{{ route($config['route'] . '.store') }}" method="POST" id="form">
                    {{ csrf_field() }}
                    <div class="m-portlet__body">
                        @component('admin.components.form.alert') @endcomponent
                        @permission('create-' . $config['permission'])
                            <div class="row">
                                <div class="col-sm-12 text-right">
                                    <a href="{{ route($config['route'] . '.create', ['id' => $data->id]) }}" class="ajaxify"> <button type="button" class="btn btn-primary"> <i class="la la-plus"></i> Tambah Dokumen </button></a>
                                </div>
                            </div>
                            @endpermission

                        <table class="table table-striped table-bordered m-table m-table--head-bg-success">
                            <thead>
                                <tr>
                                    <th width="10px"> No </th>
                                    <th> Versi </th>
                                    <th width="50px"> Dokumen </th>
                                    <th width="120px"> Tanggal </th>
                                    <th width="120px"> Default </th>
                                    <th width="50px"> Aksi </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($data->history->isEmpty())
                                    <tr>
                                        <th id="empty-row" colspan="6" class="text-center"> Data Kosong! </th>
                                    </tr>
                                    @endif

                                @foreach($data->history as $key => $history)
                                    <tr>
                                        <td class="text-center">{{ ++$key }}</td>
                                        <td>{{ $history->version }}</td>
                                        <td>{{ $history->version }}</td>
                                        <td>
                                            <a href="{{ route($config['route'] . '.generate', ['id' => $history->id]) }}" class="btn btn-primary btn-sm"> <i class="la la-download"></i> Download</a>
                                        </td>
                                        <td class="text-center">
                                            <input {!! $data->id_default_doc_template_history == $history->id ? 'checked="checked"' : '' !!} class="default" name="default" type="radio" value="{{ $history->id }}" />
                                        </td>
                                        <td class="text-center">
                                            @permission('edit-' . $config['permission'])
                                            <a href="{{ route($config['route'] . '.edit', ['id' => $history->id]) }}" class="btn m-btn--icon m-btn--icon-only btn-info btn-xs ajaxify"> <i class="la la-pencil"></i> </a>
                                            @endpermission
                                        </td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route($config['route'] . '.index') }}" id="reload" class="ajaxify" style="display: none;"></a>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <div class="row">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-9 text-right">
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
    <script type="text/javascript">
        $(document).ready(function () {
            $('.default').click(function () {
                var val = $(this).val();

                $.post("{{ route($config['route'] . '.default', $data->id) }}", {value: val}, function (res) {
                    if(res.status == 1) {
                        $.notify("Berhasil merubah default template!", {
                            type: "success",
                            allow_dismiss: true,
                            timer: 1000,
                            delay: 3000,
                            animate: {
                                enter: 'animated bounceIn',
                                exit: 'animated bounceOut'
                            }
                        });
                    } else {
                        $.notify("Gagal", {
                            type: "danger",
                            allow_dismiss: true,
                            timer: 1000,
                            delay: 3000,
                            animate: {
                                enter: 'animated bounceIn',
                                exit: 'animated bounceOut'
                            }
                        });
                    }
                })
            })
        })
    </script>
    @endpush