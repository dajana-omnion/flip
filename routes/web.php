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
	//factory(App\Model\userRole::class)->create();
    return view('login');
})->name('login')->middleware('guest');

Route::get('/logout',function(){
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::get('/home', function () {
	//factory(App\Model\userRole::class)->create();
    $data['title'] = 'Omni Hotel';
    $data['deskripsi_title'] = 'Hotel management system';
    return view('backend.dashboard',$data);
})->middleware('auth')->name('home');

Route::post('/ceklogin','Login\loginCtrl@checkLogin')->name('login.check');

//
Route::group(['middleware' => ['auth'],'prefix' => 'Admin','namespace' => 'Admin'], function () {
    Route::get('/','DashboardCtrl@index')->name('dashboard.index');
    
    Route::get('checkin/tamu','CheckinCtrl@listCheckin')->name('checkin.tamu');

    Route::resource('kamar','KamarCtrl');
    Route::resource('typekamar','TypeKamarCtrl');
    Route::resource('kategorilayanan','layananKategoriCtrl');
    Route::resource('layanan','LayananCtrl');
    Route::resource('tamu','TamuCtrl');
    Route::resource('user','UserCtrl');
    Route::resource('perusahaan','PerusahaanCtrl');
    Route::resource('checkin','CheckinCtrl');
    Route::resource('transaksilayanan','TransaksiLayananCtrl');
    Route::resource('berita','BeritaCtrl');

    Route::get('checkout','CheckinCtrl@checkout')->name('checkin.checkout');
    Route::get('checkout/print/{id}','CheckinCtrl@checkoutprint')->name('checkin.checkoutprint');
    Route::get('checkout/{id}','CheckinCtrl@checkoutedit')->name('checkin.checkoutedit');

    Route::post('checkout','CheckinCtrl@checkoutsave')->name('checkin.checkoutsave');

    Route::get('laporan/{type}','LaporanCtrl@laporan')->name('laporan')->middleware('role');
});

Route::group(['middleware' => 'auth','prefix' => 'api','namespace' => 'Admin'], function () {
	Route::get('kamar','KamarCtrl@getKamar')->name('api.kamar');
    Route::get('typekamar','typeKamarCtrl@getTypeKamar')->name('api.typekamar');
    Route::get('kategorilayanan','layananKategoriCtrl@getLayananKategori')->name('api.layanankategori');
	Route::get('layanan','LayananCtrl@getLayanan')->name('api.layanan');
    Route::get('tamu','TamuCtrl@getTamu')->name('api.tamu');
    Route::get('user','UserCtrl@getUser')->name('api.user');
    Route::get('berita','BeritaCtrl@getBerita')->name('api.berita');

    Route::get('getlayanan/{id}','TransaksiLayananCtrl@getLayanan')->name('api.transaksilayanan');
    Route::get('getkamarkotor','TransaksiLayananCtrl@getKamarKotor')->name('api.kamarkotor');

    Route::post('getlaporan/{kamar}','LaporanCtrl@getLaporan')->name('api.laporankamar');
});