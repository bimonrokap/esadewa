var Barang = function() {

	return {
		//main function to initiate the module
		init: function(options) {
            options = $.extend({
                url : "",
                addons: {},
                maxBarang: 0,
                param: {},
                reloadOnOpen: false
            }, options);

            if(options.reloadOnOpen) {
                $('#modalBarang').on('shown.bs.modal', function () {
                    let val = $('#kategori-barang').val();
                    if(val !== "") {
                        getTableByCategory(val)
                    }
                })
            }

            var kategoriValue = '';
            let elKategoriBarang = $('#kategori-barang');
            elKategoriBarang.change(function () {
                let val = $(this).val();

                getTableByCategory(val)
            });

            function getTableByCategory(category) {
                mApp.block('#con-table', {
                    overlayColor: '#000000',
                    type: 'loader',
                    state: 'success',
                    message: 'Please wait...'
                });

                $.get(options.url, { categoryBarang: category, addParam: options.param }, function (html) {
                    $('#con-table').html(html);
                    kategoriValue = elKategoriBarang.val();
                })
                    .always(function() {
                        mApp.unblock('#con-table');
                    })
                    .fail(function () {
                        $.notify("Tidak bisa menampilkan data!", {
                            type: "danger",
                            allow_dismiss: true,
                            timer: 1000,
                            delay: 3000,
                            z_index: 1051,
                            animate: {
                                enter: 'animated bounceIn',
                                exit: 'animated bounceOut'
                            }
                        });
                    });
            }

            var nilaiBarang = 0;
            $('#con-table').on('click', '.btn-barang', function () {
                var attr = $(this).data('attr');

                if(options.maxBarang == 0 || jmlBarang < options.maxBarang) {
                    // Cek jika kategori barang tidak ada
                    if(typeof barang[kategoriValue] === 'undefined') {
                        barang[kategoriValue] = {};
                    }

                    // Cek jika barang belum ada
                    if(typeof barang[kategoriValue][attr.id] === 'undefined') {
                        barang[kategoriValue][attr.id] = attr;
                        nilaiBarang += parseInt(attr.nilai);

                        jmlBarang++;
                        checkData();

                        let action = `<button type="button" data-category="`+kategoriValue+`" data-id="`+attr.id+`" title="Hapus Barang" class="btn btn-danger btn-xs m-btn m-btn--icon m-btn--icon-only btn-hapus">
                                    <i class="la la-trash"></i>
                                </button>`;

                        $('#con-barang').append(`
                        <tr>
                            <td scope="row" class="text-center number"> `+jmlBarang+` </td>
                            <td class="text-center"> `+attr.nup+` </td>
                            <td> `+attr.kode+` </td>
                            <td> `+attr.nama+` </td>
                            <td class="text-right"> Rp `+$.number( attr.nilai, 0, ',', '.' )+` </td>
                            <td> `+attr.category+` </td>
                            <td class="text-center">`+action+`</td>
                        </tr>
                    `);
                        $.notify("Berhasil Mendaftarkan Barang!", {
                            type: "success",
                            allow_dismiss: true,
                            timer: 1000,
                            delay: 3000,
                            z_index: 1051,
                            animate: {
                                enter: 'animated bounceIn',
                                exit: 'animated bounceOut'
                            }
                        });
                    } else {
                        $.notify("Data Sudah Terinputkan!", {
                            type: "danger",
                            allow_dismiss: true,
                            timer: 1000,
                            delay: 3000,
                            z_index: 1051,
                            animate: {
                                enter: 'animated bounceIn',
                                exit: 'animated bounceOut'
                            }
                        });
                    }
                } else {
                    $.notify("Maximal jumlah barang sudah tercapai!", {
                        type: "danger",
                        allow_dismiss: true,
                        timer: 1000,
                        delay: 3000,
                        z_index: 1051,
                        animate: {
                            enter: 'animated bounceIn',
                            exit: 'animated bounceOut'
                        }
                    });
                }

            });

            // Hapus Barang
            $('#con-barang').on('click', '.btn-hapus', function () {
                var tr = $(this).closest('tr');
                var category = parseInt($(this).data('category'));
                var id = parseInt($(this).data('id'));

                var attr = barang[category][id];
                nilaiBarang -= attr.nilai;

                delete barang[category][id];
                jmlBarang--;
                checkData();
                tr.remove();
                reSortId();
            });

            $('.btn-add').click(function () { $('#modalBarang').modal('show'); });

            function checkData() {
                if(jmlBarang > 0) {
                    $('#empty-row').hide();
                    $('#a-generate').show();
                } else {
                    $('#empty-row').show();
                    $('#a-generate').hide();
                }

                $('#jml-barang').text(jmlBarang);
                $('#nilai-barang').text($.number(nilaiBarang, 0, ',', '.' ));
                var url = $('#tmp-url').attr('href');
                $('#a-generate').attr('href', url + '&nilai=' + nilaiBarang);
            }

            function reSortId() {
                var i = 1;
                $('#con-barang td.number').each(function (index, value) {
                    $(this).text(i++);
                })
            }
		},

		initBongkaran: function(options) {
            options = $.extend({
                url : "",
                addons: {},
                maxBarang: 0,
            }, options);

            var kategoriValue = '';
            let elKategoriBarang = $('#kategori-barang');
            elKategoriBarang.change(function () {
                var val = $(this).val();

                mApp.block('#con-table', {
                    overlayColor: '#000000',
                    type: 'loader',
                    state: 'success',
                    message: 'Please wait...'
                });

                $.get(options.url, { categoryBarang: val }, function (html) {
                    $('#con-table').html(html);
                    kategoriValue = elKategoriBarang.val();
                })
            .always(function() {
                    mApp.unblock('#con-table');
                })
                .fail(function () {
                    $.notify("Tidak bisa menampilkan data!", {
                        type: "danger",
                        allow_dismiss: true,
                        timer: 1000,
                        delay: 3000,
                        z_index: 1051,
                        animate: {
                            enter: 'animated bounceIn',
                            exit: 'animated bounceOut'
                        }
                    });
                });
            });

            var nilaiBarang = 0;
            var indexBarang = jmlBarang;
            $('#con-table').on('click', '.btn-barang', function () {
                var attr = $(this).data('attr');

                if(options.maxBarang == 0 || jmlBarang < options.maxBarang) {
                    // Cek jika kategori barang tidak ada
                    if(typeof barang[kategoriValue] === 'undefined') {
                        barang[kategoriValue] = {};
                    }

                    // Cek jika barang belum ada
                    if(typeof barang[kategoriValue][attr.id] === 'undefined') {
                        barang[kategoriValue][attr.id] = attr;
                        nilaiBarang += parseInt(attr.nilai);

                        jmlBarang++;
                        checkData();

                        let action = `<button type="button" data-category="`+kategoriValue+`" data-id="`+attr.id+`" title="Hapus Barang" class="btn btn-danger btn-xs m-btn m-btn--icon m-btn--icon-only btn-hapus">
                                    <i class="la la-trash"></i>
                                </button>`;

                        $('#con-barang').append(`
                        <tr>
                            <td scope="row" class="text-center number"> `+jmlBarang+` </td>
                            <td class="text-center"> `+attr.nup+` </td>
                            <td> `+attr.kode+` </td>
                            <td> `+attr.nama+` </td>
                            <td class="text-right"> Rp `+$.number( attr.nilai, 0, ',', '.' )+` </td>
                            <td> `+attr.category+` </td>
                            <td class="text-center">`+action+`</td>
                        </tr>
                        <tr class="detail-con-barang" data-idindex="`+indexBarang+`">
                            <td></td>
                            <td colspan="6">
                                <div class="m-form-custom-5 row">
                                    <div class="col-lg-6">
                                        <div class="form-group m-form__group">
                                            <label for="inputLuasbangunan"> Luas Bangunan yang Dibongkar  <span class="required">*</span> </label>
                                            <div class="input-group m-input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"> Rp </span>
                                                </div>
                                                <input type="text" class="form-control m-input harga required" id="inputLuasbangunan" name="luas_bangunan[]" placeholder="Luas Bangunan yang Dibongkar" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <table class="table table-bordered m-table m-table--head-bg-info" id="con-barang" style="margin-top: 10px;">
                                            <thead>
                                                <tr>
                                                    <th width="10px"> 
                                                        <button type="button" class="btn btn-success btn-xs m-btn m-btn--icon m-btn--icon-only btn-add-uraian tooltips" title="Tambah Uraian"><i class="la la-plus"></i></button> 
                                                    </th>
                                                    <th> Uraian </th>
                                                    <th width="200px"> Jumlah </th>
                                                    <th width="100px"> Satuan </th>
                                                    <th width="80px"> Aksi </th>
                                                </tr>
                                            </thead>
                                            <tbody>`+addUraian(0, indexBarang)+`</tbody>
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>`);

                        $('.harga', '#con-barang').inputmask('numeric', {
                            digits: 2,
                            groupSeparator: '.',
                            radixPoint: ",",
                            removeMaskOnSubmit: false,
                            autoGroup: true
                        });

                        $.notify("Berhasil Mendaftarkan Barang!", {
                            type: "success",
                            allow_dismiss: true,
                            timer: 1000,
                            delay: 3000,
                            z_index: 1051,
                            animate: {
                                enter: 'animated bounceIn',
                                exit: 'animated bounceOut'
                            }
                        });
                        indexBarang++;
                    } else {
                        $.notify("Data Sudah Terinputkan!", {
                            type: "danger",
                            allow_dismiss: true,
                            timer: 1000,
                            delay: 3000,
                            z_index: 1051,
                            animate: {
                                enter: 'animated bounceIn',
                                exit: 'animated bounceOut'
                            }
                        });
                    }
                } else {
                    $.notify("Maximal jumlah barang sudah tercapai!", {
                        type: "danger",
                        allow_dismiss: true,
                        timer: 1000,
                        delay: 3000,
                        z_index: 1051,
                        animate: {
                            enter: 'animated bounceIn',
                            exit: 'animated bounceOut'
                        }
                    });
                }

            });

            // Hapus Barang
            $('#con-barang').on('click', '.btn-hapus', function () {
                let tr = $(this).closest('tr');
                let detail = tr.next();
                let category = parseInt($(this).data('category'));
                let id = parseInt($(this).data('id'));

                let attr = barang[category][id];
                nilaiBarang -= attr.nilai;

                delete barang[category][id];
                jmlBarang--;
                checkData();
                tr.remove();
                detail.remove();
                reSortId();
            });

            $('.btn-add').click(function () { $('#modalBarang').modal('show'); });

            $('#con-barang').on('click', '.btn-add-uraian', function () {
                let trDetail = $(this).closest('.detail-con-barang');
                let table = $(this).closest('table');
                let index = $('tbody tr', table).length;
                $('tbody', table).append(addUraian(index, trDetail.data('idindex')));

                $('tbody tr:last .harga', table).inputmask('numeric', {
                    digits: 2,
                    groupSeparator: '.',
                    radixPoint: ",",
                    removeMaskOnSubmit: false,
                    autoGroup: true
                });
            });

            $('#con-barang').on('click', '.btn-delete-uraian', function () {
                let tbody = $(this).closest('tbody');
                let tr = $(this).closest('tr');
                tr.remove();

                $('tr', tbody).each(function (index) {
                    $('th:eq(0)', this).text(index+1);
                });
            });

            function checkData() {
                if(jmlBarang > 0) {
                    $('#empty-row').hide();
                    $('#a-generate').show();
                } else {
                    $('#empty-row').show();
                    $('#a-generate').hide();
                }

                $('#jml-barang').text(jmlBarang);
                $('#nilai-barang').text($.number(nilaiBarang, 0, ',', '.' ));
                var url = $('#tmp-url').attr('href');
                $('#a-generate').attr('href', url + '&nilai=' + nilaiBarang);
            }

            function reSortId() {
                var i = 1;
                $('#con-barang td.number').each(function (index, value) {
                    $(this).text(i++);
                })
            }

            function addUraian(index, indexBarang) {
                return `<tr>
                    <th class="text-center">`+(index+1)+`</th>
                    <td> <input type="text" class="form-control m-input required" name="uraian[`+indexBarang+`][]" placeholder="Uraian" /> </td>
                    <td> <input type="text" class="form-control m-input harga required" name="jumlah[`+indexBarang+`][]" placeholder="Jumlah" /> </td>
                    <td> <input type="text" class="form-control m-input" name="satuan[`+indexBarang+`][]" placeholder="Satuan" /> </td>
                    <td class="text-center">`+
                        (index == 0 ? `#` : `<button type="button" class="btn btn-danger btn-xs m-btn m-btn--icon m-btn--icon-only btn-delete-uraian tooltips" title="Hapus Uraian"><i class="la la-trash"></i></button>`)
                    +`</td>
                </tr>`
            }
		}

	};

}();