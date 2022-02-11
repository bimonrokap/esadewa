@extends('template.admin.content')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!--begin::Portlet-->
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="la la-area-chart"></i>
                            </span>
                            <h3 class="m-portlet__head-text"> Grafik {{ $title }} </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="javascript:;" class="m-dropdown__toggle btn btn-success btn-option">
                            <i class="la la-gear"></i> Pilihan
                        </a>
                    </div>
                </div>
                <div class="m-portlet__body block-chart">
                    <div id="chart-def" class="chart"></div>
                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>

    <div class="modal fade" id="modalOptions" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Pilihan </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> &times; </span>
                    </button>
                </div>
                <form class="m-form m-form--label-align-right" action="#" method="POST" id="formModalOption">
                    <div class="modal-body">
                        <div class="m-form__heading">
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label"> Nilai </label>
                                <div class="col-lg-3">
                                    <select name="value" class="form-control select2">
                                        <option value="jumlah">Jumlah / Kuantitas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label"> Filter </label>
                                <div class="col-lg-3">
                                    <select name="category" class="form-control select2">
                                        <option value="">Tanpa Kategori</option>
                                        @foreach($categories as $c => $category)
                                            <option value="{{ $c }}"> {{ $category }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{--@if(!Auth::user()->isSatker())--}}
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label"> Kategori </label>
                                <div class="col-lg-3">
                                    <select name="series" class="form-control select2">
                                        @foreach($series as $s=> $ser)
                                            <option value="{{ $s }}"> {{ $ser }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{--@endif--}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> Tutup </button>
                        <button type="submit" class="btn btn-primary"> Proses </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')<script type="text/javascript">

    $(document).ready(function () {
        $("#wilayah").hide();
        cat = "category";
        var SelectProv = $('select[name="' + cat + '"]');

        SelectProv.on('change', function() {
            if(this.value == 'wilayah'){
                $("#wilayah").hide();
            }else {
                $("#wilayah").hide();
            }
        });


        var chartConfig = {
            "chart-def": {
                value : 'jumlah',
                category : null,
                series: 'sertifikat'
            }
        };

        Highcharts.setOptions({
            lang: {
                decimalPoint: ',',
                thousandsSep: '.'
            },
            chart: {
                type: 'column',
                // options3d: {
                //     enabled: true,
                //     alpha: 15,
                //     beta: 15,
                //     depth: 50,
                //     viewDistance: 25
                // }
            },
            title: {
                text: ''
            },
            yAxis: {
                title: {
                    text: '',
                    // skew3d: true,
                    // style: {
                    //     fontSize: '18px'
                    // }
                }
            },
            xAxis: {
                labels: {
                    text: '',
                    // skew3d: true,
                    // style: {
                    //     fontSize: '18px'
                    // }
                }
            },
            legend: {
                enabled: true
            },
            plotOptions: {
                column: {
                    // depth: 25
                },
                pie: {
                    // depth: 35
                },
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                    }
                }
            },
            colors: ["#01b8aa", "#fd625e", "#374649", "#f2c80f"]
        });

        var modalOption = $('#modalOptions');

        $('.btn-option').click(function () {
            let id = 'chart-def';
            let config = chartConfig[id];
            if(typeof config !== 'undefined') {
                if(config.category == null) {
                    $('select[name="category"]', modalOption).val('');
                } else {
                    $('select[name="category"]', modalOption).val(config.category);
                }
                $('select[name="value"]', modalOption).val(config.value);
                $('select[name="series"]', modalOption).val(config.series);

                $('button[type="submit"]', modalOption).val(id);

                modalOption.modal('show');
            }
        });

        function get()
        {
            var id = 'chart-def';
            let config = chartConfig[id];
            config.category = $('select[name="category"]', modalOption).val();
            config.series = $('select[name="series"]', modalOption).val();

            modalOption.modal('hide');
            mApp.block('#' + id);

            $.post('{{ route("admin.dashboard.detailDiagram", $slug) }}', $('#formModalOption').serializeArray(), function (res) {
                Highcharts.chart(id, {
                    chart: {
                        type: 'column'
                    },
                    yAxis: {
                        title: {
                            text: 'Jumlah / Kuantitas'
                        },
                    },
                    xAxis: {
                        categories: res.category
                    },
                    series: res.series
                });
            });
        }

        get();

        $('#formModalOption').submit(function () {
            get();

            return false;
        });
    });
</script>
@endpush