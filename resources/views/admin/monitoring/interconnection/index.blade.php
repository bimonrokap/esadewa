@extends('template.admin.content')

@section('content')

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <!--begin::Portlet-->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide"> <i class="la la-gear"></i> </span>
                            <h3 class="m-portlet__head-text"> Status Interconnection </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body block-chart">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered  m-table m-table--head-bg-info table-hover">
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold">SIPERMARI Status</td>
                                    <td colspan="3" class="font-weight-bold">{!! $interConfig['status'] == 'online' ? '<span style="color: #28d228;">Online<spam>' : '<span style="color: red;">Offline<spam>' !!}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Tanggal Pengecekan Terakhir</td>
                                    <td>{{ \Carbon\Carbon::parse($interConfig['last_check'])->format('j F Y, H:i') }}</td>
                                    <td class="font-weight-bold">Tanggal Terahir data SIMAN </td>
                                    <td>{{ \Carbon\Carbon::parse($interConfig['last_update'])->format('j F Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Tanggal Pengecekan Selanjutnya</td>
                                    <td>{{ \Carbon\Carbon::parse($interConfig['next_check'])->format('j F Y, H:i') }}</td>
                                    <td class="font-weight-bold">Status Koneksi Terahir Data SIMAN </td>
                                    <td class="font-weight-bold">{!! $interConfig['last_status'] == '200' ? '<span style="color: #28d228;">Success<spam>' : '<span style="color: red;">Failed<spam>' !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered  m-table m-table--head-bg-info table-hover">
                            <thead>
                                <tr>
                                    <th width="50px" class="text-center align-middle"> No  </th>
                                    <th class="text-center align-middle"> Kategori Asset </th>
                                    <th width="100px" class="text-center align-middle"> Jumlah </th>
                                    <th width="100px" class="text-center align-middle"> Jumlah Real </th>
                                    <th width="100px" class="text-center align-middle"> Status </th>
                                    <th width="200px" class="text-center align-middle"> Tanggal Update </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $k => $category)
                                    <tr>
                                        <td scope="row" class="text-center"> {{ $k+1 }} </td>
                                        <td> <strong>{{ isset($categoriesRep[$category->table]) ? $categoriesRep[$category->table] : $category->table }}</strong> </td>
                                        <td class="text-right"> <strong>{{ numberFormatIndo($category->count) }}</strong> </td>
                                        <td class="text-right"> <strong>{{ numberFormatIndo($category->count_real) }}</strong> </td>
                                        <td class="text-center"> <span class="m-badge m-badge--{{ $category->status == 1 ? "info" : "danger" }} m-badge--wide">{{ $category->status == 1 ? "Finished" : "Progress" }}</span> </td>
                                        <td class="text-center"> {{ \Carbon\Carbon::parse($category->date)->format('j F Y, H:i') }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

        });
    </script>
@endpush