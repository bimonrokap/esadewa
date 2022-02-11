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
                    @include('components.import.button')
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
    @endsection
