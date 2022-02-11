<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@index', 'middleware' => ['guest']]);
Route::post('login', ['as' => 'doLogin', 'uses' => 'Auth\LoginController@doLogin', 'middleware' => ['guest']]);

Route::get('admin/logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout', 'middleware' => ['auth']]);

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('asset/file/{slug}/{id}', ['as' => 'asset.file', 'uses' => 'AssetController@file']);
    Route::get('export', ['as' => 'export', 'uses' => 'ExportController@export']);
    Route::get('underconstruction', ['as' => 'underconstruction', 'uses' => function () {
        return view('admin.under');
    }]);

    Route::group(['as' => 'dashboard.', 'prefix' => 'dashboard', 'namespace' => 'Dashboard'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'DashboardController@index']);
        Route::get('diagram', ['as' => 'diagram', 'uses' => 'DashboardController@diagram']);

        Route::get('detail', ['as' => 'detail', 'uses' => 'DashboardController@detail']);
        Route::post('diagram/{slug}', ['as' => 'detailDiagram', 'uses' => 'DashboardController@detailDiagram']);
        Route::get('asset/{slug}', ['as' => 'asset', 'uses' => 'DashboardController@asset']);
    });

    // Asset
    Route::group(['as' => 'asset.', 'prefix' => 'asset', 'namespace' => 'Asset'], function () {
        Route::get('{slug}/export', ['as' => 'export', 'uses' => 'ExportController@export']);
        Route::post('{slug}/import', ['as' => 'import', 'uses' => 'ImportController@import']);

        // Persediaan
        Route::group(['as' => 'persediaan.', 'prefix' => 'persediaan', 'namespace' => 'Persediaan'], function () {
            Route::post('table', ['as' => 'table', 'uses' => 'PersediaanController@table']);
        });
        Route::resource('persediaan', 'Persediaan\PersediaanController', ['except' => ['show']]);

        // Persediaan Masyarakat
        Route::group(['as' => 'psmasyarakat.', 'prefix' => 'psmasyarakat', 'namespace' => 'PersediaanMasyarakat'], function () {
            Route::post('table', ['as' => 'table', 'uses' => 'PersediaanMasyarakatController@table']);
        });
        Route::resource('psmasyarakat', 'PersediaanMasyarakat\PersediaanMasyarakatController', ['except' => ['show']]);

        // Tanah
        Route::group(['as' => 'tanah.', 'prefix' => 'tanah', 'namespace' => 'Tanah'], function () {
            Route::post('table', ['as' => 'table', 'uses' => 'TanahController@table']);
        });
        Route::resource('tanah', 'Tanah\TanahController');

        // Alat Angkutan Bermotor
        Route::group(['as' => 'alatangkutanbermotor.', 'prefix' => 'alatangkutanbermotor', 'namespace' => 'AlatAngkutan'], function () {
            Route::post('table', ['as' => 'table', 'uses' => 'AlatAngkutanController@table']);
        });
        Route::resource('alatangkutanbermotor', 'AlatAngkutan\AlatAngkutanController');

        // Mesin & Peralatan Non TIK
        Route::group(['as' => 'peralatannontik.', 'prefix' => 'peralatannontik', 'namespace' => 'PeralatanNonTik'], function () {
            Route::post('table', ['as' => 'table', 'uses' => 'PeralatanNonTikController@table']);
        });
        Route::resource('peralatannontik', 'PeralatanNonTik\PeralatanNonTikController', ['except' => ['show']]);

        // Mesin & Peralatan Khusus TIK
        Route::group(['as' => 'peralatankhusustik.', 'prefix' => 'peralatankhusustik', 'namespace' => 'PeralatanKhususTik'], function () {
            Route::post('table', ['as' => 'table', 'uses' => 'PeralatanKhususTikController@table']);
        });
        Route::resource('peralatankhusustik', 'PeralatanKhususTik\PeralatanKhususTikController', ['except' => ['show']]);

        // Alat Berat
        Route::group(['as' => 'alatberat.', 'prefix' => 'alatberat', 'namespace' => 'AlatBerat'], function () {
            Route::post('table', ['as' => 'table', 'uses' => 'AlatBeratController@table']);
        });
        Route::resource('alatberat', 'AlatBerat\AlatBeratController', ['except' => ['show']]);

        // Bangunan Gedung
        Route::group(['as' => 'bangunangedung.', 'prefix' => 'bangunangedung', 'namespace' => 'BangunanGedung'], function () {
            Route::post('table', ['as' => 'table', 'uses' => 'BangunanGedungController@table']);
        });
        Route::resource('bangunangedung', 'BangunanGedung\BangunanGedungController');

        // Rumah Negara
        Route::group(['as' => 'rumahnegara.', 'prefix' => 'rumahnegara', 'namespace' => 'RumahNegara'], function () {
            Route::post('table', ['as' => 'table', 'uses' => 'RumahNegaraController@table']);
        });
        Route::resource('rumahnegara', 'RumahNegara\RumahNegaraController');

        // Jalan dan Jembatan
        Route::group(['as' => 'jalanjembatan.', 'prefix' => 'jalanjembatan', 'namespace' => 'JalanJembatan'], function () {
            Route::post('table', ['as' => 'table', 'uses' => 'JalanJembatanController@table']);
        });
        Route::resource('jalanjembatan', 'JalanJembatan\JalanJembatanController', ['except' => ['show']]);

        // Bangunan Air & Irigasi
        Route::group(['as' => 'airirigasi.', 'prefix' => 'airirigasi', 'namespace' => 'AirIrigasi'], function () {
            Route::post('table', ['as' => 'table', 'uses' => 'AirIrigasiController@table']);
        });
        Route::resource('airirigasi', 'AirIrigasi\AirIrigasiController', ['except' => ['show']]);

        // Instalasi Jaringan
        Route::group(['as' => 'instalasijaringan.', 'prefix' => 'instalasijaringan', 'namespace' => 'InstalasiJaringan'], function () {
            Route::post('table', ['as' => 'table', 'uses' => 'InstalasiJaringanController@table']);
        });
        Route::resource('instalasijaringan', 'InstalasiJaringan\InstalasiJaringanController', ['except' => ['show']]);

        // Aset Tetap Lainnya
        Route::group(['as' => 'tetaplainnya.', 'prefix' => 'tetaplainnya', 'namespace' => 'TetapLainnya'], function () {
            Route::post('table', ['as' => 'table', 'uses' => 'TetapLainnyaController@table']);
        });
        Route::resource('tetaplainnya', 'TetapLainnya\TetapLainnyaController', ['except' => ['show']]);

        // Aset Tak Berwujud
        Route::group(['as' => 'takberwujud.', 'prefix' => 'takberwujud', 'namespace' => 'TakBerwujud'], function () {
            Route::post('table', ['as' => 'table', 'uses' => 'TakBerwujudController@table']);
        });
        Route::resource('takberwujud', 'TakBerwujud\TakBerwujudController', ['except' => ['show']]);

        // Aset Renovasi
        Route::group(['as' => 'renovasi.', 'prefix' => 'renovasi', 'namespace' => 'Renovasi'], function () {
            Route::post('table', ['as' => 'table', 'uses' => 'RenovasiController@table']);
        });
        Route::resource('renovasi', 'Renovasi\RenovasiController', ['except' => ['show']]);

        // Aset Konstruksi dalam Pengerjaan
        Route::group(['as' => 'konstruksidalampengerjaan.', 'prefix' => 'konstruksidalampengerjaan', 'namespace' => 'KonstruksiDalamPengerjaan'], function () {
            Route::post('table', ['as' => 'table', 'uses' => 'KonstruksiDalamPengerjaanController@table']);
        });
        Route::resource('konstruksidalampengerjaan', 'KonstruksiDalamPengerjaan\KonstruksiDalamPengerjaanController', ['except' => ['show']]);
    });

    // Monitoring
    Route::group(['as' => 'monitoring.', 'prefix' => 'monitoring', 'namespace' => 'Monitoring'], function () {

        // Monitoring
        Route::group(['as' => 'kelengkapan.', 'prefix' => 'kelengkapan', 'namespace' => 'Kelengkapan'], function () {
            Route::get('export', ['as' => 'export', 'uses' => 'KelengkapanController@export']);
            Route::get('table}', ['as' => 'table', 'uses' => 'KelengkapanController@table']);
            Route::get('asset/{slug}', ['as' => 'asset.detail', 'uses' => 'AssetController@asset']);
            Route::get('asset/{slug}/export', ['as' => 'asset.export', 'uses' => 'AssetController@export']);
            Route::get('asset/{slug}/table', ['as' => 'asset.table', 'uses' => 'AssetController@table']);

            Route::get('satker/{satker}', ['as' => 'satker', 'uses' => 'SatkerController@index']);
            Route::get('satker/{satker}/{asset}', ['as' => 'satker.asset', 'uses' => 'SatkerController@asset']);
            Route::get('satker/{satker}/{asset}/export', ['as' => 'satker.asset.export', 'uses' => 'SatkerController@export']);
            Route::get('satker/{satker}/{asset}/table', ['as' => 'satker.asset.table', 'uses' => 'SatkerController@assetTable']);
        });
        Route::resource('kelengkapan', 'Kelengkapan\KelengkapanController', ['only' => ['index']]);

        // Interconnection
        Route::resource('interconnection', 'Interconnection\InterconnectionController', ['only' => ['index']]);

        // SIMAK
        Route::group(['as' => 'simak.', 'prefix' => 'simak', 'namespace' => 'Simak'], function () {
            Route::get('/', ['as' => 'index', 'uses' => 'SimakController@index']);
            Route::get('getSatker', ['as' => 'getSatker', 'uses' => 'SimakController@getSatker']);
            Route::post('upload', ['as' => 'upload', 'uses' => 'SimakController@upload']);
            Route::get('download/batch', ['as' => 'downloadBatch', 'uses' => 'SimakController@downloadBatch']);
            Route::get('download/batchAll', ['as' => 'downloadBatchAll', 'uses' => 'SimakController@downloadBatchAll']);
            Route::get('download/{id?}', ['as' => 'download', 'uses' => 'SimakController@download']);
            Route::delete('{id?}', ['as' => 'delete', 'uses' => 'SimakController@destroy']);
        });

        // PSP
        Route::group(['as' => 'psp.', 'prefix' => 'psp', 'namespace' => 'Psp'], function () {
            Route::get('export', ['as' => 'export', 'uses' => 'PspController@export']);
            Route::get('{kode}/export', ['as' => 'exportSatker', 'uses' => 'PspController@exportSatker']);
        });
        Route::resource('psp', 'Psp\PspController', ['only' => ['index', 'show']]);

        // Sertipikasi
        Route::group(['as' => 'sertipikasi.', 'prefix' => 'sertipikasi', 'namespace' => 'Sertipikasi'], function () {
            Route::get('gettable', ['as' => 'gettable', 'uses' => 'SertipikasiController@getTable']);
            Route::post('table', ['as' => 'table', 'uses' => 'SertipikasiController@table']);
            Route::post('{id}/selesai', ['as' => 'selesai', 'uses' => 'SertipikasiController@selesai']);
        });
        Route::resource('sertipikasi', 'Sertipikasi\SertipikasiController');

        // Penghapusan
        Route::group(['as' => 'penghapusan.', 'prefix' => 'penghapusan', 'namespace' => 'Penghapusan'], function () {
            Route::get('export', ['as' => 'export', 'uses' => 'PenghapusanController@export']);
            Route::post('{id}/tableTransaksi/{year}', ['as' => 'tableTransaksi', 'uses' => 'PenghapusanController@tableTransaksi']);
            Route::post('{id}/tableDokumen/{year}', ['as' => 'tableDokumen', 'uses' => 'PenghapusanController@tableDokumen']);

            // Rkbmn
            Route::group(['as' => 'data.', 'prefix' => 'data'], function () {
                Route::post('table', ['as' => 'table', 'uses' => 'DataController@table']);
                Route::post('{id}/tableDetail', ['as' => 'tableDetail', 'uses' => 'DataController@tableDetail']);
            });
            Route::resource('data', 'DataController', ['except' => ['edit', 'update']]);
        });
        Route::resource('penghapusan', 'Penghapusan\PenghapusanController', ['only' => ['index', 'show']]);
    });

    // Pengelolaan
    Route::group(['as' => 'pengelolaan.', 'prefix' => 'pengelolaan', 'namespace' => 'Pengelolaan'], function () {

        // Penjualan
        Route::group(['as' => 'penjualan.', 'prefix' => 'penjualan'], function () {
            Route::get('gettable', ['as' => 'gettable', 'uses' => 'PenjualanController@getTable']);
            Route::post('table', ['as' => 'table', 'uses' => 'PenjualanController@table']);
            Route::post('{id}/imageUpload', ['as' => 'imageUpload', 'uses' => 'PenjualanController@imageUpload']);
            Route::delete('imageDelete/{id?}/{type?}', ['as' => 'imageDelete', 'uses' => 'PenjualanController@imageDelete']);
            Route::get('{id}/verif', ['as' => 'verif', 'uses' => 'PenjualanController@verif']);
            Route::post('{id}/verif', ['as' => 'doVerif', 'uses' => 'PenjualanController@storeVerif']);
            Route::get('{id}/disposisi', ['as' => 'disposisi', 'uses' => 'PenjualanController@disposisi']);
            Route::post('{id}/disposisi', ['as' => 'doDisposisi', 'uses' => 'PenjualanController@storeDisposisi']);
            Route::get('{id}/selesai', ['as' => 'selesai', 'uses' => 'PenjualanController@selesai']);
            Route::post('{id}/selesai', ['as' => 'doSelesai', 'uses' => 'PenjualanController@storeSelesai']);
            Route::get('{id}/draft/{slug}', ['as' => 'draft', 'uses' => 'PenjualanController@draft']);
            Route::get('{id}/lampiran', ['as' => 'lampiran', 'uses' => 'PenjualanController@lampiran']);
        });
        Route::resource('penjualan', 'PenjualanController');

        // Bongkaran
        Route::group(['as' => 'bongkaran.', 'prefix' => 'bongkaran'], function () {
            Route::get('gettable', ['as' => 'gettable', 'uses' => 'BongkaranController@getTable']);
            Route::post('table', ['as' => 'table', 'uses' => 'BongkaranController@table']);
            Route::post('{id}/imageUpload', ['as' => 'imageUpload', 'uses' => 'BongkaranController@imageUpload']);
            Route::delete('imageDelete/{id?}/{type?}', ['as' => 'imageDelete', 'uses' => 'BongkaranController@imageDelete']);
            Route::get('{id}/verif', ['as' => 'verif', 'uses' => 'BongkaranController@verif']);
            Route::post('{id}/verif', ['as' => 'doVerif', 'uses' => 'BongkaranController@storeVerif']);
            Route::get('{id}/disposisi', ['as' => 'disposisi', 'uses' => 'BongkaranController@disposisi']);
            Route::post('{id}/disposisi', ['as' => 'doDisposisi', 'uses' => 'BongkaranController@storeDisposisi']);
            Route::get('{id}/selesai', ['as' => 'selesai', 'uses' => 'BongkaranController@selesai']);
            Route::post('{id}/selesai', ['as' => 'doSelesai', 'uses' => 'BongkaranController@storeSelesai']);
            Route::get('{id}/tindakLanjut', ['as' => 'tindakLanjut', 'uses' => 'BongkaranController@tindakLanjut']);
            Route::post('{id}/tindakLanjut', ['as' => 'doTindakLanjut', 'uses' => 'BongkaranController@storeTindakLanjut']);
            Route::get('{id}/draft/{slug}', ['as' => 'draft', 'uses' => 'BongkaranController@draft']);
            Route::get('{id}/lampiran', ['as' => 'lampiran', 'uses' => 'BongkaranController@lampiran']);
        });
        Route::resource('bongkaran', 'BongkaranController');

        // Sewa
        Route::group(['as' => 'sewa.', 'prefix' => 'sewa'], function () {
            Route::get('gettable', ['as' => 'gettable', 'uses' => 'SewaController@getTable']);
            Route::post('table', ['as' => 'table', 'uses' => 'SewaController@table']);
            Route::post('{id}/imageUpload', ['as' => 'imageUpload', 'uses' => 'SewaController@imageUpload']);
            Route::delete('imageDelete/{id?}/{type?}', ['as' => 'imageDelete', 'uses' => 'SewaController@imageDelete']);
            Route::get('{id}/verif', ['as' => 'verif', 'uses' => 'SewaController@verif']);
            Route::post('{id}/verif', ['as' => 'doVerif', 'uses' => 'SewaController@storeVerif']);
            Route::get('{id}/disposisi', ['as' => 'disposisi', 'uses' => 'SewaController@disposisi']);
            Route::post('{id}/disposisi', ['as' => 'doDisposisi', 'uses' => 'SewaController@storeDisposisi']);
            Route::get('{id}/selesai', ['as' => 'selesai', 'uses' => 'SewaController@selesai']);
            Route::post('{id}/selesai', ['as' => 'doSelesai', 'uses' => 'SewaController@storeSelesai']);
            Route::get('{id}/tindakLanjut', ['as' => 'tindakLanjut', 'uses' => 'SewaController@tindakLanjut']);
            Route::post('{id}/tindakLanjut', ['as' => 'doTindakLanjut', 'uses' => 'SewaController@storeTindakLanjut']);
            Route::get('{id}/draft/{slug}', ['as' => 'draft', 'uses' => 'SewaController@draft']);
            Route::get('{id}/lampiran', ['as' => 'lampiran', 'uses' => 'SewaController@lampiran']);
        });
        Route::resource('sewa', 'SewaController');

        // Penghapusan
        Route::group(['as' =>'penghapusan.', 'prefix' => 'penghapusan'], function () {
            Route::get('penjualan', ['as' => 'penjualan', 'uses' => 'PenghapusanController@penjualan']);
            Route::get('detailPenjualan/{id?}', ['as' => 'detailPenjualan', 'uses' => 'PenghapusanController@detailPenjualan']);
            Route::get('{type}/create', ['as' => 'create', 'uses' => 'PenghapusanController@create']);
            Route::post('{type}/store', ['as' => 'store', 'uses' => 'PenghapusanController@store']);
            Route::get('gettable', ['as' => 'gettable', 'uses' => 'PenghapusanController@getTable']);
            Route::post('table', ['as' => 'table', 'uses' => 'PenghapusanController@table']);
            Route::post('{id}/imageUpload', ['as' => 'imageUpload', 'uses' => 'PenghapusanController@imageUpload']);
            Route::delete('imageDelete/{id?}/{type?}', ['as' => 'imageDelete', 'uses' => 'PenghapusanController@imageDelete']);
            Route::get('{id}/verif', ['as' => 'verif', 'uses' => 'PenghapusanController@verif']);
            Route::post('{id}/verif', ['as' => 'doVerif', 'uses' => 'PenghapusanController@storeVerif']);
            Route::get('{id}/disposisi', ['as' => 'disposisi', 'uses' => 'PenghapusanController@disposisi']);
            Route::post('{id}/disposisi', ['as' => 'doDisposisi', 'uses' => 'PenghapusanController@storeDisposisi']);
            Route::get('{id}/selesai', ['as' => 'selesai', 'uses' => 'PenghapusanController@selesai']);
            Route::post('{id}/selesai', ['as' => 'doSelesai', 'uses' => 'PenghapusanController@storeSelesai']);
            Route::get('{id}/draft/{slug}', ['as' => 'draft', 'uses' => 'PenghapusanController@draft']);
            Route::get('{id}/lampiran', ['as' => 'lampiran', 'uses' => 'PenghapusanController@lampiran']);
        });
        Route::resource('penghapusan', 'PenghapusanController', ['except' => ['create', 'store']]);

    });

    // Pengadaan
    Route::group(['as' => 'pengadaan.', 'prefix' => 'pengadaan', 'namespace' => 'Pengadaan'], function () {

        // Rkbmn
        Route::group(['as' => 'rkbmn.', 'prefix' => 'rkbmn'], function () {
            Route::post('table', ['as' => 'table', 'uses' => 'RkbmnController@table']);
            Route::post('{id}/tableDetail', ['as' => 'tableDetail', 'uses' => 'RkbmnController@tableDetail']);
            Route::post('{id}/paguAlokasi/{rkbmn}', ['as' => 'pagu', 'uses' => 'RkbmnController@pagu']);
        });
        Route::resource('rkbmn', 'RkbmnController');

        // Usulan
        Route::group(['as' => 'usulan.', 'prefix' => 'usulan'], function () {
            Route::get('{type}/create/{tanah?}', ['as' => 'create', 'uses' => 'UsulanController@create']);
            Route::post('{type}/store/{tanah?}', ['as' => 'store', 'uses' => 'UsulanController@store']);
            Route::post('table', ['as' => 'table', 'uses' => 'UsulanController@table']);
            Route::get('gettable', ['as' => 'gettable', 'uses' => 'UsulanController@getTable']);
            Route::get('rkbmn', ['as' => 'rkbmn', 'uses' => 'UsulanController@rkbmn']);
            Route::post('tableRkbmn', ['as' => 'tableRkbmn', 'uses' => 'UsulanController@tableRkbmn']);
            Route::get('detailRkbmn/{id?}', ['as' => 'detailRkbmn', 'uses' => 'UsulanController@detailRkbmn']);

            Route::post('{id}/imageUpload', ['as' => 'imageUpload', 'uses' => 'UsulanController@imageUpload']);
            Route::delete('imageDelete/{id?}/{type?}', ['as' => 'imageDelete', 'uses' => 'UsulanController@imageDelete']);
            Route::post('{id}/fileUpload', ['as' => 'fileUpload', 'uses' => 'UsulanController@fileUpload']);
            Route::delete('fileDelete/{id?}/{type?}', ['as' => 'fileDelete', 'uses' => 'UsulanController@fileDelete']);

            Route::get('{id}/verif', ['as' => 'verif', 'uses' => 'UsulanController@verif']);
            Route::post('{id}/verif', ['as' => 'doVerif', 'uses' => 'UsulanController@storeVerif']);
            Route::get('{id}/disposisi', ['as' => 'disposisi', 'uses' => 'UsulanController@disposisi']);
            Route::post('{id}/disposisi', ['as' => 'doDisposisi', 'uses' => 'UsulanController@storeDisposisi']);
            Route::get('{id}/selesai', ['as' => 'selesai', 'uses' => 'UsulanController@selesai']);
            Route::post('{id}/selesai', ['as' => 'doSelesai', 'uses' => 'UsulanController@storeSelesai']);
        });
        Route::resource('usulan', 'UsulanController', ['except' => ['create', 'store']]);

    });

    // Lapor
    Route::group(['as' => 'lapor.', 'prefix' => 'lapor', 'namespace' => 'Lapor'], function () {
        Route::post('table', ['as' => 'table', 'uses' => 'LaporController@table']);
        Route::get('{id}/detailAsset/{category}', ['as' => 'detailAsset', 'uses' => 'LaporController@detailAsset']);

        Route::post('{id}/imageUpload', ['as' => 'imageUpload', 'uses' => 'LaporController@imageUpload']);
        Route::delete('imageDelete/{id?}', ['as' => 'imageDelete', 'uses' => 'LaporController@imageDelete']);
    });
    Route::resource('lapor', 'Lapor\LaporController');

    // Master
    Route::group(['as' => 'master.', 'prefix' => 'master', 'namespace' => 'Master'], function () {

        // Import
        Route::resource('import', 'ImportController', ['only' => ['index', 'store']]);

        // Role
        Route::group(['as' => 'role.', 'prefix' => 'role'], function () {
            Route::post('table', ['as' => 'table', 'uses' => 'RoleController@table']);
            Route::get('{id}/access', ['as' => 'access', 'uses' => 'RoleController@access']);
            Route::post('{id}/access', ['as' => 'storeaccess', 'uses' => 'RoleController@storeAccess']);
        });
        Route::resource('role', 'RoleController', ['except' => ['show']]);

        // User
        Route::group(['as' => 'user.', 'prefix' => 'user'], function () {
            Route::post('table', ['as' => 'table', 'uses' => 'UserController@table']);
            Route::get('profile', ['as' => 'profile', 'uses' => 'UserController@profile']);
            Route::post('updateprofile', ['as' => 'updateprofile', 'uses' => 'UserController@updateprofile']);
            Route::post('updatesatker', ['as' => 'updatesatker', 'uses' => 'UserController@updatesatker']);
            Route::post('photosatker', ['as' => 'photosatker', 'uses' => 'UserController@photosatker']);
        });
        Route::resource('user', 'UserController', ['except' => ['show']]);

        // Doc
        Route::group(['as' => 'doc.', 'prefix' => 'doc'], function () {
            Route::post('table', ['as' => 'table', 'uses' => 'DocController@table']);
            Route::get('{id}/generate', ['as' => 'generate', 'uses' => 'DocController@generate']);
            Route::post('{id}/default', ['as' => 'default', 'uses' => 'DocController@default']);
        });
        Route::resource('doc', 'DocController');

        // Satker
        Route::group(['as' => 'satker.', 'prefix' => 'satker'], function () {
            Route::post('table', ['as' => 'table', 'uses' => 'SatkerController@table']);

            Route::group(['as' => 'tingkatbanding.', 'prefix' => 'tingkatbanding'], function () {
                Route::post('table', ['as' => 'table', 'uses' => 'TingkatBandingController@table']);
            });
            Route::resource('tingkatbanding', 'TingkatBandingController', ['except' => ['show']]);
        });
        Route::resource('satker', 'SatkerController', ['only' => ['index', 'edit', 'update', 'show']]);

        // Faq
        Route::group(['as' => 'faq.', 'prefix' => 'faq'], function () {
            Route::post('table', ['as' => 'table', 'uses' => 'FaqController@table']);
        });
        Route::resource('faq', 'FaqController', ['except' => ['show']]);

        // Usulan
        Route::group(['as' => 'usulan.', 'prefix' => 'usulan'], function () {
            Route::get('data', ['as' => 'data', 'uses' => 'UsulanController@data']);
        });
        Route::resource('usulan', 'UsulanController', ['only' => ['index', 'store']]);

        // Tentang Aplikasi
        Route::group(['as' => 'about.', 'prefix' => 'about'], function () {
        });
        Route::resource('about', 'AboutController', ['only' => ['index', 'store']]);
    });

    // Help
    Route::group(['as' => 'help.', 'prefix' => 'help', 'namespace' => 'Help'], function () {

        // About
        Route::group(['as' => 'about.', 'prefix' => 'about'], function () {
        });
        // Route::resource('about', 'AboutController', ['only' => ['index', 'edit', 'update', 'show']]);

        // Regulation
        Route::group(['as' => 'regulation.', 'prefix' => 'regulation'], function () {
            Route::get('data/{id?}', ['as' => 'data', 'uses' => 'RegulationController@data']);
            Route::get('create/{type}/{id?}', ['as' => 'create', 'uses' => 'RegulationController@create']);
            Route::post('store/{type}/{id?}', ['as' => 'store', 'uses' => 'RegulationController@store']);
            Route::post('table/{id?}', ['as' => 'table', 'uses' => 'RegulationController@table']);
        });
        Route::resource('regulation', 'RegulationController', ['except' => ['create', 'store']]);
        Route::group(['as' => 'regulation.', 'prefix' => 'regulation'], function () {
            Route::get('{id?}', ['as' => 'show', 'uses' => 'RegulationController@show']);
        });

        // Tutorial
        Route::group(['as' => 'tutorial.', 'prefix' => 'tutorial'], function () {
            Route::get('data/{id?}', ['as' => 'data', 'uses' => 'TutorialController@data']);
            Route::get('create/{type}/{id?}', ['as' => 'create', 'uses' => 'TutorialController@create']);
            Route::post('store/{type}/{id?}', ['as' => 'store', 'uses' => 'TutorialController@store']);
            Route::post('table/{id?}', ['as' => 'table', 'uses' => 'TutorialController@table']);
        });
        Route::resource('tutorial', 'TutorialController', ['except' => ['create', 'store']]);
        Route::group(['as' => 'tutorial.', 'prefix' => 'tutorial'], function () {
            Route::get('{id?}', ['as' => 'show', 'uses' => 'TutorialController@show']);
        });

        // Faq
        Route::group(['as' => 'faq.', 'prefix' => 'faq'], function () {
        });
        Route::resource('faq', 'FaqController', ['only' => ['index', 'edit', 'update', 'show']]);
    });
});
