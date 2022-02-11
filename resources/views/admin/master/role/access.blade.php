@extends('template.admin.content')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-lock"></i>
                            </span>
                            <h3 class="m-portlet__head-text"> {{ $config['pageTitle'] }} Akses : {{ $data->name }}</h3>
                        </div>
                    </div>
                </div>
                <form class="m-form m-form--label-align-right" action="{{ route($config['route'] . '.storeaccess', $data->id) }}" method="POST" id="form">
                    {{ csrf_field() }}
                    <div class="m-portlet__body">
                        @component('admin.components.form.alert') @endcomponent
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Start: General Rule -->
                                <h4 class="form-section" style="margin-bottom: 5px;"><strong>General Rule</strong></h4>
                                <div class="table-scrollable">
                                    {!! $htmlGeneralPermission !!}
                                </div>
                                <!-- End: General Rule -->

                                <!-- Start: Special Rule -->
                                <h4 class="form-section" style="margin-bottom: 5px;"><strong>Special Rule</strong></h4>
                                <div class="table-scrollable">
                                    <table class="table table-advance table-rule table-hover table-bordered table-role m-table m-table--head-bg-brand">
                                        <thead>
                                        <tr>
                                            <th width="30px" class="text-center">No</th>
                                            <th class="text-center">Menu</th>
                                            <th class="text-center" colspan="4">Rule</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($specialMenu as $key => $menu)
                                            <tr>
                                                <td rowspan="2" class="text-center">{{ $key + 1 }}</td>
                                                <td rowspan="2"><strong>{{ $menu->title }}</strong></td>
                                                @for($i = 0; $i < 4; $i++)
                                                    @if(isset($menu->permission[$i]))
                                                        <?php $row = $menu->permission[$i] ?>
                                                        <td width="150px" align="center" class="dark">
                                                            <strong>{{ $row->display_name }}</strong>
                                                            <i style="cursor: help;" class="fa fa-info-circle tooltips" data-container="body" data-placement="top" data-original-title="{{ $row->desc }}"></i>
                                                        </td>
                                                    @else
                                                        <td width="150px" class="disabled"></td>
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                @for($i = 0; $i < 4; $i++)
                                                    @if(isset($menu->permission[$i]))
                                                        <?php $row = $menu->permission[$i] ?>

                                                        <td align="center">
                                                            <label>
                                                                <input type="checkbox" {{ $selfRole->contains($row->id) ? 'checked' : '' }} name="permission[]" value="{{ $row->id }}">
                                                            </label>
                                                        </td>
                                                    @else
                                                        <td width="150px" class="disabled"></td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- End: Special Rule -->
                            </div>
                        </div>
                    </div>
                    <a href="{{ route($config['route'] . '.index') }}" id="reload" class="ajaxify" style="display: none;"></a>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button type="submit" class="btn btn-success"> Simpan </button>
                                    <a href="{{ route($config['route'] . '.index') }}"> <button type="button" class="btn btn-secondary"> Kembali </button></a>
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

            $('.parent').click(function () {
                if($(this).next('.child').length){
                    $(this).next().toggle();
                }
            })
        });
    </script>
    @endpush