var TableDatatablesAjax = function() {

	$.fn.dataTable.Api.register('column().title()', function() {
		return $(this.header()).text().trim();
	});

	return {
		//main function to initiate the module
		init: function(options) {
            options = $.extend({
                table : "#datatable_ajax",
                data: {},
                url : "",
                columns : [],
                order : [],
                tableajaxurl: window.location.pathname,
                fixedColumns : false,
                additionalFilter: true
            }, options);

            let table = $(options.table);

            // begin first table
            let dataTable = table.DataTable({
                orderCellsTop: true,
                responsive: options.fixedColumns === false,
                scrollX: options.fixedColumns !== false,
                fixedColumns: options.fixedColumns,

                //== Pagination settings
                dom: `<'row'<'col-sm-12'tr>>
				<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
                // read more: https://datatables.net/examples/basic_init/dom.html

                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],

                pageLength: 10,

                language: {
                    'lengthMenu': 'Display _MENU_',
                },

                searchDelay: 500,
                stateSave: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: options.url,
                    type: 'POST',
                    data: options.data,
                },
                drawCallback: function(oSettings){
                    if(oSettings._iRecordsTotal > 1) {
                        $('.tooltips').tooltip();
                    }
                },
                fnStateSaveParams: function (oSettings, oData) {
                    let parent = wraper.parent();

                    oData['filter'] = $('.filter-additional .filter', parent).serializeArray();
                    localStorage.setItem('DataTables_' + oSettings.sInstance + '_' + window.location.pathname, JSON.stringify(oData) );
                },
                fnStateLoadParams: function (settings) {
                    let data = JSON.parse( localStorage.getItem('DataTables_' + settings.sInstance + '_' + window.location.pathname));

                    let parent = table.parent();
                    if(data.filter !== "[]" && options.additionalFilter) {
                        $.each(data.filter, function (index, value) {
                            if (value.value !== '') {
                                let ele = $('.filter-additional .filter[name="' + value.name + '"]', parent);

                                ele.closest('.input-group').addClass('filtered');
                                ele.val(value.value).trigger('change');
                            }
                        });
                    }

                    $.each(data.columns, function (index, value) {
                        if (value.search.search !== "") {
                            let ele = $('.form-filter[data-col-index="' + index + '"]', table);
                            if (ele.hasClass('select2')) {
                                ele.val(value.search.search).trigger('change');
                            } else {
                                ele.addClass('filtered');
                                ele.val(value.search.search);
                            }
                        }
                    })
                },
                order: [
                    options.order
                ],
                columns: options.columns,
            });

            let wraper = table.closest('.dataTables_wrapper');

            wraper.on('click', '.btn-submit', function (e) {
                e.preventDefault();

                filterTable()
            });

            var portlet = wraper.closest('.m-portlet');

            $('.btn-refresh', portlet).click(function () {
                dataTable.ajax.reload();
            });


            wraper.on('keyup', 'input.form-filter', function (e) {
                if($(this).val() !== '') {
                    $(this).addClass('filtered');
                } else {
                    $(this).removeClass('filtered');
                }

                if(e.keyCode === 13){
                    filterTable();
                } else {
                    delay(function(){
                        filterTable();
                    }, 400 );
                }
            });

            // var portlet = wraper.closest('.m-portlet');
            // $('.btn-open-search', portlet).click(function () {
            //     $('tr.filter', wraper).toggle();
            // });

            wraper.on('change', 'select.form-filter', function (e) {
                filterTable();
            });

            wraper.on('click', '.btn-reset', function (e) {
                e.preventDefault();

                var rowFilter = $('tr.filter', wraper);
                $(rowFilter).find('.form-filter').each(function(i) {
                    if($(this).hasClass('select2')) {
                        $(this).val('').trigger('change');
                    } else {
                        $(this).val('');
                    }

                    $(this).removeClass('filtered');
                    dataTable.column($(this).data('col-index')).search('', false, false);
                });

                dataTable.table().draw();
            });

            var delay = (function(){
                var timer = 0;
                return function(callback, ms){
                    clearTimeout (timer);
                    timer = setTimeout(callback, ms);
                };
            })();

            $(options.table).on('click', '.info-asset', function(){
                let url = $(this).data('url');

                swal({
                    title: 'Apakah kamu yakin?',
                    text: "Aset ini akan dilakukan Lapor BMN!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak',
                }).then(function(result) {
                    if (result.value) {
                        $('#modalLaporBmn').modal('show');

                        $('#modalLaporBmn textarea[name="uraian"]').val('');

                        $.get(url, function(res){
                            if(res.status){
                                var html = ``;
                                var i = 0;
                                $.each(res.data, function (index, value) {
                                    if(i%2 === 0) {
                                        html += `<tr>`;
                                    }
                                    html += `<th scope="row" width="200px"> `+index+` </th>
                                <td> : `+value+` </td>`;

                                    if(i%2 === 1) {
                                        html += `</tr>`;
                                    }
                                    i++
                                });

                                let form = $('form#form-lapor-bmn');
                                $('input[name="id"]').val(res.param.id);
                                $('input[name="category_asset"]').val(res.param.category_asset);

                                $('#con-detail-aset .table-detail-aset tbody').html(html);
                            } else {
                                swal(
                                    'Gagal',
                                    'Something went wrong.',
                                    'error'
                                );
                            }
                        }, 'json').fail(function() {
                            swal(
                                'Gagal!',
                                'Something went wrong.',
                                'error'
                            );
                        });
                    }
                });

                return false;
            });

            $(options.table).on('click', '.btn-delete', function(){
                var url = $(this).attr('href');

                swal({
                    title: 'Apakah kamu yakin?',
                    text: "Data akan di hapus!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak',
                }).then(function(result) {
                    if (result.value) {
                        swal({
                            title : 'Loading',
                            html : '<img src="'+baseUrl+'/assets/app/media/img/load.gif" width="46px" />',
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });

                        $.post(url, { _method: 'DELETE'}, function(res){
                            if(res.status){
                                swal({
                                    title: 'Berhasil!',
                                    text: 'Data berhasil dihapus.',
                                    type: 'success',
                                    timer: 2000
                                });

                                dataTable.ajax.reload();
                            }else{
                                swal(
                                    'Gagal',
                                    'Something went wrong.',
                                    'error'
                                );
                            }
                        }, 'json').fail(function() {
                            swal(
                                'Gagal!',
                                'Something went wrong.',
                                'error'
                            );
                        });
                    }
                });

                return false;
            });

            function filterTable() {
                let params = {};

                var rowFilter = $('.DTFC_LeftWrapper tr.filter', wraper);
                rowFilter.find('.form-filter').each(function() {
                    let i = $(this).data('col-index');

                    if (!params[i]) {
                        if($(this).is('select') && $(this).val() === '') {
                            params[i] = $(this).val();
                        } else {
                            params[i] = $(this).val();
                        }
                    }
                });

                rowFilter = $('.DTFC_RightWrapper tr.filter', wraper);
                rowFilter.find('.form-filter').each(function() {
                    let i = $(this).data('col-index');

                    if (!params[i]) {
                        if($(this).is('select') && $(this).val() === '') {
                            params[i] = $(this).val();
                        } else {
                            params[i] = $(this).val();
                        }
                    }
                });

                rowFilter = $('tr.filter', wraper);
                rowFilter.find('.form-filter').each(function() {
                    let i = $(this).data('col-index');

                    if (!params[i]) {
                        if($(this).is('select') && $(this).val() === '') {
                            params[i] = $(this).val();
                        } else {
                            params[i] = $(this).val();
                        }
                    }
                });

                $.each(params, function(i, val) {
                    // apply search params to datatable
                    dataTable.column(i).search(val ? val : '', false, false);
                });
                dataTable.table().draw();
            }

            return dataTable;
		}

	};

}();