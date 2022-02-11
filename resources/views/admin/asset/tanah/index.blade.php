@extends('template.admin.content')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"> Table {{ $config['pageTitle'] }}</h3>
                        </div>
                    </div>
{{--                    @include('components.import.button')--}}
                    @include('components.export.button')
                </div>
                <div class="m-portlet__body">
                    @include('components.asset.filter')
                    <!--begin: Datatable -->
                    @include( $config['route'] . '.table')
                </div>
            </div>
        </div>
    </div>

    @include('components.form.modalLaporBmn')
    @include('components.profil.asset.modal')
    @endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
             $('.table').on('click', '.btn-show', function () {
                 let url = $(this).data('url');
                 $.get(url, function (html) {
                     $('#modalShow .modal-body').html(html);

                     $('#modalShow').modal('show');
                 });
             });
        });
    </script>
@endpush